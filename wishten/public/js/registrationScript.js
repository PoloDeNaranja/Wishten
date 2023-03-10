const passwordInput = document.getElementById('password');
const showPasswordButton = document.getElementById('show-password');




showPasswordButton.addEventListener('click', function() {
    var eye = document.createElement('i');
    eye.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
    var eye_slash = document.createElement('i');
    eye_slash.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showPasswordButton.replaceChildren(eye_slash);
        showPasswordButton.style.opacity=0.6;
    } else {
        passwordInput.type = 'password';
        showPasswordButton.replaceChildren(eye);
        showPasswordButton.style.opacity=1;
    }
});


const passwordI = document.getElementById('confirm');
const showP= document.getElementById('show');

showP.addEventListener('click', function() {
    var eye = document.createElement('i');
    eye.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
    var eye_slash = document.createElement('i');
    eye_slash.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
    if (passwordI.type === 'password') {
    passwordI.type = 'text';
    showP.replaceChildren(eye_slash);
    showP.style.opacity=0.6;
    } else {
    passwordI.type = 'password';
    showP.replaceChildren(eye);
    showP.style.opacity=1;
    }
});

