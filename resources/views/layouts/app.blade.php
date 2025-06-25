<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Accounting</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon1.png')}}">
    <link rel="stylesheet" href="{{ asset('plug-ins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plug-ins/datepicker/datepicker.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plug-ins/owl/dist/assets/owl.carousel.css')}}"/>
    <link rel="stylesheet" href="{{ asset('plug-ins/select2/css/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('plug-ins/select2/css/select2-bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('plug-ins/font-awesome/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/main.css?v=2')}}"/>
 </head>
<body>
    @yield('content')      

    <!-- java script -->
    <script src="{{ asset('plug-ins/jquery/jquery-3.5.1.min.js')}}"></script>
    <script src="{{ asset('plug-ins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('plug-ins/datepicker/datepicker.min.js')}}"></script>
    <script src="{{ asset('plug-ins/owl/dist/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('plug-ins/select2/js/select2.min.js')}}"></script>
    <script>
        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true
        })

     </script>
    @stack('js')
</body>
</html>
