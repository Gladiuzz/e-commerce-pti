<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Add Your favicon here -->
        <!--<link rel="icon" href="img/favicon.ico">-->
    
        <title>Pasar Tani</title>
    
        <!-- Bootstrap core CSS -->
        <link href="{{asset('landing-page/css/bootstrap.min.css')}}" rel="stylesheet">
    
        <!-- Animation CSS -->
        <link href="{{asset('landing-page/css/animate.css')}}" rel="stylesheet">
    
        <link href="{{asset('landing-page/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    
        <!-- Custom styles for this template -->
        <link href="{{asset('landing-page/css/style.css')}}" rel="stylesheet">
        @yield('css')
    </head>    

    <body class="skin-3">

        {{-- <div id="wrapper"> --}}
            <div id="page-wrapper" style="min-height: 100%!important" class="w-100 h-50 white-bg">
                {{-- <div class="wrapper wrapper-content"> --}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="wrapper wrapper-content p-xl">
                                <div class="ibox-content p-xl">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <address>
                                                <strong>Pasar Tani</strong><br>
                                                Alamat Pasar Tani<br>
                                                Kecamatan dan kota pasar tani <br>
                                                {{-- <abbr title="Phone"></abbr> (123) 601-4590 --}}
                                            </address>
                                        </div>
                        
                                        <div class="col-sm-6 text-right">
                                            <h4>KWITANSI.</h4>
                                            <h4 class="text-navy"></h4>
                                            {{-- <address>
                                                <strong></strong><br>
                                                 <br>
                                                <abbr title="Phone"></abbr> (+62)
                                            </address> --}}
                                            {{-- <p>
                                                <span><strong>Invoice Date: </strong></span><br />
                                            </p> --}}
                                        </div>
                                    </div>
                        
                                    <div class="table-responsive m-t">
                                        <table class="table invoice-table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <tr>
                                                <td><b>Telah Menerima Dari</b></td>
                                                <td>{{$user->name}}</td>
                                               </tr>

                                               <tr>
                                                <td><b>Banyaknya Uang</b></td>
                                                <td>{{$word}}</td>
                                               </tr>

                                               <tr>
                                                <td><b>Untuk Pembayaran</b></td>
                                                <td>Pembayaran {{$user->name}}</td>
                                               </tr>
                        
                                            </tbody>
                                        </table>
                                    </div><!-- /table-responsive -->
                        
                                    <table class="table invoice-total">
                                        <tbody>
                                            <tr>
                                                <td><strong>TOTAL :</strong></td>
                                                <td>@currency($money)</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- </div> --}}
            </div>
        {{-- </div> --}}

        <!-- Mainly scripts -->
        <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
        <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
        <!-- Custom and plugin javascript -->
        <script src="{{ asset('js/inspinia.js') }}"></script>
        <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var opt = {
                    margin:       1,
                    filename:     'pencairan.pdf',
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { scale: 2 },
                    jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
                };
                html2pdf().from(document.body).set(opt).save();
            });
        </script>
    

    </body>

</html>
