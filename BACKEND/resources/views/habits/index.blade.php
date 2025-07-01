@extends('layouts.app')

@section('content')
    <h1>Список привычек</h1>

    <a href="{{ route('habits.create') }}">Создать привычку</a>

    <ul>
        @foreach($habits as $habit)
            <li>
                <a href="{{ route('habits.show', $habit->id) }}">{{ $habit->title }}</a>
                <a href="{{ route('habits.edit', $habit->id) }}">✏️</a>
                <form action="{{ route('habits.destroy', $habit->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">🗑️</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
