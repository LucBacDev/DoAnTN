<?php

namespace App\Http\Controllers;

use App\Models\Attributes_cart;
use App\Models\Orders;
use App\Models\Attributes;
use App\Models\Product_attribute;
use App\Models\Product_attrs;
use App\Models\Product_attrs_cart;
use App\Models\Product_images;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Order_details;
use App\Helper\Cart;
use App\Models\Product_cart;
use App\Models\Product_images_cart;
use App\Models\payment_method;
use Illuminate\Support\Facades\Cache;
use Auth;
use Mail;
use Str;
use DB;

class CartController extends Controller
{
    public function add(Request $req, $id)
    {
        $product = Products::find($id);
        $product_atb = Product_attribute::all();
        $att = Attributes::all();
        $quantity = $req->quantity;
        $color_id = $req->attribute_color_id;
        $size_id = $req->attribute_size_id;
       
        $result = DB::table('product_attributes as a')
            ->join('product_combinations as b1', 'a.id', '=', 'b1.product_attribute_id')
            ->join('Product_combinations as b2', 'a.id', '=', 'b2.product_attribute_id')
            ->where('a.product_id', $id)
            ->where('b1.attribute_id', $color_id)
            ->where('b2.attribute_id', $size_id)
            ->select('a.id','a.stock')
            ->first();
        $product_atb_id = $result->id;
        foreach ($att as $value) {
            if($value->id == $color_id){
                $color_id = $value->name;
            }
            if($value->id == $size_id){
                $size_id = $value->name;
            }
        }
        $stock = $result->stock;
        if($stock == 0){
            return redirect()->route('user.index')->with('notification', 'Sản phẩm đã hết hàng');
        }else{
        $cart = new Cart();
        $cart->add($product, $quantity, $color_id, $size_id,$product_atb_id);
        return redirect()->back()->with('notification', 'Thêm vào giỏ thành công');;
        }
    }
    public function show(Cart $cart)
    {
        $attribute = Attributes::all();
        return view('user.cart', compact('cart', 'attribute'));
    }
    public function update(Request $req, $id)
    {
        $quantity = $req->quantity;
        $cart = new Cart();
        $cart->update($id, $quantity);
        return redirect()->back();
    }


    public function delete(Cart $cart, $id)
    {
        $cart->delete($id);
        return redirect()->back();
    }

    // ------ checkout ----------- //
    public function checkout()
    {
        if (Auth::check()) {
            $attribute = Attributes::all();
            return view('user.receipt', compact('attribute'));
        } else {
            return redirect()->route('login')->with('notification', 'Vui lòng đăng nhập để mua hàng');
        }
    }
    public function Postcheckout(Request $request, Cart $cart)
    {
        // try {
            $attribute = Attributes::all();
            $total_qty = 0;
            $total_price = 0;
            $token = strtoupper(Str::random(20));
            Cache::put('token_key', $token, 1440);
            foreach ($cart->getItem() as $key => $value) {
                $total_price = $cart->totalPrice_ship();
                $total_qty += $value['quantity'];
            }
            $order = Orders::create([
                'user_id' => Auth::user()->id,
                'name' => $request->full_name,
                "total_quantity" => $total_qty,
                "total_price" => $total_price,
                'phone' => $request->phone,
                'email' => $request->email,
                'token' => $token,
                'address' => $request->address,
                'note' => $request->note,
                'payment_method' => $request->payment_method
            ]);
            $product_atb = Product_attribute::all();
            foreach ($cart->getItem() as $item) {
                Order_details::create([
                    'order_id' => $order->id,
                    'pro_id' => $item['id'],
                    'name' => $item['name'],
                    'color' => $item['attribute_color_id'],
                    'size' => $item['attribute_size_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['quantity'] * $item['price'],
                ]);

                $product = $product_atb->where('id', $item['id'])->first();
                $product->stock = $product->stock - $item['quantity'];
                $product->save();
            }
            $order_id = $order->id;
            if($request->payment_method==2){
            return view('user.payment_method.vnpay_payment', compact('total_price','order_id'));
            }

            Mail::send('mails.Order-confirm.check_order', compact('order','attribute'), function ($email) use ($order) {
                $email->subject('Xác nhận đơn hàng');
                $email->to($order->email, $order->name);

            });
            $cart->remove();
        return redirect()->route('user.index')->with('notification', 'Cám ơn đã đặt hàng!, Vui lòng check mail để xác nhận đơn hàng');
        // } 
        // catch (\Throwable $th) {
        //     dd($th);
        // }
    }
   
}