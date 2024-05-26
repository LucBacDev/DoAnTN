<?php

namespace App\Http\Controllers;

use App\Helper\Cart;
use App\Models\Banner;
use App\Models\Product_attribute;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Product_attrs;
use App\Models\Attributes;
use App\Models\Brands;
use DB;
use App\Models\Order_details;
use Session;
use App\Models\Orders;
use App\Models\Product_combination;
use App\Models\Users;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cart $cart)
    {
        
        $Categories = Categories::all();
        // $popular = Order_details::select('pro_id', DB::raw('COUNT(*) as total_orders'))
        // ->groupBy('pro_id')
        // ->orderByDesc('total_orders')
        // ->limit(4)
        // ->get();
        // $popular = DB::table('Product_attrs')
        // ->select('Product_attrs.*', DB::raw('(SELECT COUNT(*) FROM Order_details WHERE Order_details.pro_id = Product_attrs.id) AS total_orders'))
        // ->orderByDesc('total_orders')
        // ->limit(4)
        // ->get();
        // $newpro = Products::where('name', 'like', '%Mới%')
        // ->orderBy('id', 'DESC')
        // ->limit(8)
        // ->get();       
         $banner = Banner::all();
         $product = Products::all();
         $popular = Products::all();
         $newpro = Products::all();
         return view('user.index', compact('Categories', 'popular', 'newpro', 'cart','banner','product'));
    }
    public function cart($id)
    {
        $order = Orders::where('user_id',$id)->first();
        $order_id = $order->id;
        $order_detail = Order_details::where('order_id', $order_id)->get();
        $product_atb = Product_attribute::all();
        $product_cb = Product_combination::all();
        $total_price = 0;
        $product = Products::all();
        foreach ($order_detail as $value) {
            $total_price = $total_price + $value->unit_price;
        }
        $attribute = Attributes::all();
        $total = $total_price+30000;
        return view('user.order_management',compact('order_detail','product','order','product_atb','product_cb','total_price','total','attribute'));
    }

    //Show chi tiết sản phẩm
    private function removeDuplicates($array) {
        $uniqueArray = [];
        $uniqueKeys = [];

        foreach ($array as $item) {
            $key = $item->attribute_id . '-' . $item->attribute_group_id;
            if (!in_array($key, $uniqueKeys)) {
                $uniqueKeys[] = $key;
                $uniqueArray[] = $item;
            }
        }

        return $uniqueArray;
    }
    public function product($id)
    {
        $prodetail = Products::find($id);
        $atb = DB::table('product_attributes')
        ->where('product_attributes.product_id', $id)
        ->join('product_combinations', 'product_attributes.id', '=', 'product_combinations.product_attribute_id')
        ->join('attributes', 'product_combinations.attribute_id', '=', 'attributes.id') // Sửa ở đây
        ->select('product_combinations.attribute_id', 'attributes.attribute_group_id', 'attributes.name')
        ->get();
        $atbdetail = $this->removeDuplicates($atb);
        $short_description = substr(strip_tags($prodetail->description), 0, 1500);
        return view('user.product_details', compact('prodetail','atbdetail','short_description'));
    }
    //Show các sản phẩm của Woman
    public function edit_user($id)
    {
        return view('user.edit_user');
    }
    public function update_user(Request $request,$id)
    {
        $user = Users::find($id);

        $user->update([
            'full_name' => $request->input('full_name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
        ]);

        return redirect()->route('user.index')->with('notification', 'Sửa tài khoản thành công');
    }    
    public function search(Request $request, $id = null)
{
    $query = Products::orderBy('created_at', 'DESC');
    $Total_product = 0;
    $priceRange = $request->price_range;

    if ($request->keyword) {
        $query->where('name', 'like', '%' . $request->keyword . '%');
        $Total_product = $query->count();
    } elseif ($id) {
        $query->where('category_id', $id);
        $Total_product = $query->count();
    } elseif ($priceRange) {
        if ($priceRange == 'all') {
        } else {
            $priceLimits = explode('_', $priceRange);
            if (isset($priceLimits[1])) {
                if ($priceLimits[0] == '300') {
                    $query->where('sale_price', '>=', 300);
                } else {
                    $query->whereBetween('sale_price', [$priceLimits[0], $priceLimits[1]]);
                }
            }
        }
       
    }

    $Products = $query->paginate(6);
    $Total_product = $query->count();

    return view('user.search', compact('Products','Total_product'));
}
    public function OrderManagement()
    {
        return view('user.OrderManagement');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function shop()
    {

        return view('user.search');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
