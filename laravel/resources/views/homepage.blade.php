<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Melodify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="./css/style.css" /> -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    @section('content')
    <div class="sidebar p-1">
        <div class="logo">
            <a href="#">
                <img src="./img/logo.png" alt="logo" />
            </a>
        </div>

        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="fa fa-home"></span>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="fa fa-upload"></span>
                        <span id="btn-upload-lagu">Upload Lagu</span>
                    </a>
                    <div id="popup-upload-lagu" class="popup">
                        <div class="popup-content">
                            <h2>Upload Lagu</h2>
                            <form action="{{ route('lagu.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="judul">Judul Lagu:</label>
                                    <input type="text" name="judul" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="penyanyi">Penyanyi:</label>
                                    <input type="text" name="penyanyi" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="album">Album:</label>
                                    <input type="text" name="album" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="cover">Cover:</label>
                                    <input type="file" name="cover" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="file">File Lagu:</label>
                                    <input type="file" name="file" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                            <button id="btn-close-popup" class="btn btn-secondary">Batal</button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="navigation">
            <ul>
                <li>
                    <a href="{{ route('playlist.create') }}">
                        <span class="fa fas fa-plus-square"></span>
                        <span>Create Playlist</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="fa fas fa-heart"></span>
                        <span>Liked Songs</span>
                    </a>
                </li>
                <li>

                    <?php
                        $user = Auth::user();
                        $playlists = DB::table('playlists')
                        ->where('user_id', $user->id)
                        ->get();
                     ?>
                    <span>Playlist</span>
                    @if (!is_null($playlists) && count($playlists) > 0)
                    <ul class="list-group mt-3">
                        @foreach ($playlists as $playlist)
                        <li class="list-group-item"><a href="#">{{ $playlist->name }}</a></li>
                        @endforeach
                    </ul>
                    @else
                    <p>Anda belum memiliki playlist.</p>
                    @endif
                </li>
            </ul>
        </div>

    </div>

    <div class="main-container">
        <div class="topbar">
            <div class="search-box">
                <div class="search-icon">
                    <i class="fa fa-search"></i>
                </div>
                <div class="search-input">
                    <form action="/search" method="GET">
                        <input type="search" name="search_query" class="input" placeholder="ingin mendengarkan apa?">
                    </form>
                </div>
            </div>


            <div class="navbar">
                @guest
                @if (Route::has('register'))
                <ul>
                    <li>
                        <a href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                </ul>
                @endif

                @if (Route::has('login'))
                <button type="button"><a href="{{ route('login') }}">{{ __('Login') }}</a></button>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </div>
        </div>

        <div class="melodify-playlist">
            <h2>Lagu</h2>
            <div class="list">
                <div class="items-container">
                    @if(isset($results))
                    @foreach($results as $l)
                    <div class="item">
                        <a href="/play/{{ $l->id }}">
                            <img src="{{ asset('storage/cover/'.$l->cover) }}" />
                            <div class="play">
                                <span class="fa fa-play"></span>
                            </div>
                            <h4>{{ $l->judul }}</h4>
                            <p>{{ $l->penyanyi }}</p>
                        </a>
                    </div>
                    @endforeach
                    @else
                    @foreach(\App\Models\Lagu::all() as $l)
                    <div class="item">
                        <a href="/play/{{ $l->id }}">
                            <img src="{{ asset('storage/cover/'.$l->cover) }}" />
                            <div class="play">
                                <span class="fa fa-play"></span>
                            </div>
                            <h4>{{ $l->judul }}</h4>
                            <p>{{ $l->penyanyi }}</p>
                        </a>
                    </div>
                    @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
    src = "https://kit.fontawesome.com/23cecef777.js";
    crossorigin = "anonymous";
    </script>
    <script src="{{ asset('js/upload-lagu.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>