/**
 * Script que coge el minuto actual del video y lo guarda en una etiqueta para mostrarselo al usuario
 * cuando éste abre el popup para añadir una pregunta
 */
var button = document.getElementById("add-question");
var form = document.getElementById("add-question-form");
var video = document.getElementById("video-element");
var content = document.getElementsByClassName("popup");
var x = document.getElementsByClassName("closePopup");
var input, p;

/**
 * Cuando abre el popup se crea el input con el minuto actual del video y el párrafo que muestra dicho minuto
 * El input está oculto y será el tiempo en segundos que se almacena en la base de datos y con el que se trabajará a nivel de backend
 * La etiqueta p muestra el minuto formateado para información del usuario
 * */
button.addEventListener("click", function() {
    var currentTime = video.currentTime;
    var min =  Math.floor(currentTime / 60);
    var sec = Math.floor(currentTime - min * 60);

    input = document.createElement("input");
    input.value = currentTime;
    input.name = "minute";
    input.type = "hidden";
    input.readOnly = true;

    p = document.createElement("p");
    p.textContent = "At minute: " + min + ":" + sec;

    form.prepend(input);
    form.prepend(p);
});

// Cuando cierre el popup se elimina el input con el minuto del video
x[0].addEventListener("click", function() {
    input.remove();
    p.remove();
});

window.addEventListener("click", function(event) {
    if (event.target == content[0]) {
        input.remove();
        p.remove();
    }
});

