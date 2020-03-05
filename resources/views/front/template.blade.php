<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>Hackathonizer</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ url('/') }}" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

</head>
<body>
<div id="app">
    @yield('content')
</div>
<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
