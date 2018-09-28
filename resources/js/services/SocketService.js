// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

export default new Pusher('11c80cd23bdfb3cfc21f', {
    cluster: 'us2',
    forceTLS: true
});
