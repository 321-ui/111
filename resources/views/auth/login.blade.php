@extends('layouts.app')

@section('title', 'Вход')

@section('header_auth')
	<a href="{{ route('home') }}" style="color:#00044c;text-decoration:none;font-weight:bold;padding-left:20px;">На главную</a>
@endsection

@section('content')
	<div class="main">
		<div class="row">
			<div class="row--small">
				@if(session('success'))
					<p style="color: green;">{{ session('success') }}</p>
				@endif

				@if($errors->any())
					@foreach($errors->all() as $error)
						<p style="color: red;">{{ $error }}</p>
					@endforeach
				@endif

				<form method="POST" action="{{ route('login') }}">
					@csrf
					<h2>Форма авторизации</h2>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" value="{{ old('email') }}" required>
					</div>
					<div class="form-group">
						<label>Пароль</label>
						<input type="password" name="password" required>
					</div>
					<div class="form-group">
						<button class="btn" type="submit">Войти</button>
					</div>
					<div class="form-group">
						<p>Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a></p>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
