@extends('layouts.app')

@section('title', 'Мои записи')

@section('header_auth')
	<form action="{{ route('logout') }}" method="POST" style="display:inline;">
		@csrf
		<button type="submit" style="background:none;border:none;padding:0;cursor:pointer;color:#00044c;text-decoration:none;font-weight:bold;padding-left:20px;">Выход</button>
	</form>
@endsection

@section('content')
	<div class="main">
		<div class="row">
			<div class="hover"></div>
			<div class="title">Виды творчества</div>
			<div class="row--small grid between">
				<div class="content">
					@if($registrations->isEmpty())
						<p>Вы не записаны ни на один мастер-класс</p>
					@else
						<h2>Ваши записи</h2>
						@foreach($registrations as $registration)
							<div class="driver grid">
								<div class="driver-left grid">
									<div class="driver-text">
										<div class="driver-name">{{ $registration->masterClass->title }}</div>
										<div class="driver-desc">
											Вид: {{ $registration->masterClass->category->name }}<br>
											Мастер: {{ $registration->masterClass->instructor->full_name }}<br>
											Дата: {{ $registration->masterClass->date->format('d.m.Y') }}<br>
											Время: {{ $registration->masterClass->time }}
										</div>
									</div>
								</div>
							</div>
						@endforeach
					@endif
				</div>
				<ul class="menu">
					@foreach(\App\Models\Category::all() as $category)
						<li><a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
@endsection
