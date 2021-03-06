<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Jimmy Parker">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ url('/') }}/images/favicon.png" sizes="16x16" type="image/png">
    <title>@yield('title','Vaccine Information Management System')</title>
    <!-- Custom styles for this template -->
    @yield('meta')

    <link href="{{ url('/') }}/css/bootstrap.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/font-awesome.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/loader.css" rel="stylesheet">
    <style>
        .modal {
            text-align: center;
        }

        @media screen and (min-width: 768px) {
            .modal:before {
                display: inline-block;
                vertical-align: middle;
                content: " ";
                height: 100%;
            }
        }

        .modal-dialog {
            display: inline-block;
            text-align: left;
            vertical-align: middle;
        }
    </style>
    @yield('css')
</head>

<body>
<div id="loader-wrapper" style="visibility: hidden;">
    <div id="loader"></div>
</div>
@include('menu')

<!-- Header -->
<header class="bg-success py-3 mb-5">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-lg-12">
                <div class="banner mt-5">
                    <img src="{{ url('/') }}/images/banner.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Page Content -->
<div class="wrapper pb-5">
    <div class="container">
        @yield('content')
    </div>
</div>
@yield('modal')
@include('modal')
<!-- /.container -->
<!-- Footer -->
<footer class="py-md-3 bg-dark footer">
    <div class="container">
        <font class="text-white">Copyright &copy; CSMC iHOMP 2021</font>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="{{ url('/') }}/js/jquery.min.js"></script>
<script src="{{ url('/') }}/js/bootstrap.bundle.min.js"></script>
@include('loader')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield('js')
</body>

</html>
