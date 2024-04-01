<?php

namespace App\Http\Controllers;

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
    
        $products_atb = Product_Attrs::all();
        $attribute = Attributes::all();
    
        return view('admin.pages.product', compact('products', 'products_atb', 'attribute'));
    }
    public function product_add()
    {
        $category = Categories::all();
        $brand = Brands::all();
        $attribute = Attributes::all();
        return view('admin.pages.product_add', compact('category', 'brand', 'attribute'));
    }

    //Create
    public function product_create(Request $req)
    {
        if ($req->hasFile('image')) {
            $file = $req->image;
            $file_name = $file->getClientOriginalName();
            $file->move('upload.product', $file_name);
        }
        $product = Products::create([
            'name' => $req->name,
            'price' => $req->price,
            'sale_price' => $req->sale_price,
            'description' => $req->description,
            'image' => $file_name,
            'status' => $req->status,
            'category_id' => $req->category_id,
            'brand_id' => $req->brand_id,
            'origin' => $req->origin,
            'year' => $req->year,
        ]);
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

        $productId = $product->id;
        $images = $req->file('images');
        $validatedData = $req->validate([
            'attributes.*' => 'required',
            'images2.*' => 'required|image',
            'stocks.*' => 'required|numeric',
        ]);
        // Lặp qua mỗi phần tử của mảng thuộc tính
        foreach ($validatedData['attributes'] as $key => $attribute) {
            $yourModel = new Product_Attrs();
            $yourModel->attribute_color_id = $attribute;
            $yourModel->product_id = $productId;
            // Assuming your model has other fields like 'image' and 'stock'
            $file_name2 = $validatedData['images2'][$key]->getClientOriginalName();
            // Di chuyển tệp ảnh vào thư mục 'public/upload.product'
            $validatedData['images2'][$key]->move(public_path('upload.product'), $file_name2);
            // Lưu tên tệp ảnh vào trường 'image' của model
            $yourModel->image = $file_name2;
            $yourModel->stock = $validatedData['stocks'][$key];
            $yourModel->save();

        }
     
        return redirect()->route('admin.product')->with('notification', 'Thêm mới sản phẩm thành công');
    }

    //Update_show
    public function product_update_show($id)
    {
        $category = Categories::all();
        $brand = Brands::all();
        $attribute = Attributes::all();
        $product = Products::find($id);
        $product_images = Product_images::where('product_id', $id)->get();
        $product_attrs = Product_attrs::where('product_id', $id)->get();
        return view('admin.pages.product_update_show', compact('product', 'product_images', 'attribute', 'category', 'brand', 'product_attrs'));
    }

    //Update
    public function product_update(UpdateProductRequest $req, $id)
    {
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
            'price' => $req->price,
            'sale_price' => $req->sale_price,
            'description' => $req->description,
            'image' => $file_name,
            'status' => $req->status,
            'category_id' => $req->category_id,
            'brand_id' => $req->brand_id,
            'origin' => $req->origin,
            'year' => $req->year,
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



        $images = $req->file('images');
        // $validatedData = $req->validate([
        //     // 'attributes.*' => 'required',
        //     // 'images2.*' => 'required|image',
        //     // 'stocks.*' => 'required|numeric',
        // ]);

        $product_attrs = Product_attrs::where('product_id', $id)->get();
        $existingAttrs = Product_Attrs::where('product_id', $id)->get();
        $attributesFromForm = $req->input('attributes');

        $attribute = $req->input('attributes');
        foreach ($attributesFromForm as $key => $attribute) {
            // Kiểm tra xem thuộc tính từ form đã tồn tại trong cơ sở dữ liệu chưa
            $existingAttr = $existingAttrs->where('attribute_color_id', $attribute)->first();
            // Nếu không tồn tại, tạo mới bản ghi
            if (!$existingAttr) {
                $newAttr = new Product_Attrs();
                $newAttr->attribute_color_id = $attribute;
                $newAttr->product_id = $id;
                $newAttr->stock = $req->input('stocks.' . $key);
               
                    $file_name2 = $req->file('images2.' . $key)->getClientOriginalName();
                    $req->file('images2.' . $key)->move(public_path('upload.product'), $file_name2);
                    $newAttr->image = $file_name2;
                
                $newAttr->save();
            } else {
                
                // Nếu thuộc tính từ form đã tồn tại, cập nhật thông tin
                $existingAttr->stock = $req->input('stocks.' . $key);
                if ($req->hasFile('images2') && isset($req->images2[$key])) {
                    $file_name2 = $req->file('images2.' . $key)->getClientOriginalName();
                    $req->file('images2.' . $key)->move(public_path('upload.product'), $file_name2);
                    $existingAttr->image = $file_name2;
                }
                
                $existingAttr->save();
            }
        }
    
        // Xóa các thuộc tính không còn tồn tại trong form từ cơ sở dữ liệu
        foreach ($existingAttrs as $existingAttr) {
            if (!in_array($existingAttr->attribute_color_id, $attributesFromForm)) {
                $existingAttr->delete();
            }
        }

      




        return redirect()->route('admin.product')->with('notification', 'Cập nhật Thành Công');
    }


    // Delete
    public function product_delete($id)
    {
        $product_images = Product_images::where('product_id', $id)->delete();

        $product_attrs = Product_attrs::where('product_id', $id)->delete();

        $Products = Products::find($id)->delete();

        return redirect()->back()->with('notification', 'Xóa Thành Công');
    }
}
