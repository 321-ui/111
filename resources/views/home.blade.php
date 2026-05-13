@extends('layouts.app')

@section('title', 'ОчУмелые ручки')

@section('header_auth')
	@auth
		<form action="{{ route('logout') }}" method="POST" style="display:inline;">
			@csrf
			<button type="submit" style="background:none;border:none;padding:0;cursor:pointer;color:#00044c;text-decoration:none;font-weight:bold;padding-left:20px;">Выход</button>
		</form>
	@else
		<a href="{{ route('login') }}" style="color:#00044c;text-decoration:none;font-weight:bold;padding-left:20px;">Вход</a>
	@endauth
@endsection

@section('content')
	<div class="main">
		<div class="row">
			<div class="hover"></div>
			<div class="title">Виды творчества</div>
			<div class="row--small grid between">
				<div class="content">
					<p>Добро пожаловать в клуб любителей творчества «ОчУмелые ручки»!</p>
					<p>Мы предлагаем мастер-классы по различным видам творчества. Выберите интересующий вас вид творчества из меню и запишитесь на мастер-класс.</p>
				</div>
				<ul class="menu">
					@foreach($categories as $category)
						<li><a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
@endsection
