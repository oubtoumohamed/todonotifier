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
    <div id="allow-push-notification-bar" class="allow-push-notification-bar">
    <div class="content">
        <div class="text">
            Want to get notification from us?
        </div>
        <div class="buttons-more">
            <button type="button" class="ok-button button-1" id="allow-push-notification">
                Yes
            </button>
            <button type="button" class="ok-button button-1" id="close-push-notification">
                No
            </button>
        </div>
    </div>
</div>
    <div class="container">
        @yield('content')
    </div>
    
    <script>
        const publicVapidKey = '{{ config('webpush.vapid.public_key') }}';
    </script>
</body>
</html>