//STANZA HIGHLIGHTING//

//initialize timer identification
let timerId = null;
//poemData defined in part-<part#>.php
let stanzaStartTimes = poemData.map( (element) => parseInt(element[1], 10)).filter( (element) => !isNaN(element));
console.log(stanzaStartTimes);
var lastHighlightedStanzaID = -1;

function updateHighlight() {
    let id = stanzaStartTimes[checkCurrentStanza()];
    if ( id != lastHighlightedStanzaID ) {
        lastHighlightedStanzaID = id;
        highlightStanza(id);
    }
}

function checkCurrentStanza() {
    let time = player.currentTime;
    console.log("Time\t" + time);
    let idIndex = stanzaStartTimes.findIndex( (element, index, array) => {
        if ( index+1 >= array.length ) {
            return (time >= element);
        } else {
            return (time >= element && time < array[index+1]);
        }
    });
    console.log("Index\t" + idIndex);
    console.log("ID\t" + stanzaStartTimes[idIndex]);
    console.log("\n");
    return idIndex;
}

function highlightStanza(id) {
    let highlitedClassName = "poem__stanza--highlighted"
    let oldStanzas = document.getElementsByClassName(highlitedClassName);
    if ( oldStanzas.length > 0 ) {
        oldStanzas[0].classList.remove(highlitedClassName);
    }
    let stanza = document.getElementById(id);
    if ( stanza != null ) {
        stanza.classList.add(highlitedClassName);
    }
}



//AUDIO PLAYER//

let player = document.getElementById("player");
let playPauseBtn = document.getElementById("play-pause");
let playPauseIcon = document.getElementById("play-pause-icon");

//audio finished playing
player.onended = () => {
    playPauseIcon.classList.remove("fa-pause");
    playPauseIcon.classList.add("fa-play");
    //stop timer
    if (timerId) {
        clearInterval(timerId);
    }
};

function playPause() {
    if (player.paused) {
        player.play();
        //initial update highlight
        updateHighlight();
        //start timer
        timerId = setInterval(function () { updateHighlight() }, 100);
        //change icon to pause
        playPauseIcon.classList.remove("fa-play");
        playPauseIcon.classList.add("fa-pause");
    } else {
        player.pause();
        //stop timer
        if (timerId) {
            clearInterval(timerId);
        }
        //change icon to play
        playPauseIcon.classList.remove("fa-pause");
        playPauseIcon.classList.add("fa-play");
    }
}

//step forward one stanza
function stepForward() {
    if ( checkCurrentStanza()+1 < stanzaStartTimes.length ) {
        player.currentTime = stanzaStartTimes[checkCurrentStanza()+1];
        updateHighlight();
    }
}

//step backward one stanza
function stepBackward() {
    if ( checkCurrentStanza()-1 >= 0 ) {
        player.currentTime = stanzaStartTimes[checkCurrentStanza()-1];
        updateHighlight();
    }
}


