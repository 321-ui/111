@extends('layouts.app')

@section('title', 'Редактирование мастер-класса')

@section('header_auth')
	<a href="{{ route('cabinet') }}" style="color:#00044c;text-decoration:none;font-weight:bold;padding-left:20px;">Личный кабинет</a>
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

				<form method="POST" action="{{ route('master-classes.update', $masterClass->id) }}">
					@method('PUT')
					@csrf
					<h2>Редактирование мастер-класса</h2>
					<div class="form-group">
						<label>Вид творчества</label>
						<input type="text" value="{{ $masterClass->category->name }}" disabled>
					</div>
					<div class="form-group">
						<label>Название мастер-класса</label>
						<input type="text" value="{{ $masterClass->title }}" disabled>
					</div>
					<div class="form-group">
						<label>Описание мастер-класса</label>
						<textarea name="description" required>{{ $masterClass->description }}</textarea>
					</div>
					<div class="form-group">
						<label>Дата</label>
						<input type="text" value="{{ $masterClass->date->format('d.m.Y') }}" disabled>
					</div>
					<div class="form-group">
						<label>Время</label>
						<input type="text" value="{{ $masterClass->time }}" disabled>
					</div>
					<div class="form-group">
						<label>Количество человек в группе</label>
						<input type="text" value="{{ $masterClass->max_participants }}" disabled>
					</div>
					<div class="form-group">
						<label>Стоимость (руб.)</label>
						<input type="number" name="price" value="{{ $masterClass->price }}" min="0" step="0.01" required>
					</div>
					<div class="form-group grid between">
						<button class="btn" type="submit">Сохранить</button>
						<form method="POST" action="{{ route('master-classes.destroy', $masterClass->id) }}" style="display:inline;">
							@csrf
							@method('DELETE')
							<button type="submit" class="btn" style="background:#dc3545;color:white;border-color:#dc3545;" onclick="return confirm('Вы уверены, что хотите удалить этот мастер-класс?')">Удалить</button>
						</form>
					</div>
					<div class="form-group">
						<a href="{{ route('cabinet') }}">Отмена</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
