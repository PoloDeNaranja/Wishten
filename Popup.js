

//Boton de abrir popup
var abrir = document.getElementById("openPopup");
//Ventana del popup
var content = document.getElementById("PopupWindow");
//Cerar con x 
var x = document.getElementsByClassName("closePopup")[0];

//Abrimos si clica el boton correspondiente
abrir.addEventListener("click",function() {
  content.style.display = "block";
});

//Cerramos si clica x
x.addEventListener("click",function() {
  content.style.display = "none";
});

//Cerramos si clica fuera del popup
window.addEventListener("click",function(event) {
  if (event.target == content) {
    content.style.display = "none";
  }
});