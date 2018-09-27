@extends('front.template')

@section('content')
    <div id="landing">
        <h1>Hackathonizer</h1>
        <button role="button">Create a Hackathon</button>
        <ul class="hackathons-list">
            <li><h2><a href="#">By the Pixel Hackathon</a></h2></li>
            <li><h2><a href="#">Some Other Hackathon</a></h2></li>
            <li><h2><a href="#">Hackerman’s Hacky Sack</a></h2></li>
        </ul>
        <div class="input-wrapper">
            <input type="text" name="username" required="">
            <label>Username</label>
        </div>
        <div class="input-wrapper">
            <input type="password" name="password" required="">
            <label>Password</label>
        </div>
        <button role="button">Login</button>

    </div>
@endsection
