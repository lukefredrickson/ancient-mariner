//Luke Fredrickson
//12/07/2018

//initialize timer identification
let timerId = null;
//poemData defined in part-<part#>.php
//map JSON of CSV to array of stanza start times and array of stanza moods
//filter out bad lines
let stanzaStartTimes = poemData.map( (element) => parseFloat(element[1], 10)).filter( (element) => !isNaN(element));
let stanzaMoods = poemData.map( (element) => element[2]).filter( (element) => (typeof element != 'undefined'));

//print arrays to console
console.log(stanzaStartTimes);
console.log(stanzaMoods);

//set vars to check against for previous mood and stanza
var lastHighlightedStanzaID = -1;
var lastMood = "";
//the class names to add moods for
var moodClasses = ["poem__stanza--highlighted", "primary-content", "header",
                        "footer", "next-previous__link", "nav__link", "nav__link--active", "footer__link"];

//STANZA HIGHLIGHTING & MOOD UPDATING//

//called every time the timer updates
function update() {
    //get the current stanza's index
    let currentIndex = checkCurrentStanza()
    //get the current id of the stanza to highlight (the start time)
    let id = stanzaStartTimes[currentIndex];
    //get the current mood
    let mood = stanzaMoods[currentIndex];
    //update the mood if it's new
    if ( mood != lastMood ) {
        updateMood(mood);
        lastMood = mood;
    }
    //update the highlighted stanza if it's new
    if ( id != lastHighlightedStanzaID ) {
        updateHighlight(id);
        lastHighlightedStanzaID = id;
    }
}

//returns the index of the currently playing stanza based on audio player current time
function checkCurrentStanza() {
    let time = player.currentTime;
    let idIndex = stanzaStartTimes.findIndex( (startTime, index, array) => {
        if ( index+1 >= array.length ) { //if there isn't a next stanza
            return (time >= startTime); //grab index of last element
        } else { //grab index of element between current start time and next start time
            return (time >= startTime && time < array[index+1]);
        }
    });
    //print info to console
    console.log("Time\t" + time);
    console.log("Index\t" + idIndex);
    console.log("ID\t" + stanzaStartTimes[idIndex]);
    console.log("Mood\t" + stanzaMoods[idIndex]);
    console.log("\n");
    //return the index for the currently playing stanza
    return idIndex;
}

//updates all classes of a given class name with unspecified callback function
function updateByClassName(className, callback) {
    let elements = document.getElementsByClassName(className);
    Array.prototype.forEach.call(elements, (element) => {
        callback(element);
    });
}

//updates the mood of every class in the mood array
function updateMood(mood) {
    moodClasses.forEach(className => {
        updateByClassName(className, (element) => {
            if ( lastMood != "" ) {
                element.classList.remove(className+"--"+lastMood);
            }
            element.classList.add(className+"--"+mood);
        });
    });
}

//clears the page of all mood classes
function clearMood() {
    moodClasses.forEach(className => {
        updateByClassName(className, (element) => {
            if ( lastMood == "" ) {
                element.classList.remove(className+"--");
            } else {
                element.classList.remove(className+"--"+lastMood);
            }
        });
    });
}

//updates which stanza is currently highlighted via element ID
//  (which is the same as the stanza's start time)
function updateHighlight(id) {
    let highlightedClass = "poem__stanza--highlighted"
    let highlightedClassWithMood = highlightedClass+"--"+lastMood;

    //remove all previously highlighted classes with and without mood
    updateByClassName(highlightedClass, (element) => {
        element.classList.remove(highlightedClass);
        element.classList.remove(highlightedClassWithMood);
    });

    //add highlighted class with and without mood to stanza
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
    //change icon to play
    playPauseIcon.classList.remove("fa-pause");
    playPauseIcon.classList.add("fa-play");
    if (timerId) {
        //stop timer
        clearInterval(timerId);
    }
    //clear highlight
    updateHighlight(-1);
    //clear mood
    clearMood();
};

function playPause() {
    if (player.paused) {
        //play audio
        player.play();
        //update highlight and mood
        update();
        //start timer (update every 1/10 second)
        timerId = setInterval(function () { update() }, 100);
        //change icon to pause
        playPauseIcon.classList.remove("fa-play");
        playPauseIcon.classList.add("fa-pause");
    } else {
        //pause audio
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
    //if there isn't a next stanza, go to the end
    if ( checkCurrentStanza()+1 < stanzaStartTimes.length ) {
        player.currentTime = stanzaStartTimes[checkCurrentStanza()+1];
    } else {
        player.currentTime = player.duration;
    }
    //update highlight and mood
    update();
}

//step backward one stanza
function stepBackward() {
    //if there isn't a previous stanza, go to the start
    if ( checkCurrentStanza()-1 >= 0 ) {
        player.currentTime = stanzaStartTimes[checkCurrentStanza()-1];
    } else {
        player.currentTime = 0;
    }
    //update highlight and mood
    update();
}


