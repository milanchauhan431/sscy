// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries
// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyAzPyb1V67xwvNyObcZ3THeXOYN4sJKLz8",
    authDomain: "toxscube-e1375.firebaseapp.com",
    projectId: "toxscube-e1375",
    storageBucket: "toxscube-e1375.appspot.com",
    messagingSenderId: "155244735852",
    appId: "1:155244735852:web:790c2b80c8919ceee11749",
    measurementId: "G-LJ0S3BEXT2"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
messaging.usePublicVapidKey("BA-lNqG3-Zd2Pptt-jnVQOQzt91MEfmvCabFWuK4ZDXOutTU-BSeP9UNdnoqt4765hvfc7WHMcBtPtaJfIvjbRs");

// Get Instance ID token. Initially this makes a network call, once retrieved
// subsequent calls to getToken will return from cache.
messaging.getToken({ vapidKey: 'BA-lNqG3-Zd2Pptt-jnVQOQzt91MEfmvCabFWuK4ZDXOutTU-BSeP9UNdnoqt4765hvfc7WHMcBtPtaJfIvjbRs' }).then((currentToken) => {
    if (currentToken) {
        $("#loginform #app_push_token").val(currentToken);
    } else {
        // Show permission request.
        console.log('No Instance ID token available. Request permission to generate one.');
    }
}).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
});

// Handle incoming messages. Called when:
// - a message is received while the app has focus
// - the user clicks on an app notification created by a service worker
//   `messaging.setBackgroundMessageHandler` handler.
messaging.onMessage((payload) => {
    payload = JSON.parse(payload.data.data);
    var notificationTitle = payload.title;
    var notificationOptions = {
        body: payload.message,
        icon : payload.image,
        tag : payload.onclick,
    };

    const notification = new Notification(notificationTitle, notificationOptions);

    // Handle the click event
    notification.onclick = function () {
        window.open(payload.onclick);
        /* // Check if the window is already open
        var isOpen = false;

        // Iterate through existing windows
        $.each(window.frames, function (index, frame) {
            if (frame.location.href === payload.onclick) {
                isOpen = true;
                // Focus on the existing window
                frame.focus();
                return false; // Exit the loop
            }
        });

        // If the window is not open, open a new one
        if (!isOpen) {
            window.open(payload.onclick);
        } */
    };
});

