var questions = document.getElementsByClassName("question-container");
var video = document.getElementById("video");

for (let i = 0; i < questions.length; i++) {
  video.addEventListener("timeupdate", function () {
    var currentTime = video.currentTime;
    var min = parseInt(questions[i].dataset.minute);
    var max = min + 1;
    if (currentTime > min && currentTime < max) {
      questions[i].style.display = "block";
      video.pause();
    } else {
      questions[i].style.display = "none";
    }
  });
}
