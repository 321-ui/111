@extends('layouts.app')

@section('title', 'Регистрация')

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

				@if(session('error'))
					<p style="color: red;">{{ session('error') }}</p>
				@endif

				@if($errors->any())
					@foreach($errors->all() as $error)
						<p style="color: red;">{{ $error }}</p>
					@endforeach
				@endif

				<form method="POST" action="{{ route('register') }}">
					@csrf
					<h2>Форма регистрации</h2>
					<div class="form-group">
						<label>ФИО</label>
						<input type="text" name="full_name" value="{{ old('full_name') }}" required>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" value="{{ old('email') }}" required>
					</div>
					<div class="form-group">
						<label>Пароль</label>
						<input type="password" name="password" required>
					</div>
					<div class="form-group">
						<label>Номер телефона</label>
						<input type="tel" name="phone" value="{{ old('phone') }}" required>
					</div>
					<div class="form-group">
						<button class="btn" type="submit">Отправить</button>
					</div>
					<div class="form-group">
						<p>Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
