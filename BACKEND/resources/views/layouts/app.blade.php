<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Привычки')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        a {
            color: #3490dc;
            text-decoration: none;
        }

        form {
            margin-top: 15px;
        }

        input, textarea, button {
            display: block;
            width: 100%;
            margin-bottom: 15px;
            padding: 8px;
            font-size: 1rem;
        }

        button {
            background-color: #38c172;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #2f9e66;
        }

        label {
            font-weight: bold;
        }

        .nav {
            margin-bottom: 20px;
        }

        .nav a {
            margin-right: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="nav">
        <a href="{{ route('habits.index') }}">🏠 Главная</a>
        <a href="{{ route('habits.create') }}">➕ Новая привычка</a>
    </div>

    @yield('content')
</div>
</body>
</html>
