// Script que almacena la respuesta de un usuario y le muestra el resultado

var answerButtons = document.getElementsByClassName("answer-btn");
var continueButtons = document.getElementsByClassName("continue");
var questionWrappers = document.getElementsByClassName("question-wrapper");
var submitForm = document.getElementById("submit-answers");

for (let i = 0; i < answerButtons.length; i++) {
    answerButtons[i].addEventListener("click", function() {

        // Añadimos al formulario de envío de resultados el id de la respuesta seleccionada
        var input = document.createElement("input");
        input.type = "hidden";
        input.value = document.querySelector('input[name="answer-' + i + '"]:checked').value;
        submitForm.appendChild(input);

        // Mostramos la respuesta correcta al usuario y si ha acertado
        var labels = questionWrappers[i].getElementsByTagName("label");
        for (let j = 0; j < labels.length; j++) {
            // Seleccionamos el input asociado al label
            var answer = document.getElementById(labels[j].htmlFor);
            if( answer.dataset.correct == 1 ) {
                labels[j].style.color = "#57CC99";
            }
            else if( answer.checked && answer.dataset.correct == 0 ) {
                labels[j].style.color = "#CB5763";
            }
        }
        // Eliminamos el botón de responder y mostramos el botón de reanudar vídeo
        answerButtons[i].style.display = "none";
        continueButtons[i].style.display = "block";

    });
}


