var timeInSecs;
var ticker;

function startTimer(secs) {
    timeInSecs = parseInt(secs) - 1;
    ticker = setInterval("tick()", 1000);
}

function tick() {
    var secs = timeInSecs;
    if (secs > 0) {
        timeInSecs--;
    } else {
        clearInterval(ticker);
    }

    document.getElementById("countdown").innerHTML = secs;
}