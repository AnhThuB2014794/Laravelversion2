<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>E-SHOP HTML Template</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{ asset('client/css/bootstrap.min.css') }}" />

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="{{ asset('client/css/slick.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('client/css/slick-theme.css') }}" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="{{ asset('client/css/nouislider.min.css') }}" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{ asset('client/css/font-awesome.min.css') }}">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('client/css/style.css') }}" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>
    <!-- HEADER -->
    <header>
        <!-- top Header -->

        @include('client.layouts.topHeader')
        <!-- /top Header -->

        <!-- header -->

        @include('client.layouts.header')
        <!-- container -->
    </header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->

    @include('client.layouts.navigation')
    <!-- /NAVIGATION -->

    <!-- HOME -->

    @include('client.layouts.slider')
    <!-- /HOME -->

    <!-- section -->

    @include('client.layouts.collection')
    <!-- /section -->

    <!-- section -->

    @include('client.layouts.deal')
    <!-- /section -->

    <!-- section -->
    {{-- <div class="section section-grey">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- banner -->
				<div class="col-md-8">
					<div class="banner banner-1">
						<img src="./img/banner13.jpg" alt="">
						<div class="banner-caption text-center">
							<h1 class="primary-color">HOT DEAL<br><span class="white-color font-weak">Up to 50% OFF</span></h1>
							<button class="primary-btn">Shop Now</button>
						</div>
					</div>
				</div>
				<!-- /banner -->

				<!-- banner -->
				<div class="col-md-4 col-sm-6">
					<a class="banner banner-1" href="#">
						<img src="./img/banner11.jpg" alt="">
						<div class="banner-caption text-center">
							<h2 class="white-color">NEW COLLECTION</h2>
						</div>
					</a>
				</div>
				<!-- /banner -->

				<!-- banner -->
				<div class="col-md-4 col-sm-6">
					<a class="banner banner-1" href="#">
						<img src="./img/banner12.jpg" alt="">
						<div class="banner-caption text-center">
							<h2 class="white-color">NEW COLLECTION</h2>
						</div>
					</a>
				</div>
				<!-- /banner -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div> --}}
    <!-- /section -->

    <!-- section -->

    @include('client.layouts.product')
    <!-- /section -->

    <!-- FOOTER -->

    @include('client.layouts.footer')
    <!-- /FOOTER -->

    <!-- jQuery Plugins -->
    {{-- <script src="{{ asset('client/js/jquery.min.js') }}"></script>
    <script src="{{ asset('client/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('client/js/slick.min.js') }}"></script>
    <script src="{{ asset('client/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('client/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('client/js/main.js') }}"></script> --}}
    @include('client.layouts.jquery')

</body>

</html>