@extends('layouts.app')

@section('content')
    <h1>Создание привычки</h1>

    <form action="{{ route('habits.store') }}" method="POST">
        @csrf
        <label>Название:</label>
        <input type="text" name="title" required><br>

        <label>Описание:</label>
        <textarea name="description"></textarea><br>

        <label>Время напоминания:</label>
        <input type="time" name="reminder_time"><br>

        <input type="hidden" name="user_id" value="1">


        <label>Дни недели:</label><br>
        @for ($i = 0; $i < 7; $i++)
            <label>
                <input type="checkbox" name="day_ids[]" value="{{ $i }}"> {{ \Carbon\Carbon::create()->startOfWeek()->addDays($i)->format('l') }}
            </label><br>
        @endfor

        <button type="submit">Сохранить</button>
    </form>
@endsection
