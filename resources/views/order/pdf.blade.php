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

        <div id="page-wrapper" style="min-height: 100%!important" class="w-100 h-50">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="text-center">Data Penjualan</h1>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Date Order</th>
                                            <th>Transaction Id</th>
                                            <th> Nama Penerima</th>
                                            <th>Alamat</th>
                                            <th>Province</th>
                                            <th>Kota</th>
                                            <th>Metode Pembayaran</th>
                                            <th>status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order as $item)
                                            <tr class="gradeX">
                                                <td>{{ $item->transaction->getTanggal() }}</td>
                                                <td>{{ $item->transaction->trx_id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->full_address }}</td>
                                                <td>{{ $item->province }}</td>
                                                <td>{{ $item->city }}</td>
                                                <td>{{ $item->transaction->method }}</td>
                                                <td>{{ $item->courier_status }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

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
                    filename:     'data-penjualan.pdf',
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { scale: 2 },
                    jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
                };
                html2pdf().from(document.body).set(opt).save();
            });
        </script>
    

    </body>

</html>
