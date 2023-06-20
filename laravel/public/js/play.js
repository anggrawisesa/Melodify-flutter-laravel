let previous = document.querySelector("#pre");
let play = document.querySelector("#play");
let next = document.querySelector("#next");
let title = document.querySelector("#title");
let recent_volume = document.querySelector("#volume");
let volume_show = document.querySelector("#volume_show");
let slider = document.querySelector("#duration_slider");
let show_duration = document.querySelector("#show_duration");
let track_image = document.querySelector("#track_image");
let auto_play = document.querySelector("#auto");
let present = document.querySelector("#present");
let total = document.querySelector("#total");
let artist = document.querySelector("#artist");

let timer;
let autoplay = 0;

let index_no = 0;
let playing_song = false;

let track = document.createElement("audio");

// Ambil parameter id dari URL
const id = window.location.href.split("/").pop();
let All_song = [];

// Lakukan request ke API untuk mendapatkan data lagu berdasarkan id
fetch(`http://127.0.0.1:8000/songs/${id}`)
    .then((response) => response.json())
    .then((data) => {
        // Buat object lagu yang telah diperoleh dari API
        const song = {
            name: data.judul,
            singer: data.penyanyi,
            src: `http://127.0.0.1:8000/songs/${id}/file`,
            cover: `http://127.0.0.1:8000/songs/${id}/cover`,
        };

        // Masukkan lagu tersebut ke dalam array All_song
        All_song.push(song);

        // Jalankan fungsi load_track untuk memuat lagu pertama
        load_track(index_no);
        justplay();
    });

// Lakukan request ke API untuk mendapatkan semua lagu
fetch(`http://127.0.0.1:8000/songs`)
    .then((response) => response.json())
    .then((data) => {
        // Ambil semua lagu dari database kecuali yang sudah dimasukkan ke dalam playlist
        const songs = data.filter((song) => song.id !== id);

        // Masukkan semua lagu ke dalam playlist
        songs.forEach((song) => {
            const track = {
                name: song.judul,
                singer: song.penyanyi,
                src: `http://127.0.0.1:8000/songs/${song.id}/file`,
                cover: `http://127.0.0.1:8000/songs/${song.id}/cover`,
            };
            if (
                !All_song.some((existingSong) => existingSong.src === track.src)
            ) {
                All_song.push(track);
            }
        });

        total.innerHTML = All_song.length;
    });

let shuffle_mode = false;
function load_track(index_no) {
    clearInterval(timer);
    reset_slider();
    track.src = All_song[index_no].src;
    title.innerHTML = All_song[index_no].name;
    track_image.src = All_song[index_no].cover;
    artist.innerHTML = All_song[index_no].singer;
    track.load();
    if (shuffle_mode) {
        shuffle();
    }

    total.innerHTML = All_song.length;
    present.innerHTML = index_no + 1;
    timer = setInterval(range_slider, 1000);
}
load_track(index_no);

function shuffle() {
    const shuffleButton = document.querySelector("#shuffle");
    shuffleButton.classList.toggle("active");
    let currentIndex = All_song.length,
        randomIndex;

    // While there remain elements to shuffle...
    while (currentIndex != 0) {
        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;

        // And swap it with the current element.
        [All_song[currentIndex], All_song[randomIndex]] = [
            All_song[randomIndex],
            All_song[currentIndex],
        ];
    }
}

function mute_sound() {
    track.volume = 0;
    volume.value = 0;
    volume_show.innerHTML = 0;
}

function reset_slider() {
    slider.value = 0;
}

function justplay() {
    if (playing_song == false) {
        playsong();
    } else {
        pausesong();
    }
}

function playsong() {
    track.play();
    playing_song = true;
    play.innerHTML = '<i class="fa fa-pause" aria-hidden="true"></i>';
}

function pausesong() {
    track.pause();
    playing_song = false;
    play.innerHTML = '<i class="fa fa-play" aria-hidden="true"></i>';
}

function next_song() {
    if (index_no < All_song.length - 1) {
        index_no += 1;
        load_track(index_no);
        playsong();
    } else {
        index_no = 0;
        load_track(index_no);
        playsong();
    }
}

function previous_song() {
    if (index_no > 0) {
        index_no -= 1;
        load_track(index_no);
        playsong();
    } else {
        index_no = All_song.length;
        load_track(index_no);
        playsong();
    }
}

function volume_change() {
    volume_show.innerHTML = recent_volume.value;
    track.volume = recent_volume.value / 100;
}

function change_duration() {
    slider_position = track.duration * (slider.value / 100);
    track.currentTime = slider_position;
}

function autoplay_switch() {
    if (autoplay == 1) {
        autoplay = 0;
        auto_play.style.background = "rgba(255,255,255,0.2)";
    } else {
        autoplay = 1;
        auto_play.style.background = "#FF8A65";
    }
}

function range_slider() {
    let position = 0;
    if (!isNaN(track.duration)) {
        position = track.currentTime * (100 / track.duration);
        slider.value = position;
    }

    if (track.ended) {
        play.innerHTML = '<i class="fa fa-play"></i>';
        if (autoplay == 1) {
            index_no += 1;
            load_track(index_no);
            playsong();
        }
    }
}
