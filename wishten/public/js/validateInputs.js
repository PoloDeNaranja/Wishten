// Script para cambiar de color los iconos cuando los inputs son válidos

// Obtenemos los inputs del formulario
var inputs = document.querySelectorAll("input");

// Añadimos los eventListener a cada input
inputs.forEach(function(input) {
  input.addEventListener("input", function() {
    if (this.validity.valid) {
      // Obtenemos el icono asociado al input
      var icon = document.querySelector("i[id='" + this.id + "-icon']");
      // Añadimos la clase .valid-color al icono para cambiarlo de color
      icon.classList.add("valid-color");
      icon.classList.remove("fa-bounce");
    } else {
      var icon = document.querySelector("i[id='" + this.id + "-icon']");
      icon.classList.remove("valid-color");
    }
  });
});
