<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use App\Jobs\TestMailJob;
use App\Models\Orders;
use App\Models\Order_details;
use App\Models\Products;
use App\Models\Users;
use Illuminate\Support\Facades\Cache;
use App\Helper\Cart;
use Mail;
use Auth;
use Str;
use Hash;
use App\Http\Requests\ForgotPasswordRequest;

class MailController extends Controller
{
    
    public function accept($id, $token, Cart $cart)
    {
        $order = Orders::find($id);
            if ($order->token === $token) {
                if (Cache::has('token_key')){
                    $order->update(['status' => 1]);
                    Mail::send('mails.Order-confirm.complete_accept', compact('order'), function ($email) use ($order) {
                        $email->subject('Đặt hàng thành công');
                        $email->to($order->email, $order->name);
                        
                    });
                    $order_details = Order_details::all();
                    $product = Products::all();
                    foreach ($order_details as $value) {
                        foreach ($product as $pro) {
                            if ($value->order_id == $order->id && $value->pro_id == $pro->id) {
                                $pro->update(['stock' => $pro->stock - $value->quantity]);

                                
                            }
                        }
        
                    }
                    $cart->remove();
                    Cache::forget('token_key');
                    return redirect()->route('user.index')->with('notification', 'Thank you for your purchase!, Order Success!');
                }
                
            }
       
    }

        //--------------Active account---------------//

    public function mailActive()
    {   
        return view('mails.Active-account.mail_active');
    }
    public function authenticate(Request $request)
    {   
        $gmail = $request->gmail;
        $user = Users::where('email', $gmail)->first();
        $mail = $user->email;
        if ($mail = $gmail) {
            $token = $user->active_token;
            Mail::send('mails.Active-account.activation_code', compact('token','user'), function ($email) use($user) {
                $email->subject('The activation code');
                $email->to($user->email, $user->name);
                
            });
        }
        return redirect()->route('user.index')->with('notification', 'Please check mail to active account!');;
    }

    public function active($gmail){
        return view('mails.Active-account.enter_activecode', compact('gmail'));
    }
    public function enter_activecode($gmail, Request $request){
        $user = Users::where('email', $gmail)->first();
        if ($user->active_token = $request->token) {
            $user->update(['status' => 1]);
            return redirect()->route('user.index')->with('notification', 'Successful Authentication!');
            Cache::forget('active-token');
        }    
    }
    

    //--------------Forgot password---------------//
    
    public function mailPassword()
    {   
        return view('mails.Forgot-password.mail-password');
    }
    public function mailForgotPassword(Request $request)
    {   
        $gmail = $request->gmail;
        $user = Users::where('email', $gmail)->first();
        $mail = $user->email;
        $token = strtoupper(Str::random(6));
        $user->update(['forgot_token'=>$token]);
        Cache::put('forgot_token', $token, 1440);
        if ($mail = $gmail) {
         
            Mail::send('mails.Forgot-password.mail-forgot-password', compact('user'), function ($email) use($user) {
                $email->subject('Change code');
                $email->to($user->email, $user->name);
                
            });
        }
        return redirect()->route('user.index')->with('notification', 'Please check mail to reset account!');;
    }

    public function resetPassword($gmail, $token){
        return view('mails.Forgot-password.reset-password', compact('gmail','token'));
    }
    public function checkPassword($gmail, $token, ForgotPasswordRequest $request){
        
        $user = Users::where('email', $gmail)->first();
        if ($user->forgot_token = $token && $user->email = $gmail) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            Cache::forget('active-token');
            return redirect()->route('user.index')->with('notification', 'Changed Password successfully!');
        }    
    }
}