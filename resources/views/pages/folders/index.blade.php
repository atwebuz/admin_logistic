@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>FOLDERS</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item active">FOLDERS</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <ul>
                        <li><a target="_blank" download href="{{asset('/files/111TCMVBN.pdf')}}">111TCMVBN</a></li>
                        <li><a target="_blank" download href="{{asset('/files/Bil_of_Lading_Form_PrintableTemplate.pdf')}}">Bil_of_Lading_Form_P</a></li>
                        <li><a target="_blank" download href="{{asset('/files/bill-of-lading-01.pdf')}}">bill-of-lading-01</a></li>
                        <li><a target="_blank" download href="{{asset('/files/Receiver_Blind_BOL_CA-OH_8.1.23.docx')}}">Receiver_Blind_BOL_CA-OH_8.1.23</a></li>
                        <li><a target="_blank" download href="{{asset('/files/straight-bol.pdf')}}">straight-bol</a></li>
                        <li><a target="_blank" download href="https://billoflading.org/">https://billoflading.org/</a></li>


                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script !src="">
        function changeStatus($x, $y, $t) {

            let button = $("#status_"+$x);

            let order_id = $x;
            let status = $y;
            let types = $t;

            $.ajax({
                url:'/order/status',
                type: "POST",
                data:{
                    order_id: order_id,
                    status: status,
                    types: types,
                    _token: "{!! @csrf_token() !!}"
                },
                beforeSend:function () {
                    SpinnerGo(button);
                },
                success:function (result) {
                    if(result.status)
                    {
                        let classes = ['warning','primary','primary','success','danger','primary'];
                        let text = ['Новый','Новый','Новый','Новый','Отменен','Отправить в Telegram'];
                        button.attr('class',"btn-sm dropdown-toggle btn btn-"+classes[$y]);
                        console.log(classes[$y]);
                        button.text(text[$y]);
                    }
                    else
                    {

                    }
                    SpinnerStop(button);
                },
                error:function(err){
                    console.log(err);
                    SpinnerStop(button);
                }
            })



        }
        function changePayment($x, $y, $t) {


            let button = $("#payment_"+$x);
            let order_id = $x;
            let status = $y;
            let types = $t;

            $.ajax({
                url:'/order/status',
                type: "POST",
                data:{
                    order_id: order_id,
                    status: status,
                    types: types,
                    _token: "{!! @csrf_token() !!}"
                },
                beforeSend:function () {
                    SpinnerGo(button);
                },
                success:function (result) {
                    if(result.status)
                    {
                        let classes = ['danger','success'];
                        let text = ['Не Оплачен','Оплачен'];
                        button.attr('class',"btn-sm dropdown-toggle btn btn-"+classes[$y]);
                        console.log(classes[$y]);

                        button.text(text[$y]);
                    }
                    else
                    {

                    }
                    SpinnerStop(button);
                },
                error:function(err){
                    console.log(err);
                    SpinnerStop(button);
                }
            })



        }
    </script>
@endsection()
