// Script para mostrar las preguntas dentro de los videos

var questions = document.getElementsByClassName("question-wrapper");
var video = document.getElementById("video-element");
var buttons = document.getElementsByClassName("answer-btn");


/**
 * Añadimos un eventListener al video, de modo que cuando llega al minuto almacenado
 * en el campo data-minute de la pregunta, ésta se muestra, pausando el video
 *  */

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

/**
 * Añadimos otro eventListener a cada botón para responder la pregunta para que
 * esconda dicha pregunta y reanude el video
 */

for (let i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener("click", function() {
        questions[i].style.display = "none";
        video.play();
        video.currentTime = video.currentTime + 1;
    });
}

