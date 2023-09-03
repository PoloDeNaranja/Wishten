//La estructura del código se ha basado en los ejemplo que propociona para ventanas modales la página https://www.w3schools.com/
//Boton de abrir popup
var open = document.getElementsByClassName("openPopup");
//Ventana del popup
var content = document.getElementsByClassName("popup");
//Cerar con x
var x = document.getElementsByClassName("closePopup");

for (let i = 0; i < open.length; i++) {
    open[i].addEventListener("click", function() {
        content[i].style.display = "block";
    });

    x[i].addEventListener("click",function() {
        content[i].style.display = "none";
    });

    window.addEventListener("click",function(event) {
        if (event.target == content[i]) {
            content[i].style.display = "none";
        }
    });
}