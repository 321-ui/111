@extends('layouts.app')

@section('title', $masterClass->title)

@section('body_class', 'dp')

@section('header_auth')
	<a href="{{ route('cabinet') }}" style="color:#00044c;text-decoration:none;font-weight:bold;padding-left:20px;">Личный кабинет</a>
@endsection

@section('content')
	<div class="main">
		<div class="row">
			<div class="hover"></div>
			<div class="title"></div>
			<div class="row--small grid between">
				<div class="content driver-page">
					<div class="driver-page-photo">
						@if($masterClass->instructor->photo)
							<img src="{{ $masterClass->instructor->photo }}">
						@else
							<img src="/Шаблоны/img/driver-page.png">
						@endif
					</div>
					<div class="driver-page-name">{{ $masterClass->instructor->full_name }}</div>
					<div class="driver-page-text">
						<div class="driver-page-my">{{ $masterClass->title }}</div>
						<p>Категория: {{ $masterClass->category->name }}</p>
						<p>{{ $masterClass->description }}</p>
						<p>Дата: {{ $masterClass->date->format('d.m.Y') }}</p>
						<p>Время: {{ $masterClass->time }}</p>
						<p>Цена: {{ $masterClass->price }} руб.</p>
						<p>Макс. участников: {{ $masterClass->max_participants }}</p>
						<p>Свободных мест: {{ $masterClass->getAvailableSlots() }}</p>
						<h3>Участники</h3>
						@if($masterClass->registrations->isEmpty())
							<p>Нет участников</p>
						@else
							<ul>
								@foreach($masterClass->registrations as $registration)
									<li>{{ $registration->user->full_name }} ({{ $registration->user->email }})</li>
								@endforeach
							</ul>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
