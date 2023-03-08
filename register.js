const passwordInput = document.getElementById('password');
const showPasswordButton = document.getElementById('show-password');

showPasswordButton.addEventListener('click', function() {
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    showPasswordButton.textContent = 'b';
    showPasswordButton.style.opacity=0.6;
  } else {
    passwordInput.type = 'password';
    showPasswordButton.textContent = 'a';
    showPasswordButton.style.opacity=1;
  }
});


const passwordI = document.getElementById('confirm');
const showP= document.getElementById('show');

showP.addEventListener('click', function() {
  if (passwordI.type === 'password') {
    passwordI.type = 'text';
    showP.textContent = 'b';
    showP.style.opacity=0.6;
  } else {
    passwordI.type = 'password';
    showP.textContent = 'a';
    showP.style.opacity=1;
   
  }
});

