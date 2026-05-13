@extends('layouts.app')

@section('title', $category->name)

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
			<div class="title">{{ $category->name }}</div>
			<div class="row--small grid between">
				<div class="content">
					<img src="/Шаблоны/img/elifant.png">
					<p>{!! nl2br(e($category->description)) !!}</p>
				</div>
				<ul class="menu">
					@foreach(\App\Models\Category::all() as $cat)
						<li><a href="{{ route('categories.show', $cat->id) }}">{{ $cat->name }}</a></li>
					@endforeach
				</ul>
			</div>

			<div class="row shedule">
				<div class="row--small">
					<h2>Расписание</h2>
					<div class="drivers">
						@if($masterClasses->isEmpty())
							<p>Мастер-классы пока не запланированы.</p>
						@else
							@foreach($masterClasses as $masterClass)
								<div class="driver grid">
									<div class="driver-left grid">
										<div class="driver-photo">
											@if($masterClass->instructor->photo)
												<img src="{{ $masterClass->instructor->photo }}">
											@else
												<img src="/Шаблоны/img/driver1.png">
											@endif
										</div>
										<div class="driver-text">
											<div class="driver-name">{{ $masterClass->instructor->full_name }}</div>
											<div class="driver-desc">
												{{ $masterClass->title }}<br>
												{{ $masterClass->description }}<br>
												Стоимость: {{ $masterClass->price }} руб.<br>
												Свободных мест: {{ $masterClass->getAvailableSlots() }} из {{ $masterClass->max_participants }}
											</div>
										</div>
									</div>
									<div class="driver-right">
										@auth
											@if($masterClass->registrations->contains('user_id', Auth::id()))
												<button class="driver-btn" disabled>записан</button>
											@elseif($masterClass->isAvailable())
												<a href="{{ route('registrations.confirm', $masterClass->id) }}" class="driver-btn">записаться</a>
											@else
												<button class="driver-btn" disabled>мест нет</button>
											@endif
										@endauth
										<div class="driver-time">{{ $masterClass->date->format('d.m.Y') }} {{ $masterClass->time }}</div>
									</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
