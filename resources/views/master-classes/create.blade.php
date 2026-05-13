@extends('layouts.app')

@section('title', 'Добавление мастер-класса')

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

				<form method="POST" action="{{ route('master-classes.store') }}">
					@csrf
					<h2>Форма добавления мастер-класса</h2>
					<div class="form-group">
						<label>Вид творчества</label>
						<select name="category_id" required>
							<option value="">Выберите вид</option>
							@foreach($categories as $category)
								<option value="{{ $category->id }}">{{ $category->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Название мастер-класса</label>
						<input type="text" name="title" value="{{ old('title') }}" required>
					</div>
					<div class="form-group">
						<label>Описание мастер-класса</label>
						<textarea name="description" required>{{ old('description') }}</textarea>
					</div>
					<div class="form-group">
						<label>Дата</label>
						<input type="date" name="date" id="date" value="{{ old('date') }}" required>
					</div>
					<div class="form-group">
						<label>Время</label>
						<select name="time" id="time" required>
							<option value="">Выберите время</option>
							@foreach($timeSlots as $slot)
								<option value="{{ $slot }}">{{ $slot }} - {{ date('H:i', strtotime($slot . ' +2 hours')) }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Количество человек в группе</label>
						<input type="number" name="max_participants" value="{{ old('max_participants') }}" min="1" required>
					</div>
					<div class="form-group">
						<label>Стоимость (руб.)</label>
						<input type="number" name="price" value="{{ old('price') }}" min="0" step="0.01" required>
					</div>
					<div class="form-group">
						<button class="btn" type="submit">Отправить</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		const dateInput = document.getElementById('date');
		const timeSelect = document.getElementById('time');
		const timeSlots = ['09:00', '11:00', '13:00', '15:00'];
		const instructorId = {{ Auth::id() }};

		function updateTimeSlots() {
			const date = dateInput.value;
			if (!date) return;

			fetch(`/api/busy-slots?date=${date}&instructor_id=${instructorId}`)
				.then(response => response.json())
				.then(busyTimes => {
					timeSelect.innerHTML = '<option value="">Выберите время</option>';

					timeSlots.forEach(slot => {
						const option = document.createElement('option');
						option.value = slot;

						const endTime = new Date('2000-01-01T' + slot + ':00');
						endTime.setHours(endTime.getHours() + 2);
						const endTimeStr = endTime.toTimeString().slice(0, 5);

						if (busyTimes.includes(slot)) {
							option.disabled = true;
							option.textContent = slot + ' - ' + endTimeStr + ' (занято)';
						} else {
							option.textContent = slot + ' - ' + endTimeStr;
						}

						timeSelect.appendChild(option);
					});
				});
		}

		dateInput.addEventListener('change', updateTimeSlots);
	</script>
@endsection
