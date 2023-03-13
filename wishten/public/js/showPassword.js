const passwordInput = document.getElementById('password');
const showPasswordButton = document.getElementById('show-password');




showPasswordButton.addEventListener('click', function() {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showPasswordButton.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
        showPasswordButton.style.opacity=0.6;
    } else {
        passwordInput.type = 'password';
        showPasswordButton.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
        showPasswordButton.style.opacity=1;
    }
});


const passwordI = document.getElementById('confirm');
const showP= document.getElementById('show');

showP.addEventListener('click', function() {
    if (passwordI.type === 'password') {
    passwordI.type = 'text';
    showP.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
    showP.style.opacity=0.6;
    } else {
    passwordI.type = 'password';
    showP.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
    showP.style.opacity=1;
    }
});

