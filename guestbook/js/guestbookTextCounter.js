let userInputMessage    = document.getElementById('userComment');
let counter             = document.getElementById('counter');
let counterProgressBar  = document.getElementById('counterProgressBar');

const byteSize = str => new Blob([str]).size;

userInputMessage.addEventListener('input', function(e){

    let userMessageLength = byteSize(e.target.value);

    const counterMessage   = userMessageLength.toLocaleString('ko-KR') + " Bytes / 1,000 Bytes";
    const progressBarWidth = ((userMessageLength) / 1000) * 100;

    counter.innerHTML = counterMessage;
    counterProgressBar.style.width = progressBarWidth + "%";

    if(progressBarWidth < 75) {
        counterProgressBar.className = "progress-bar progress-bar-striped";
    } else if(progressBarWidth >= 75 && progressBarWidth < 100) {
        counterProgressBar.className = "progress-bar progress-bar-striped bg-warning";
    } else if (progressBarWidth >= 100) {
        counterProgressBar.className = "progress-bar progress-bar-striped bg-danger";
    }

});