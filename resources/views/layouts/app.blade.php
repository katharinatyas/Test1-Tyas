<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="{{ url('atlantis/assets/css/bootstrap.min.css') }}">

    <!-- Fonts and icons -->
	<script src="{{ url('atlantis/assets/js/plugin/webfont/webfont.min.js') }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ url("atlantis/assets/css/fonts.min.css") }}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ url('atlantis/assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ url('atlantis/assets/css/atlantis.min.css') }}">
	<link rel="stylesheet" href="{{ url('atlantis/assets/vendor/sweetalert2/sweetalert2.all.min.js') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            font-size: 30px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
        }
    </style>

    @yield('css')

</head>

<body>
    <div class="wrapper overlay-sidebar">
        @include('layouts.partials.header')

        <div class="main-panel">
			<div class="content">

                @yield('content')

            </div>
            @include('layouts.partials.footer')
        </div>


    </div>
    <!--   Core JS Files   -->
	<script src="{{ url('atlantis/assets/js/core/jquery.3.2.1.min.js') }}"></script>
	<script src="{{ url('atlantis/assets/js/core/popper.min.js') }}"></script>
	<script src="{{ url('atlantis/assets/js/core/bootstrap.min.js') }}"></script>

	<!-- jQuery UI -->
	<script src="{{ url('atlantis/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
	<script src="{{ url('atlantis/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ url('atlantis/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

	<!-- Datatables -->
	<script src="{{ url('atlantis/assets/js/plugin/datatables/datatables.min.js') }}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ url('atlantis/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

	<!-- Sweet Alert -->
	<script src="{{ url('atlantis/assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>

	<!-- Atlantis JS -->
	<script src="{{ url('atlantis/assets/js/atlantis.min.js') }}"></script>
    @yield('js')

</body>

</html>
