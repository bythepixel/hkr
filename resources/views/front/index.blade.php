@extends('front.template')

@section('content')
    <!-- Login -->
    <div id="login">
        <div class="container">
            <h1>Login</h1>
            <div class="field-wrapper">
                <input type="text" name="username" required="">
                <label>Username</label>
            </div>
            <div class="field-wrapper">
                <input type="password" name="password" required="">
                <label>Password</label>
            </div>
            <button role="button">Login</button>
        </div>
    </div>

    <hr style="margin: 0 auto;">

    <!-- Hackathons List -->
    <div id="hackathons">
        <div class="container">
            <div id="top-section">
                <ol class="breadcrumbs">
                  <li class="breadcrumb-item active">Hackathonizer</li>
                </ol>
                <button role="button">Create a Hackathon</button>
            </div>
            <ul>
                <li><h2><a href="#">By the Pixel Hackathon</a></h2></li>
                <li><h2><a href="#">Some Other Hackathon</a></h2></li>
                <li><h2><a href="#">Hackerman’s Hacky Sack</a></h2></li>
            </ul>
        </div>
    </div>

    <hr style="margin: 0 auto;">

    <!-- Create a Hackathon -->
    <div id="create">
        <div class="container">
            <h1>Create a Hackathon</h1>
            <div class="field-wrapper">
                <input type="text" name="hackathon" required="">
                <label>Name of Hackathon</label>
            </div>
            <button role="button">Create</button>
        </div>
    </div>

    <hr style="margin: 0 auto;">

    <!-- Hackathons Ideas List -->
    <div id="hackathon-ideas">
        <div class="container">
            <div id="top-section">
                <ol class="breadcrumbs">
                  <li class="breadcrumb-item"><a href="#">Hackathonizer</a></li>
                  <li class="breadcrumb-item"><a href="#">Hackerman’s Hacky Sack</a></li>
                  <li class="breadcrumb-item active">Time to Fly</li>
                </ol>
                <button role="button">Add an Idea</button>
            </div>
            <ul>
                <li id="hackathon-details">
                    <div class="vote-wrapper">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56.148 56.148"><defs></defs><path class="a" d="M0,0H56.148V56.148H0Z"/><path class="b" d="M1,47.79h9.358V19.716H1ZM52.469,22.056a4.693,4.693,0,0,0-4.679-4.679H33.028L35.251,6.685l.07-.749a3.522,3.522,0,0,0-1.029-2.48L31.811,1,16.417,16.417a4.574,4.574,0,0,0-1.38,3.3v23.4a4.693,4.693,0,0,0,4.679,4.679H40.772a4.647,4.647,0,0,0,4.3-2.854l7.065-16.494a4.622,4.622,0,0,0,.328-1.708Z" transform="translate(1.34 1.34)"/></svg>
                        <div class="vote-count">7</div>
                    </div>
                    <div class="content-wrapper">
                        <h2><a href="#">Rescue-App</a></h2>
                        <p class="created-by">By Roeland Reyniers, 7 Comments</p>
                        <p class="description">Unicorn franzen you probably haven’t heard of them coloring book. Vape vaporware meh, cardigan trust fund chicharrones fam 90’s mlkshk. Occupy woke mumblecore, bushwick everyday carry chartreuse viral hashtag.</p>
                    </div>
                </li>
                <li id="hackathon-details">
                    <div class="vote-wrapper voted">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56.148 56.148"><defs></defs><path class="a" d="M0,0H56.148V56.148H0Z"/><path class="b" d="M1,47.79h9.358V19.716H1ZM52.469,22.056a4.693,4.693,0,0,0-4.679-4.679H33.028L35.251,6.685l.07-.749a3.522,3.522,0,0,0-1.029-2.48L31.811,1,16.417,16.417a4.574,4.574,0,0,0-1.38,3.3v23.4a4.693,4.693,0,0,0,4.679,4.679H40.772a4.647,4.647,0,0,0,4.3-2.854l7.065-16.494a4.622,4.622,0,0,0,.328-1.708Z" transform="translate(1.34 1.34)"/></svg>
                        <div class="vote-count">1</div>
                    </div>
                    <div class="content-wrapper">
                        <h2><a href="#">Time2Fly</a></h2>
                        <p class="created-by">By Roeland Reyniers, 0 Comments</p>
                        <p class="description">Unicorn franzen you probably haven’t heard of them coloring book. Vape vaporware meh, cardigan trust fund chicharrones fam 90’s mlkshk. Occupy woke mumblecore, bushwick everyday carry chartreuse viral hashtag.</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <hr style="margin: 0 auto;">

    <!-- Add Hackathon Idea -->
    <div id="hackathon-idea-add">
        <div class="container">
            <h1>Hackathon Idea</h1>
            <div class="field-wrapper">
                <input type="text" name="title" required="">
                <label>Title</label>
            </div>
            <div class="field-wrapper">
                <textarea rows="4" cols="50" required=""></textarea>
                <label>Description</label>
            </div>
            <button role="button">Add</button>
        </div>
    </div>

    <hr style="margin: 0 auto;">

    <!-- View Single Hackathon Idea -->
    <div id="hackathon-idea-single">
        <div class="container">
            <div id="top-section">
                <ol class="breadcrumbs">
                  <li class="breadcrumb-item"><a href="#">Hackathonizer</a></li>
                  <li class="breadcrumb-item"><a href="#">Hackerman’s Hacky Sack</a></li>
                  <li class="breadcrumb-item active">Rescue App</li>
                </ol>
            </div>
            <div id="hackathon-details">
                <div class="vote-wrapper">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56.148 56.148"><defs></defs><path class="a" d="M0,0H56.148V56.148H0Z"/><path class="b" d="M1,47.79h9.358V19.716H1ZM52.469,22.056a4.693,4.693,0,0,0-4.679-4.679H33.028L35.251,6.685l.07-.749a3.522,3.522,0,0,0-1.029-2.48L31.811,1,16.417,16.417a4.574,4.574,0,0,0-1.38,3.3v23.4a4.693,4.693,0,0,0,4.679,4.679H40.772a4.647,4.647,0,0,0,4.3-2.854l7.065-16.494a4.622,4.622,0,0,0,.328-1.708Z" transform="translate(1.34 1.34)"/></svg>
                    <div class="vote-count">7</div>
                </div>
                <div class="content-wrapper">
                    <h2>Rescue-App</h2>
                    <p class="created-by">By Roeland Reyniers, 7 Comments</p>
                    <p class="description">Unicorn franzen you probably haven’t heard of them coloring book. Vape vaporware meh, cardigan trust fund chicharrones fam 90’s mlkshk. Occupy woke mumblecore, bushwick everyday carry chartreuse viral hashtag.</p>
                    <div class="features">
                        <h3>Features</h3>
                        <ul>
                            <li>
                                <div class="vote-wrapper">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56.148 56.148"><defs></defs><path class="a" d="M0,0H56.148V56.148H0Z"/><path class="b" d="M1,47.79h9.358V19.716H1ZM52.469,22.056a4.693,4.693,0,0,0-4.679-4.679H33.028L35.251,6.685l.07-.749a3.522,3.522,0,0,0-1.029-2.48L31.811,1,16.417,16.417a4.574,4.574,0,0,0-1.38,3.3v23.4a4.693,4.693,0,0,0,4.679,4.679H40.772a4.647,4.647,0,0,0,4.3-2.854l7.065-16.494a4.622,4.622,0,0,0,.328-1.708Z" transform="translate(1.34 1.34)"/></svg>
                                </div>
                                <div class="vote-count">7</div>
                                <h4>Offline Capability</h4>
                            </li>
                            <li>
                                <div class="vote-wrapper voted">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56.148 56.148"><defs></defs><path class="a" d="M0,0H56.148V56.148H0Z"/><path class="b" d="M1,47.79h9.358V19.716H1ZM52.469,22.056a4.693,4.693,0,0,0-4.679-4.679H33.028L35.251,6.685l.07-.749a3.522,3.522,0,0,0-1.029-2.48L31.811,1,16.417,16.417a4.574,4.574,0,0,0-1.38,3.3v23.4a4.693,4.693,0,0,0,4.679,4.679H40.772a4.647,4.647,0,0,0,4.3-2.854l7.065-16.494a4.622,4.622,0,0,0,.328-1.708Z" transform="translate(1.34 1.34)"/></svg>
                                </div>
                                <div class="vote-count">2</div>
                                <h4>Pasta Maker</h4>
                            </li>
                        </ul>
                        <button role="button">Add a Feature</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="discussion">
            <div class="container">
                <div class="submit-comment">
                    <div class="field-wrapper">
                        <input type="text" name="comment" required="">
                        <label>Join the conversation...</label>
                    </div>
                    <p class="small-text">Press "Enter" to Add</p>
                </div>
                <ul class="comments-wrapper">
                    <li>
                        <p class="name">John Doe <span class="small-text time">a min ago</span></p>
                        <p class="comment">Unicorn franzen you probably haven’t heard of them coloring book. Vape vaporware meh, cardigan trust fund.</p>
                        <p class="reply"><a href="#">Reply</a></p>
                    </li>
                    <li>
                        <p class="name">John Doe <span class="small-text time">7 days ago</span></p>
                        <p class="comment">Unicorn franzen you probably haven’t heard of them coloring book. Vape vaporware meh, cardigan trust fund chicharrones fam 90’s mlkshk. Occupy woke mumblecore.</p>
                        <p class="reply"><a href="#">Reply</a></p>
                        <ul>
                            <li>
                                <p class="name">John Doe <span class="small-text time">a min ago</span></p>
                                <p class="comment">Unicorn franzen you probably haven’t heard of them coloring book. Vape vaporware meh, cardigan trust fund chicharrones fam 90’s mlkshk. Occupy woke.</p>
                                <p class="reply"><a href="#">Reply</a></p>
                            </li>
                            <li>
                                <p class="name">John Doe <span class="small-text time">a min ago</span></p>
                                <p class="comment">Unicorn franzen you probably haven’t heard of them coloring book. Vape vaporware meh, cardigan trust fund chicharrones fam 90’s mlkshk. Occupy woke mumblecore.</p>
                                <p class="reply"><a href="#">Reply</a></p>
                            </li>
                            <li>
                                <p class="name">John Doe <span class="small-text time">a min ago</span></p>
                                <p class="comment">Unicorn franzen you probably haven’t heard of them coloring book. Vape vaporware meh, cardigan trust.</p>
                                <p class="reply"><a href="#">Reply</a></p>
                            </li>
                            <li>
                                <p class="name">John Doe <span class="small-text time">a min ago</span></p>
                                <p class="comment">Unicorn franzen you probably haven’t heard of them coloring book. Vape vaporware meh, cardigan trust fund chicharrones fam 90’s mlkshk. Occupy woke mumblecore, bushwick everyday carry chartreuse viral hashtag.</p>
                                <p class="reply"><a href="#">Reply</a></p>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
