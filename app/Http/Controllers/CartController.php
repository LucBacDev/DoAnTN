<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Attributes;
use App\Models\Product_attrs;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Order_details;
use App\Helper\Cart;
use App\Models\payment_method;
use Illuminate\Support\Facades\Cache;
use Auth;
use Mail;
use Str;

class CartController extends Controller
{
    public function add(Request $req, $id)
    {
        
        $product = Products::find($id);
        $product_atb = Product_attrs::all();
        $quantity = $req->quantity;
        $color_id = $req->attribute_color_id;
        foreach ($product_atb as $value) {
            if ($value->product_id == $id && $value->attribute_color_id == $color_id) {
                $product_atb_id = $value->id;
            }
        }
        $cart = new Cart();
        $cart->add($product, $quantity, $color_id,$product_atb_id);
        return redirect()->route('show_card');
    }
    public function show(Cart $cart)
    {
        $attribute = Attributes::all();
        return view('user.cart', compact('cart','attribute'));
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
            return view('user.receipt',  compact('attribute'));
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
            $product_atb = Product_attrs::all();
            foreach ($cart->getItem() as $item) {
                Order_details::create([
                    'order_id' => $order->id,
                    'pro_id' => $item['id'],
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['quantity'] * $item['price'],
                ]);

                $product = $product_atb->where('id', $item['id'])->first();
                $product->stock = $product->stock - $item['quantity'];
                // $product->update([
                //             'stock' => $product->stock - $item['quantity']
                //         ]);
                $product->save();
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