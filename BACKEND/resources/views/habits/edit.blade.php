@extends('layouts.app')

@section('content')
    <h1>Редактирование привычки</h1>

    <form action="{{ route('habits.update', $habit->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Название:</label>
        <input type="text" name="title" value="{{ $habit->title }}" required><br>

        <label>Описание:</label>
        <textarea name="description">{{ $habit->description }}</textarea><br>

        <label>Время напоминания:</label>
        <input type="time" name="reminder_time" value="{{ $habit->reminder_time }} "><br>

        <label>Дни недели:</label><br>

        @for ($i = 0; $i < 7; $i++)
            <label>
                <input type="checkbox" name="day_ids[]" value="{{ $i }}"
                    {{ $habit->days->pluck('id')->contains($i) ? 'checked' : '' }}>
                {{ \Carbon\Carbon::create()->startOfWeek()->addDays($i)->format('l') }}
            </label><br>
        @endfor

        <button type="submit">Обновить</button>
    </form>
@endsection
