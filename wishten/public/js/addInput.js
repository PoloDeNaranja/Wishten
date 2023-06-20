// Script para añadir un input al pulsar un botón

var forms = document.getElementsByClassName("add-answer");


for(let i = 0; i < forms.length; i++) {
    // Cogemos el botón dentro del formulario y le añadimos el evento
    var button = forms[i].getElementsByTagName('button')[0];
    button.addEventListener("click", function () {
      var input = document.createElement("textarea");
      var addButton = document.createElement("button");
      addButton.type = "submit";
      addButton.className = "button add";
      addButton.textContent = "Add";
      forms[i].appendChild(input);
      forms[i].appendChild(addButton);
      button.remove();
    });
}
