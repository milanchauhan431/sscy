// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
firebase.initializeApp({
    apiKey: "AIzaSyAzPyb1V67xwvNyObcZ3THeXOYN4sJKLz8",
    authDomain: "toxscube-e1375.firebaseapp.com",
    projectId: "toxscube-e1375",
    storageBucket: "toxscube-e1375.appspot.com",
    messagingSenderId: "155244735852",
    appId: "1:155244735852:web:790c2b80c8919ceee11749",
    measurementId: "G-LJ0S3BEXT2"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();


// If you would like to customize notifications that are received in the
// background (Web app is closed or not in browser focus) then you should
// implement this optional method.
// [START background_handler]
messaging.setBackgroundMessageHandler(function (payload) {
    //console.log('[firebase-messaging-sw.js] Set background message ', payload);
	
    // Customize notification here
    payload = JSON.parse(payload.data.data);
    var notificationTitle = payload.title;
    var notificationOptions = {
        body : payload.message,
        icon : payload.image,
        tag : payload.onclick,
    };
    return self.registration.showNotification(notificationTitle,notificationOptions);  
});
// [END background_handler]

messaging.onBackgroundMessage((payload) => {
    //console.log('[firebase-messaging-sw.js] Received background message ', payload);
	
    // Customize notification here
    payload = JSON.parse(payload.data.data);
    //console.log('[firebase-messaging-sw.js] Received background message ', payload);
    var notificationTitle = payload.title;
    var notificationOptions = {
        body : payload.message,
        icon : payload.image,
        tag : payload.onclick,
    }; 
    return self.registration.showNotification(notificationTitle,notificationOptions);    
});

self.addEventListener('notificationclick', function(event) {
    var redirectUrl = event.notification.tag;
    //console.log('On notification click: ', event.notification);
    event.notification.close();
    
    if (redirectUrl) {   
        event.waitUntil(async function () {
            var allClients = await clients.matchAll({
                includeUncontrolled: true
            });
            var chatClient;            
            for (var i = 0; i < allClients.length; i++) {
                var client = allClients[i];                
                if (client['url'].indexOf(redirectUrl) >= 0) {
                    client.focus();
                    chatClient = client;
                    break;
                }
            }

            if (chatClient == null || chatClient == 'undefined') {
                chatClient = clients.openWindow(redirectUrl);
                return chatClient;
            }

            // Check if the web app is installed
            if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone) {
                // Web app is installed, focus on it
                chatClient.focus();
            }
        }());        
    }
});