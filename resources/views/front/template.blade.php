<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>Hackathon Application</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ url('/') }}" />
</head>
<body>
@yield('content')
</body>
</html>
