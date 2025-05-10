require('./bootstrap');

if ('serviceWorker' in navigator && 'PushManager' in window) {
    window.addEventListener('load', async () => {
        try {
            const registration = await navigator.serviceWorker.register('sw.js');
            console.log('ServiceWorker registration successful');

            
        // Request notification permission
        const permissionGranted = await requestNotificationPermission();
        if (!permissionGranted) return false;
            
            await subscribeUser(registration);
        } catch (err) {
            console.log('ServiceWorker registration failed: ', err);
        }
    });
}

async function subscribeUser(registration) {
    const subscription = await registration.pushManager.getSubscription();
    
    if (subscription) {
        return sendSubscriptionToServer(subscription);
    }

    const response = await fetch('api/vapid-public-key');
    const vapidPublicKey = await response.json();
    const convertedVapidKey = urlBase64ToUint8Array(vapidPublicKey.publicKey);

    const newSubscription = await registration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: convertedVapidKey
    });

    sendSubscriptionToServer(newSubscription);
}

function sendSubscriptionToServer(subscription) {
    return fetch('notification/subscribe', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(subscription)
    });
}

const requestNotificationPermission = async () => {
    if (!('Notification' in window)) {
        console.error('This browser does not support notifications.');
        return false;
    }
    
    if (Notification.permission === 'granted') {
        return true;
    }
    
    if (Notification.permission !== 'denied') {
        const permission = await Notification.requestPermission();
        return permission === 'granted';
    }
    
    return false;
};


function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}