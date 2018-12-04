//STANZA HIGHLIGHTING & MOOD UPDATING//

//initialize timer identification
let timerId = null;
//poemData defined in part-<part#>.php
let stanzaStartTimes = poemData.map( (element) => parseFloat(element[1], 10)).filter( (element) => !isNaN(element));
let stanzaMoods = poemData.map( (element) => element[2]).filter( (element) => (typeof element != 'undefined'));
console.log(stanzaStartTimes);
console.log(stanzaMoods);
var lastHighlightedStanzaID = -1;
var lastMood = "";

function update() {
    let currentIndex = checkCurrentStanza()
    let id = stanzaStartTimes[currentIndex];
    let mood = stanzaMoods[currentIndex];
    if ( mood != lastMood ) {
        updateMood(mood);
        lastMood = mood;
    }
    if ( id != lastHighlightedStanzaID ) {
        updateHighlight(id);
        lastHighlightedStanzaID = id;
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
    console.log("Mood\t" + stanzaMoods[idIndex]);
    console.log("\n");
    return idIndex;
}

function updateMood(mood) {
    updateMoodByClassName("primary-content", mood);
    updateMoodByClassName("poem", mood);
    updateMoodByClassName("poem__stanza--highlighted", mood);
    updateMoodByClassName("next-previous__link", mood);
    updateMoodByClassName("header", mood);
    updateMoodByClassName("nav__link", mood);
    updateMoodByClassName("footer", mood);
    updateMoodByClassName("footer__link", mood);
}

function updateMoodByClassName(className, mood) {
    let elements = document.getElementsByClassName(className);
    Array.prototype.forEach.call(elements, (element) => {
        if ( lastMood != "" ) {
            element.classList.remove(className+"--"+lastMood);
        }
        element.classList.add(className+"--"+mood);
    });
}

function updateHighlight(id) {
    let highlightedClass = "poem__stanza--highlighted"
    let highlightedClassWithMood = highlightedClass+"--"+lastMood;

    let oldStanzas = document.getElementsByClassName(highlightedClass);
    Array.prototype.forEach.call(oldStanzas, (element) => {
        element.classList.remove(highlightedClass);
        element.classList.remove(highlightedClassWithMood);
    });

    let stanza = document.getElementById(id);
    if ( stanza != null ) {
        stanza.classList.add(highlightedClass);
        stanza.classList.add(highlightedClassWithMood);
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
        //clear highlight
        updateHighlight(-1);
    }
};

function playPause() {
    if (player.paused) {
        player.play();
        //initial update highlight
        update();
        //start timer
        timerId = setInterval(function () { update() }, 100);
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
        update();
    } else {
        player.currentTime = player.duration;
        update();
    }
}

//step backward one stanza
function stepBackward() {
    if ( checkCurrentStanza()-1 >= 0 ) {
        player.currentTime = stanzaStartTimes[checkCurrentStanza()-1];
        update();
    } else {
        player.currentTime = 0;
        update();
    }
}


