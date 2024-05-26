<?php

namespace App\Http\Controllers;

use App\Models\Attribute_group;
use App\Models\Product_attribute;
use App\Models\Product_combination;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Brands;
use App\Models\Attributes;
use App\Models\Product_images;
use App\Models\Product_Attrs;
use App\Models\Category_Type;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Session;
use DB;

class ProductsController extends Controller
{
    public function product(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ request
        $keyword = $request->keyword;

        // Lưu từ khóa tìm kiếm vào session
        session()->put('product_keyword', $keyword);

        // Truy vấn sản phẩm với hoặc không có từ khóa tìm kiếm
        $query = Products::orderBy('created_at', 'ASC');
        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
        $products = $query->paginate(3);

        $products_atb = Product_attribute::all();
        $attribute = Attributes::all();

        return view('admin.pages.product', compact('products', 'products_atb', 'attribute'));
    }
    public function product_add()
    {
        $category = Categories::all();
        $attribute = Attributes::all();
        $attribute_group = Attribute_group::all();
        $attribute_color = Attributes::where('attribute_group_id', 1)->get();
        $attribute_size = Attributes::where('attribute_group_id', 2)->get();

        return view('admin.pages.product_add', compact('category', 'attribute', 'attribute_group', 'attribute_color', 'attribute_size'));
    }
    public function product_detail($id)
    {
        $product_attribute = Product_attribute::where('product_id', $id)->get();
        $product_combination = Product_combination::all();
        $product_combination_array = $product_combination->toArray();
        
        $pro_atb = [];
    
        foreach ($product_attribute as $product) {
            // Lọc ra các thuộc tính có product_Attribte_id trùng với id của sản phẩm
            $attributes = array_filter($product_combination_array, function ($attr) use ($product) {
                return $attr['product_attribute_id'] == $product->id;
            });
    
            // Lấy danh sách attribute_id từ các thuộc tính đã lọc
            $attribute_ids = array_values(array_column($attributes, 'attribute_id'));
    
            // Nếu có đúng 2 attribute_id, tạo một phần tử mới cho mảng $pro_atb
            if (count($attribute_ids) == 2) {
                $pro_atb[] = [
                    'attribute_color_id' => $attribute_ids[0],
                    'attribute_size_id' => $attribute_ids[1],
                    'stock' => $product->stock
                ];
            }
        }
        $atb = Attributes::all();
        $product_id = "";
        // Truyền mảng $pro_atb tới view 'admin.pages.product_list'
        return view('admin.pages.product_list', compact('product_attribute', 'pro_atb','atb','product_id'));
    }

    //Create
    public function product_create(Request $req)
    {
        $data = $req->all();

        // Giả sử $C là mảng chứa các id và $b là mảng từ cơ sở dữ liệu
        $H = $data['name_attribute']; // mảng chứa các id
        $C = array_unique($H);
        $C = array_values($C);

        $b = Attributes::all()->toArray(); // mảng chứa các attributes từ cơ sở dữ liệu

        $combinedArray = [];

        // Tạo một mảng lookup cho b để khớp id với attribute_group_id
        $bLookup = [];
        foreach ($b as $itemB) {
            $bLookup[$itemB['id']] = $itemB['attribute_group_id'];
        }

        // Lặp qua $C và khớp id với $bLookup
        foreach ($C as $id) {
            if (isset($bLookup[$id])) {
                $combinedArray[] = ['id' => $id, 'attribute_group_id' => $bLookup[$id]];
            } else {
                $combinedArray[] = ['id' => $id, 'attribute_group_id' => null];
            }
        }
        $bang = [];
        $attributes1 = array_filter($combinedArray, function ($item) {
            return $item['attribute_group_id'] === 1;
        });

        $attributes2 = array_filter($combinedArray, function ($item) {
            return $item['attribute_group_id'] === 2;
        });

        // Đặt lại các chỉ số của mảng
        $attributes1 = array_values($attributes1);
        $attributes2 = array_values($attributes2);

        // Tạo mảng kết hợp
        for ($i = 0; $i < count($attributes1); $i++) {
            for ($j = 0; $j < count($attributes2); $j++) {
                $bang[] = [
                    'attribute_group_id_1' => $attributes1[$i]['id'],
                    'attribute_group_id_2' => $attributes2[$j]['id'],
                ];
            }
        }

        if ($req->hasFile('image')) {
            $file = $req->image;
            $file_name = $file->getClientOriginalName();
            $file->move('upload.product', $file_name);
        }
        $product = Products::create([
            'name' => $req->name,
            'description' => $req->description,
            'image' => $file_name,
            'category_id' => $req->category_id,
            'price' => $req->price,
            'sale_price' => $req->sale_price,
        ]);
        $temp_id = $product->id;
        Session::put('product', $product);
        Session::put('product_id', $temp_id);

        if ($product) {
            if ($req->hasFile('images1')) {
                $files = $req->images1;
                foreach ($files as $key => $f) {
                    $file_name1 = $f->getClientOriginalName();
                    $f->move(public_path('upload.product'), $file_name1);
                    Product_images::create([
                        'product_id' => $product->id,
                        'image' => $file_name1
                    ]);
                }

            }
        }
        $product_images = Products::where('id', $product->id)->delete();
        $atb = Attributes::all();
        return view('admin.pages.product_add_attribute', compact('bang', 'atb'));
    }
    public function product_add_atb(Request $request)
    {
        $pro = Session::get('product');
        $id = $pro->id;
        $stocks = $request->input('stock');
        $attributeColors = $request->input('color');
        $attributeSizes = $request->input('size');
        foreach ($stocks as $key => $stock) {
            // Tạo bản ghi mới trong bảng `product_stocks` và lấy `product_id`
            $productCombination = Product_attribute::create([
                'product_id' => $id,
                'stock' => $stock,
            ]);

            $productId = $productCombination->id;


            // Lưu màu sắc
            $color = Product_combination::create([
                'product_attribute_id' => $productId,
                'attribute_id' => $attributeColors[$key],
            ]);

            // Lưu size
            $size = Product_combination::create([
                'product_attribute_id' => $productId,
                'attribute_id' => $attributeSizes[$key],
            ]);

        }
        if ($productCombination && $color && $size) {
            Products::create([
                'id' => $pro->id,
                'name' => $pro->name,
                'description' => $pro->description,
                'image' => $pro->image,
                'category_id' => $pro->category_id,
                'price' => $pro->price,
                'sale_price' => $pro->sale_price,
            ]);
        }
        Session::forget('product');
        return redirect()->route('admin.product')->with('success', 'Thêm thuộc tính sản phẩm thành công.');
    }


