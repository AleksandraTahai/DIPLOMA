<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Напоминание</title>
</head>
<body>
<h2>Привет!</h2>

<p>Не забудь выполнить привычку:</p>
<strong>{{ $habit->title }}</strong>

<p>Описание: {{ $habit->description ?? 'без описания' }}</p>

<p>— Ваш помощник по привычкам !!!</p>
</body>
</html>
