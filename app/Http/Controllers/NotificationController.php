<?php
namespace App\Http\Controllers;

use App\Models\NotificationSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class NotificationController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'endpoint' => 'required',
            'keys.auth' => 'required',
            'keys.p256dh' => 'required'
        ]);

        Auth::user()->notificationSubscriptions()->updateOrCreate(
            ['endpoint' => $request->endpoint],
            [
                'public_key' => $request->keys['p256dh'],
                'auth_token' => $request->keys['auth']
            ]
        );

        return response()->json(['success' => true]);
    }

    public function unsubscribe(Request $request)
    {
        $request->validate(['endpoint' => 'required']);
        
        Auth::user()
            ->notificationSubscriptions()
            ->where('endpoint', $request->endpoint)
            ->delete();

        return response()->json(['success' => true]);
    }

    public static function sendNotification($user, $title, $body)
    {
        $subscriptions = $user->notificationSubscriptions;
        
        if ($subscriptions->isEmpty()) {
            return false;
        }

        $webPush = new WebPush([
            'VAPID' => [
                'subject' => config('app.url'),
                'publicKey' => config('webpush.vapid.public_key'),
                'privateKey' => config('webpush.vapid.private_key'),
            ]
        ]);

        foreach ($subscriptions as $subscription) {
            $webPush->queueNotification(
                Subscription::create([
                    'endpoint' => $subscription->endpoint,
                    'publicKey' => $subscription->public_key,
                    'authToken' => $subscription->auth_token,
                ]),
                json_encode([
                    'title' => $title,
                    'body' => $body,
                    'icon' => asset('images/notification-icon.png'),
                    'url' => url('/')
                ])
            );
        }

        return $webPush->flush();
    }
    
    public function getVapidPublicKey()
    {
        return response()->json([
            'publicKey' => config('webpush.vapid.public_key')
        ]);
    }
}