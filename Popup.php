<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel = "stylesheet" href="estiloPopup.css">
<script src="Popup.js" crossorigin="anonymous"></script>
<script src="register.js" crossorigin="anonymous"></script>
</head>
<body>

    <button id="openPopup">Change Password</button>
    <div id="PopupWindow" class="popup">
        <div class="popupContent">
            <span class="closePopup">&times;</span>
            
            <form action="">
            <h1 class="titulo">Reset your password</h1>
            <label>
                <i class="fa-solid fa-lock"></i>
                <input type="password" placeholder="Enter your new password"  name= "password" id="password" required>
            <button type="button" style="margin-left: 10px" id="show-password">a</button>
                <img src=""alt="" class="icon">
            </label>
            <label>
                <i class="fa-solid fa-lock"></i>
                <input placeholder="Confirm password" type="password" name="password" id="confirm" required>
            <button type="button" style="margin-left: 10px" id="show">a</button>
            </label>
            <button class="button res">Reset password</button>
        
    </form> 
        </div>
    </div>
    <script src="https://kit.fontawesome.com/0d34bde1b9.js" crossorigin="anonymous"></script>
</body>
</html>