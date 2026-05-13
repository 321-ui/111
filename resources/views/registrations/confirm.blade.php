@extends('layouts.app')

@section('title', 'Подтверждение записи')

@section('header_auth')
	<a href="{{ route('home') }}" style="color:#00044c;text-decoration:none;font-weight:bold;padding-left:20px;">На главную</a>
@endsection

@section('content')
	<div class="main">
		<div class="row">
			<div class="row--small">
				@if($errors->any())
					@foreach($errors->all() as $error)
						<p style="color: red;">{{ $error }}</p>
					@endforeach
				@endif

				<h2>Подтверждение записи на мастер-класс</h2>
				<form method="POST" action="{{ route('registrations.store', $masterClass->id) }}">
					@csrf
					<div class="form-group">
						<label>ФИО:</label>
						<p>{{ $user->full_name }}</p>
					</div>
					<div class="form-group">
						<label>Вид творчества:</label>
						<p>{{ $masterClass->category->name }}</p>
					</div>
					<div class="form-group">
						<label>ФИО мастера:</label>
						<p>{{ $masterClass->instructor->full_name }}</p>
					</div>
					<div class="form-group">
						<label>Мастер-класс:</label>
						<p>{{ $masterClass->title }}</p>
					</div>
					<div class="form-group">
						<label>Дата:</label>
						<p>{{ $masterClass->date->format('d.m.Y') }}</p>
					</div>
					<div class="form-group">
						<label>Время:</label>
						<p>{{ $masterClass->time }}</p>
					</div>
					<div class="form-group">
						<label>Стоимость:</label>
						<p>{{ $masterClass->price }} руб.</p>
					</div>
					<div class="form-group">
						<button type="submit" name="confirm" class="btn">Подтвердить</button>
						<button type="button" class="btn" onclick="window.location.href='{{ route('categories.show', $masterClass->category_id) }}'">Отменить</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
