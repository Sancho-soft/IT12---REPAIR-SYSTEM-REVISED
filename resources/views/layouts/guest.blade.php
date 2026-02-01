<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .auth-card {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo img {
            height: 60px;
            width: auto;
        }

        .btn-primary {
            background-color: #4c7cf3;
            border-color: #4c7cf3;
        }

        .btn-primary:hover {
            background-color: #3b6ae1;
            border-color: #3b6ae1;
        }
    </style>
</head>

<body>
    <div class="auth-card">
        <div class="auth-logo">
            <a href="/">
                <img src="{{ asset('img/Repair.png') }}" alt="Logo">
            </a>
            <h4 class="mt-3 text-dark">Repair System</h4>
        </div>

        {{ $slot }}
    </div>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>

</html>