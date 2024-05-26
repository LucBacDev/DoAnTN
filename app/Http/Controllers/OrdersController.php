<?php

namespace App\Http\Controllers;

use App\Models\Attributes;
use App\Models\Product_attribute;
use App\Models\Product_attrs;
use App\Models\Product_combination;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Order_details;


class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orders()
    {
        $order = Orders::orderBy('created_at', 'DESC')->paginate(6);
        $order_detail = Order_details::all();
        return view('admin.pages.orders',compact('order','order_detail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view_product($id)
    {
        $order_detail = Order_details::where('order_id', $id)->get();
        $order = Orders::find($id);
        $user = Users::where('id',$order->user_id)->first();
        $product_atb = Product_attribute::all();
        $product_cb = Product_combination::all();
        $total_price = 0;
        foreach ($order_detail as $value) {
            $total_price = $total_price + $value->unit_price;
        }
        $attribute = Attributes::all();
        $total = $total_price+30000;
        return view('admin.pages.view_product',compact('order_detail','order','user','product_atb','product_cb','total_price','total','attribute'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function orders_delete($id)
    {
        $Orders_detail = Order_details::where('order_id',$id)->delete();
        $Orders = Orders::find($id)->delete();
        return redirect()->with('notification','Xóa Thành Công');
    }
}
