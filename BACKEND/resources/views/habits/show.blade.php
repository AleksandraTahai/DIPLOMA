@extends('layouts.app')

@section('content')
    <h1>{{ $habit->title }}</h1>

    <p>{{ $habit->description }}</p>
    <p>Напоминание: {{ $habit->reminder_time }}</p>

    <p><strong>Дни:</strong>
        @foreach($habit->days as $day)
            {{ \Carbon\Carbon::create()->startOfWeek()->addDays($day->id)->format('l') }},
        @endforeach
    </p>

    <p><a href="{{ route('habits.edit', $habit->id) }}">Редактировать</a></p>
    <p><a href="{{ route('habits.index') }}">← Назад</a></p>
@endsection