    public function product_update_show($id)
    {
        $category = Categories::all();
        $attribute = Attributes::all();
        $product = Products::find($id);
        $product_images = Product_images::where('product_id', $id)->get();
        $results = DB::table('products')
            ->join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
            ->where('product_attributes.product_id', $id)
            ->join('product_combinations', 'product_attributes.id', '=', 'product_combinations.product_attribute_id')
            ->select('product_combinations.attribute_id')
            ->get();
        $b = [];
        foreach ($results as $value) {
            foreach ($attribute as $item) {
                if ($value->attribute_id == $item->id) {
                    $b[] = ['attribute_group_id' => $item->attribute_group_id, 'attribute_id' => $value->attribute_id, 'name' => $item->name];
                }
            }
        }
        $color = [];
        $size = [];

        $seen1 = [];
        $seen2 = [];

        foreach ($b as $item) {
            if ($item['attribute_group_id'] == 1) {
                if (!in_array($item['attribute_id'], $seen1)) {
                    $color[] = $item;
                    $seen1[] = $item['attribute_id'];
                }
            } elseif ($item['attribute_group_id'] == 2) {
                if (!in_array($item['attribute_id'], $seen2)) {
                    $size[] = $item;
                    $seen2[] = $item['attribute_id'];
                }
            }
        }
        $attribute_color = Attributes::where('attribute_group_id', 1)->get();
        $attribute_size = Attributes::where('attribute_group_id', 2)->get();


        
        return view('admin.pages.product_update_show', compact('product', 'product_images', 'attribute', 'category', 'color', 'size', 'attribute_color', 'attribute_size'));
    }

