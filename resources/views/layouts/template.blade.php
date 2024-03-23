<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AdminLTE 3 | Advanced form elements</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">


    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css?v=3.2.0') }}">

    {{-- ViwersJS CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.css"
        integrity="sha512-eG8C/4QWvW9MQKJNw2Xzr0KW7IcfBSxljko82RuSs613uOAg/jHEeuez4dfFgto1u6SRI/nXmTr9YPCjs1ozBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- css --}}
    <style>
        .img-zoom {
            transition: transform 0.3s ease-out;
        }

        .img-zoom:hover {
            transform: scale(1.5);
            /* Sesuaikan dengan faktor zoom yang diinginkan */
        }
    </style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('layouts.header')

        @include('layouts.navbar')

        @yield('template')

        @include('layouts.footer')

    </div>
    @include('layouts.js')
    @yield('js')
</body>

</html>
