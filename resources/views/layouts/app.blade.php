<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', 'ОчУмелые ручки')</title>
	<link rel="stylesheet" type="text/css" href="/Шаблоны/css/styles.css">
	<link rel="stylesheet" type="text/css" href="/Шаблоны/css/responsive.css">
</head>
<body class="@yield('body_class')">
	<div class="header">
		<div class="row grid middle between">
			<div class="logo">
				<img src="/Шаблоны/img/logo.png">
			</div>
			<div class="title">
				Клуб любителей творчества «ОчУмелые ручки»
			</div>
			<div class="auth">
				@yield('header_auth')
			</div>
		</div>
	</div>
	<div class="row row--nogutter">
		<div class="menu-burger">
			<div class="burger">
				<div></div>
				<div></div>
				<div></div>
			</div>
		</div>
	</div>
	<div class="row row--nogutter top-line">
		<div class="line"></div>
	</div>

	@yield('content')

	<div class="row row--nogutter">
		<div class="line"></div>
	</div>
	<div class="footer">
		<div class="row">
			<div class="row--small grid between">
				<div class="address">Наш адрес: ВДНХ, 120в</div>
				<div class="tel">Тел: 89123456765</div>
				<div class="copy">(с) Copyright, 2017</div>
			</div>
		</div>
	</div>
</body>
</html>
