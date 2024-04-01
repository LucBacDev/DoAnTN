@extends('master_user')
@section('payment')
    <div class="container">
        <div class="table-responsive">
            <form action="{{ route('vnpay') }}" method="post">
                @csrf
                <div class="form-group">
                    <div class="form-group">
                        <label for="Amount">Số tiền</label>
                        <input class="form-control" data-val="true" data-val-number="The field Amount must be a number."
                            data-val-required="The Amount field is required." id="Amount" name="Amount" type="text"
                            value="10000" />
                    </div>
                    <div class="form-group">
                        <label for="OrderDescription">Nội dung thanh toán</label>
                        <textarea class="form-control" cols="20" id="OrderDescription" name="OrderDescription" rows="2">
Thanh toan don hang thoi gian: 2023-09-17 11:29:13</textarea>
                    </div>
                    <div class="form-group">
                        <label for="bankcode">Ngân hàng</label>
                        <select name="bankcode" id="bankcode" class="form-control">
                            <option value="">Không chọn </option>
                            <option value="MBAPP">Ung dung MobileBanking</option>
                            <option value="VNPAYQR">VNPAYQR</option>
                            <option value="VNBANK">LOCAL BANK</option>
                            <option value="IB">INTERNET BANKING</option>
                            <option value="ATM">ATM CARD</option>
                            <option value="INTCARD">INTERNATIONAL CARD</option>
                            <option value="VISA">VISA</option>
                            <option value="MASTERCARD"> MASTERCARD</option>
                            <option value="JCB">JCB</option>
                            <option value="UPI">UPI</option>
                            <option value="VIB">VIB</option>
                            <option value="VIETCAPITALBANK">VIETCAPITALBANK</option>
                            <option value="SCB">Ngan hang SCB</option>
                            <option value="NCB">Ngan hang NCB</option>
                            <option value="SACOMBANK">Ngan hang SacomBank </option>
                            <option value="EXIMBANK">Ngan hang EximBank </option>
                            <option value="MSBANK">Ngan hang MSBANK </option>
                            <option value="NAMABANK">Ngan hang NamABank </option>
                            <option value="VNMART"> Vi dien tu VnMart</option>
                            <option value="VIETINBANK">Ngan hang Vietinbank </option>
                            <option value="VIETCOMBANK">Ngan hang VCB </option>
                            <option value="HDBANK">Ngan hang HDBank</option>
                            <option value="DONGABANK">Ngan hang Dong A</option>
                            <option value="TPBANK">Ngân hàng TPBank </option>
                            <option value="OJB">Ngân hàng OceanBank</option>
                            <option value="BIDV">Ngân hàng BIDV </option>
                            <option value="TECHCOMBANK">Ngân hàng Techcombank </option>
                            <option value="VPBANK">Ngan hang VPBank </option>
                            <option value="AGRIBANK">Ngan hang Agribank </option>
                            <option value="MBBANK">Ngan hang MBBank </option>
                            <option value="ACB">Ngan hang ACB </option>
                            <option value="OCB">Ngan hang OCB </option>
                            <option value="IVB">Ngan hang IVB </option>
                            <option value="SHB">Ngan hang SHB </option>
                            <option value="APPLEPAY">Apple Pay </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-default" name="redirect">Thanh toán</button>
            </form>
        </div>
        <p>
            &nbsp;
        </p>

        <footer class="footer">
            <p>&copy; VNPAY 2023</p>
        </footer>
    </div> <!-- /container -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/tryitnow/Styles/js/ie10-viewport-bug-workaround.js"></script>

    <link href="https://pay.vnpay.vn/lib/vnpay/vnpay.css" rel="stylesheet" />
    <script src="https://pay.vnpay.vn/lib/vnpay/vnpay.js"></script>
    <script type="text/javascript">
        $("#btnPopup").click(function() {
            var postData = $("#frmCreateOrder").serialize();
            var submitUrl = $("#frmCreateOrder").attr("action");
            $.ajax({
                type: "POST",
                url: submitUrl,
                data: postData,
                dataType: 'JSON',
                success: function(x) {
                    if (x.code === '00') {
                        if (window.vnpay) {
                            vnpay.open({
                                width: 768,
                                height: 600,
                                url: x.data
                            });
                        } else {
                            window.location = x.data;
                        }
                        return false;
                    } else {
                        alert("Error:" + x.Message);
                    }
                }
            });
            return false;
        });
    </script>


    <script></script>
@endsection
