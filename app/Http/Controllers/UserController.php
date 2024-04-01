<?php

namespace App\Http\Controllers;

use App\Helper\Cart;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Product_attrs;
use App\Models\Attributes;
use App\Models\Brands;
use DB;
use App\Models\Order_details;

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
        $popular = DB::table('Product_attrs')
        ->select('Product_attrs.*', DB::raw('(SELECT COUNT(*) FROM Order_details WHERE Order_details.pro_id = Product_attrs.id) AS total_orders'))
        ->orderByDesc('total_orders')
        ->limit(4)
        ->get();
        $newpro = Products::where('name', 'like', '%Mới%')
        ->orderBy('id', 'DESC')
        ->limit(8)
        ->get();       
         $banner = Banner::all();
         $product = Products::all();
        return view('user.index', compact('Categories', 'popular', 'newpro', 'cart','banner','product'));
    }

    //Show chi tiết sản phẩm
    public function product($id)
    {
        $prodetail = Products::find($id);
        $atbdetail = Product_Attrs::where('product_id', $id)
        ->join('Attributes', 'product_attrs.attribute_color_id', '=', 'attributes.id')
        ->select('Attributes.name','Product_Attrs.attribute_color_id','Product_Attrs.image')
        ->get();
        $img = Product_Attrs::where('product_id', $id)->get();
        $short_description = substr(strip_tags($prodetail->description), 0, 1500);
        return view('user.product_details', compact('prodetail','atbdetail','short_description','img'));
    }
    //Show các sản phẩm của Woman
    public function womanpro()
    {
        $products = Products::Where('type', '1')->get();

        return view('user.product_woman', compact('products'));
    }
    public function search(Request $request, $id = null)
{
    $query = Products::orderBy('created_at', 'DESC');
    $Brand = Brands::all();
    $Total_product = 0;
    $priceRange = $request->price_range;
    $brandId = $request->brand;

    if ($request->keyword) {
        $query->where('name', 'like', '%' . $request->keyword . '%');
        $Total_product = $query->count();
    } elseif ($id) {
        $query->where('category_id', $id);
        $Total_product = $query->count();
    } elseif ($priceRange || $brandId) {
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
        if ($brandId != 'all') {
            $query->where('brand_id', $brandId);
        }
    }

    $Products = $query->paginate(6);
    $Total_product = $query->count();

    return view('user.search', compact('Products', 'Brand', 'Total_product'));
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
