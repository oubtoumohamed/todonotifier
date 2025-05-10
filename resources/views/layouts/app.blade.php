<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Notifier</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script type="module" src="{{ asset('js/app.js') }}"></script>

        <meta name="csrf-token" content="{{ csrf_token() }}">


</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    
    <script>
        const publicVapidKey = '{{ config('webpush.vapid.public_key') }}';
    </script>
</body>
</html>