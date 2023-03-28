

function openPopup(id) {
    var popup = document.getElementById(id);
    popup.style.display = "block";
}

function closePopup(id) {
    var popup = document.getElementById(id);
    popup.style.display = "none";
}

window.onclick = function(event) {
    if (event.target.matches('.popup')) {
        var popups = document.getElementsByClassName("popup");
        var i;
        for (i = 0; i < popups.length; i++) {
            closePopup(popups[i].id);
        }
    }
}

