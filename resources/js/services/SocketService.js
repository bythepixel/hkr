if(process.NODE_ENV === 'development') {
    Pusher.logToConsole = true;
}

export default new Pusher(process.env.MIX_PUSHER_APP_KEY, {
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});
