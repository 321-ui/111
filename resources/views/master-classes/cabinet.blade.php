@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('body_class', 'dp')

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
			<div class="title"></div>
			<div class="row--small grid between">
				<div class="content driver-page">
					<div class="driver-page-photo">
						@if(Auth::user()->photo)
							<img src="{{ Auth::user()->photo }}">
						@else
							<img src="/Шаблоны/img/driver-page.png">
						@endif
					</div>
					<div class="driver-page-name">{{ Auth::user()->full_name }}</div>
					<div class="driver-page-text">
						<div class="driver-page-my">Мои мастер-классы</div>
						<table class="driver-page-table">
							<tbody>
								@if($masterClasses->isEmpty())
									<tr>
										<td colspan="2">У вас пока нет мастер-классов</td>
									</tr>
								@else
									@foreach($masterClasses as $masterClass)
										<tr>
											<td>{{ $masterClass->title }}</td>
											<td>
												<a href="{{ route('master-classes.edit', $masterClass->id) }}">Редактировать</a>
												<a href="{{ route('master-classes.show', $masterClass->id) }}">Просмотреть</a>
											</td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>
				<div class="content">
					<a href="{{ route('master-classes.create') }}" class="btn">Добавить мастер-класс</a>
				</div>
			</div>
		</div>
	</div>
@endsection
