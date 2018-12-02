let player = document.getElementById("player");
let playPauseBtn = document.getElementById("play-pause");
let playPauseIcon = document.getElementById("play-pause-icon");

function playPause() {
    if (playPauseIcon.classList.contains("fa-play")) {
        player.play();
        playPauseIcon.classList.remove("fa-play");
        playPauseIcon.classList.add("fa-pause");
    } else {
        player.pause();
        playPauseIcon.classList.remove("fa-pause");
        playPauseIcon.classList.add("fa-play");
    }
}

function stepForward() {
    console.log(player.currentTime);
    let time = player.currentTime;
    player.currentTime = time + 5;
    console.log(player.currentTime);
}

function stepBackward() {
    console.log(player.currentTime);
    let time = player.currentTime;
    player.currentTime = time - 5;
    console.log(player.currentTime);
}