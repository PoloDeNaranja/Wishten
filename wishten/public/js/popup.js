
//Boton de abrir popup
var abrir = document.getElementsByClassName("openPopup");
//Ventana del popup
var content = document.getElementsByClassName("popup");
//Cerar con x
var x = document.getElementsByClassName("closePopup");

for (let i = 0; i < abrir.length; i++) {
    abrir[i].addEventListener("click", function() {
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


