<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html lang="zxx">

<head>
	<title>Smart Attendance with QR code</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- Meta tag Keywords -->
	<!-- css files -->
	<link rel="stylesheet" href="{{ asset('asset/css/style.css') }}" type="text/css" media="all" />
	<!-- Style-CSS -->
	<link rel="stylesheet" href="{{ asset('asset/css/fontawesome-all.css') }}">
	<!-- Font-Awesome-Icons-CSS -->
	<!-- //css files -->
	<!-- web-fonts -->
	<link href="//fonts.googleapis.com/css?family=Marck+Script&amp;subset=cyrillic,latin-ext" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=cyrillic,latin-ext"
	    rel="stylesheet">
	<!-- //web-fonts -->
</head>

<body>
	<div class="video-w3l" data-vide-bg="{{ asset('asset/video/1') }}">
		<!-- title -->
		<h1>
			<span>V</span>ideo
			<span>L</span>ogin
			<span>F</span>orm</h1>
		<!-- //title -->
		<!-- content -->

		<div class="sub-main-w3">
			<form action="#" method="post">
				<div class="form-style-agile">
					<label>
						<i class="fas fa-user"></i>Username</label>
					<input placeholder="Username" name="Name" type="text" required="">
				</div>
				<div class="form-style-agile">
					<label>
						<i class="fas fa-unlock-alt"></i>Password</label>
					<input placeholder="Password" name="Password" type="password" required="">
				</div>
				<!-- switch -->
				<div class="checkout-w3l">
					<div class="demo5">
						<div class="switch demo3">
							<input type="checkbox">
							<label>
								<i></i>
							</label>
						</div>
					</div>
					<a href="#">Remember Me</a>
				</div>
				<!-- //switch -->
				<input type="submit" value="Log In">
				<!-- social icons -->
				<div class="footer-social">
					<h2>Or Login With</h2>
					<ul>
						<li>
							<a href="#">
								<i class="fab fa-facebook-f icon_facebook"></i>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fab fa-twitter icon_twitter"></i>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fab fa-dribbble icon_dribbble"></i>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fab fa-google-plus-g icon_g_plus"></i>
							</a>
						</li>
					</ul>
				</div>
				<!-- //social icons -->
			</form>
		</div>
		<!-- //content -->

		<!-- copyright -->
		<div class="footer">
			<p>&copy; 2018 Video Login Form. All rights reserved | Design by
				<a href="http://w3layouts.com">W3layouts</a>
			</p>
		</div>
		<!-- //copyright -->
	</div>


	<!-- Jquery -->
	<script src="{{ asset('asset/js/jquery-2.2.3.min.js') }}"></script>
	<!-- //Jquery -->

	<!-- Video js -->
	<script src="{{ asset('asset/js/jquery.vide.min.js') }}"></script>
	<!-- //Video js -->

</body>

</html>
