<?php

namespace App\Http\Controllers;

use App\Models\payment_method;
use Illuminate\Http\Request;
use App\Models\Order_details;
use App\Helper\Cart;
use Auth;
use Mail;
class PaymentController extends Controller
{
     public function vnpay_payment(Request $request){
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/vn-pay/return";
        $vnp_TmnCode = "1GJ3B3GL";
        $vnp_HashSecret = "XYQPEEIGEKBZQIEERROJYCMJYIYKAHKZ";
        
        $vnp_TxnRef = $request->order_id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán đơn hàng";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->Amount*100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        //Billing
      
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
       
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
    }
    public function vnpay_return(Request $request,Cart $cart){
        // Lấy dữ liệu từ query string
        $vnp_Amount = $request->query('vnp_Amount');
        $vnp_BankCode = $request->query('vnp_BankCode');
        $vnp_BankTranNo = $request->query('vnp_BankTranNo');
        $vnp_CardType = $request->query('vnp_CardType');
        $vnp_OrderInfo = $request->query('vnp_OrderInfo');
        $vnp_PayDate = $request->query('vnp_PayDate');
        $vnp_ResponseCode = $request->query('vnp_ResponseCode');
        $vnp_TmnCode = $request->query('vnp_TmnCode');
        $vnp_TransactionNo = $request->query('vnp_TransactionNo');
        $vnp_TransactionStatus = $request->query('vnp_TransactionStatus');
        $vnp_TxnRef = $request->query('vnp_TxnRef');
        $vnp_SecureHash = $request->query('vnp_SecureHash');

        // Xử lý logic nghiệp vụ ở đây
        // Ví dụ: Lưu thông tin vào cơ sở dữ liệu, xác thực giao dịch, vv.

        // Trả về một phản hồi (response)
        $create = payment_method::create([
            
                'p_transaction_id' => $vnp_TransactionNo,
                'p_user_id' => Auth::id(),
                'p_money' => $vnp_Amount/100,
                'p_note' => $vnp_OrderInfo,
                'p_vnp_response_code' => $vnp_ResponseCode,
                'p_code_bank' => $vnp_BankCode,
                'p_code_vnpay' => $vnp_BankTranNo,
                'p_time' => $vnp_PayDate,                
            
        ]);
        $cart->remove();
    return redirect()->route('user.index')->with('notification', 'Cám ơn đã đặt hàng!, Vui lòng check mail để xác nhận đơn hàng');
    }        
}
