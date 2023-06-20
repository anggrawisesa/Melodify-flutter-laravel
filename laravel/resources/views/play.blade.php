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
    <!-- <link rel="stylesheet" type="text/css" href="./css/play.css" /> -->
    <link href="{{ asset('css/play.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
    <?php
        $id = request()->route('id');
    ?>
    <div class="main">
        <p id="logo"><i class="fa fa-music" aria-hidden="true"></i>Music</p>

        <div class="left">
            <img id="track_image" alt="gambar" />
            <div class="volume">
                <p id="volume_show">90</p>
                <i class="fa fa-volume-up" aria-hidden="true" id="volume_icon" onclick="mute_sound()"></i>
                <input type="range" min="0" max="100" value="90" onchange="volume_change()" id="volume" />
            </div>
        </div>

        <div class="right">
            <div id="show_song_no" class="show_song_no">
                <p id="present">1</p>
                <p>/</p>
                <p id="total">5</p>
            </div>

            <p id="title">title.mp3</p>
            <p id="artist">Artist name</p>

            <div class="middle">
                <button onclick="previous_song()" id="pre">
                    <i class="fa fa-step-backward" aria-hidden="true"></i>
                </button>
                <button onclick="justplay()" id="play">
                    <i class="fa fa-play" aria-hidden="true"></i>
                </button>
                <button onclick="next_song()" id="next">
                    <i class="fa fa-step-forward" aria-hidden="true"></i>
                </button>
            </div>

            <div class="duration">
                <input type="range" min="0" max="100" value="0" id="duration_slider" onchange="change_duration()" />
            </div>
            <button id="auto" onclick="autoplay_switch()">
                Auto Play
                <i class="fa fa-circle-o-notch" aria-hidden="true"></i>
            </button>
            <button id="shuffle" onclick="shuffle()">
                Acak
                <i class="fa fa-random" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <script src="{{ asset('js/play.js') }}"></script>
</body>

</html>