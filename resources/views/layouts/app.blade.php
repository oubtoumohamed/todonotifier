<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Notifier</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script type="module" src="{{ asset('js/app.js') }}?v=0.01"></script>

        <meta name="csrf-token" content="{{ csrf_token() }}">

   <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .notification-box {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            background-color: #f9f9f9;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }
        button:hover {
            background-color: #45a049;
        }
        #status {
            margin-top: 20px;
            font-style: italic;
        }
    </style>

    
</head>
<body>
    
    <div class="notification-box">
        <h2>Enable Notifications</h2>
        <p>Click the button below to allow notifications from our website.</p>
        <button id="notificationBtn">Allow Notifications</button>
        <p id="status"></p>
    </div>

    <div class="container">
        @yield('content')
    </div>
    
    <script>
        const publicVapidKey = '{{ config('webpush.vapid.public_key') }}';
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBtn = document.getElementById('notificationBtn');
            const statusElement = document.getElementById('status');
            
            // Check if browser supports notifications
            if (!('Notification' in window)) {
                statusElement.textContent = 'This browser does not support notifications.';
                notificationBtn.disabled = true;
                return;
            }
            
            // Check existing permission
            if (Notification.permission === 'granted') {
                statusElement.textContent = 'Notifications are already enabled!';
                notificationBtn.textContent = 'Notifications Enabled';
                notificationBtn.disabled = true;
            } else if (Notification.permission === 'denied') {
                statusElement.textContent = 'You have blocked notifications. Please enable them in your browser settings.';
                notificationBtn.disabled = true;
            }
            
            // Button click event
            notificationBtn.addEventListener('click', function() {
                Notification.requestPermission()
                    .then(function(permission) {
                        if (permission === 'granted') {
                            statusElement.textContent = 'Thank you! You will now receive notifications.';
                            notificationBtn.textContent = 'Notifications Enabled';
                            notificationBtn.disabled = true;
                            
                            // Send a test notification
                            const notification = new Notification('Notification Enabled', {
                                body: 'You have successfully enabled notifications!',
                                icon: '/api/placeholder/64/64'
                            });
                            
                        } else if (permission === 'denied') {
                            statusElement.textContent = 'You have declined notification permissions.';
                        } else {
                            statusElement.textContent = 'You closed the permission prompt without making a choice.';
                        }
                    });
            });
        });
    </script>

</body>
</html>