    public function product_update_atb(Request $req)
    {
        
        $data = $req->all();
        $id = $req->product_id;
        $product_update = Products::find($id);
        if ($req->hasFile('image')) {
            $file = $req->image;
            $file_name = $file->getClientOriginalName();
            $file->move('upload.product', $file_name);
        } else {
            $file_name = $product_update->image;
        }

        //Sửa sản phẩm
        $product_update = Products::where('id', $id)->update([
            'name' => $req->name,
            'description' => $req->description,
            'image' => $file_name,
            'category_id' => $req->category_id,
            'price' => $req->price,
            'sale_price' => $req->sale_price,
        ]);

        if ($req->hasFile('images1')) {
            $files = $req->file('images1');
            $fileNames = [];

            // Lấy tên tất cả các tệp tin ảnh và di chuyển chúng vào thư mục tạm thời
            foreach ($files as $key => $f) {
                $fileNames[] = $f->getClientOriginalName();
                $f->move(public_path('upload.product'), $fileNames[$key]);
            }

            // Xóa tất cả các bản ghi Product_images có cùng product_id
            Product_images::where('product_id', $id)->delete();

            // Thêm các bản ghi mới với tên ảnh mới
            foreach ($fileNames as $fileName) {
                $productImage = new Product_images();
                $productImage->product_id = $id;
                $productImage->image = $fileName;
                $productImage->save();
            }
        }
        $product_id = $req->product_id;
        // Giả sử $C là mảng chứa các id và $b là mảng từ cơ sở dữ liệu
        $H = $data['name_attribute']; // mảng chứa các id
        $C = array_unique($H);
        $C = array_values($C);

        $bb = Attributes::all()->toArray(); // mảng chứa các attributes từ cơ sở dữ liệu

        $combinedArray = [];

        // Tạo một mảng lookup cho b để khớp id với attribute_group_id
        $bLookup = [];
        foreach ($bb as $itemB) {
            $bLookup[$itemB['id']] = $itemB['attribute_group_id'];
        }

        // Lặp qua $C và khớp id với $bLookup
        foreach ($C as $id) {
            if (isset($bLookup[$id])) {
                $combinedArray[] = ['id' => $id, 'attribute_group_id' => $bLookup[$id]];
            } else {
                $combinedArray[] = ['id' => $id, 'attribute_group_id' => null];
            }
        }
        $bang = [];
        $attributes1 = array_filter($combinedArray, function ($item) {
            return $item['attribute_group_id'] === 1;
        });

        $attributes2 = array_filter($combinedArray, function ($item) {
            return $item['attribute_group_id'] === 2;
        });

        // Đặt lại các chỉ số của mảng
        $attributes1 = array_values($attributes1);
        $attributes2 = array_values($attributes2);

        // Tạo mảng kết hợp
        for ($i = 0; $i < count($attributes1); $i++) {
            for ($j = 0; $j < count($attributes2); $j++) {
                $bang[] = [
                    'attribute_group_id_1' => $attributes1[$i]['id'],
                    'attribute_group_id_2' => $attributes2[$j]['id'],
                    'stock' => ''
                ];
            }
        }

        
        $id = $req->product_id;
        $d = Product_attribute::where('product_id', $id)->pluck('id');
        $c = $req->name_attribute;
        
        // Kiểm tra giá trị của $d và $c
        // dd($d, $c);
        
        $result = [];
        $a = Product_attribute::all();
        $b = Product_combination::all();
        foreach ($d as $product_Attribte_id) {
            $attributes = [];
            $stock = null;
        
            // Tìm tất cả attribute_id có product_Attribte_id khớp
            foreach ($b as $b_item) {
                if ($b_item['product_attribute_id'] == $product_Attribte_id) {
                    $attributes[] = $b_item['attribute_id'];
                }
            }
            // Tìm stock tương ứng với product_Attribte_id
            foreach ($a as $a_item) {
                if ($a_item['id'] == $product_Attribte_id) {
                    $stock = $a_item['stock'];
                    break;
                }
            }
        
            // Nếu có ít nhất 2 attribute_id, tạo mục kết quả
            if (count($attributes) >= 2) {
                for ($i = 0; $i < count($attributes) - 1; $i++) {
                    for ($j = $i + 1; $j < count($attributes); $j++) {
                        $attribute_id_1 = $attributes[$i];
                        $attribute_id_2 = $attributes[$j];
                        if (in_array($attribute_id_1, $c) && in_array($attribute_id_2, $c)) {
                            $result[] = [
                                'attribute_group_id_1' => $attribute_id_1,
                                'attribute_group_id_2' => $attribute_id_2,
                                'stock' => $stock
                            ];
                        } 
                    }
                }
            }
        }
        $map = [];
        foreach ($result as $item) {
            $key = $item["attribute_group_id_1"] . '-' . $item["attribute_group_id_2"];
            $map[$key] = $item["stock"];
        }
        
        // Lặp qua array1 để cập nhật giá trị stock nếu tìm thấy khớp trong map
        foreach ($bang as &$item) {
            $key = $item["attribute_group_id_1"] . '-' . $item["attribute_group_id_2"];
            if (isset($map[$key])) {
                $item["stock"] = $map[$key];
            }
        }
        $atb = Attributes::all();
        return view('admin.pages.product_update_attribute', compact('bang','atb','product_id'));
    }

    public function product_update(UpdateProductRequest $req, $id)
    {
        $product = Products::findOrFail($id);

        // Xử lý dữ liệu gửi từ biểu mẫu
        $stocks = $req->input('stock');
        $attributeColors = $req->input('color');
        $attributeSizes = $req->input('size');
    
        // Xóa tất cả các thuộc tính cũ của sản phẩm
        Product_attribute::where('product_id',$id)->delete();
    
        foreach ($stocks as $key => $stock) {
            // Tạo bản ghi mới trong bảng `product_attributes`
            $productAttribute = Product_attribute::create([
                'product_id' => $id,
                'stock' => $stock,
            ]);
    
            $productId = $productAttribute->id;
    
            // Lưu màu sắc
            $color = Product_combination::create([
                'product_attribute_id' => $productId,
                'attribute_id' => $attributeColors[$key],
            ]);
    
            // Lưu size
            $size = Product_combination::create([
                'product_attribute_id' => $productId,
                'attribute_id' => $attributeSizes[$key],
            ]);
        }
    
        // Cập nhật thông tin sản phẩm nếu cần
        $product->save();
    
        return redirect()->route('admin.product')->with('notification', 'Cập nhật Thành Công');
    }


    // Delete
    public function product_delete($id)
    {
        $product_images = Product_images::where('product_id', $id)->delete();

        $product_attrs = Product_attribute::where('product_id', $id)->get();

        foreach ($product_attrs as $product_attr) {
            $product_cb_id = $product_attr->id;
        
            Product_combination::where('product_attribute_id', $product_cb_id)->delete();
        }
        $product_attrs = Product_attribute::where('product_id', $id)->delete();
        $Products = Products::find($id)->delete();

        return redirect()->back()->with('notification', 'Xóa Thành Công');
    }
}
