



<!DOCTYPE html>
<html lang = "es">
<head>    
    <meta charset="UTF-8">
    <tittle>Register</tittle>
    <!--Esto es para moviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href="estiloRegister.css">
   <script src="register.js" crossorigin="anonymous"></script>
      
</head>
<body>
    <form action="">
        <h1 class="titulo">Create your account!</h1>
        <label>
           <i class="fa-solid fa-user"></i>
            <input placeholder="Enter your username" type="text" name="name" required>
        </label>
        <label>
           <i class="fa-solid fa-envelope"></i>
            <input placeholder="Enter your e-mail" type="text" name="email" required>
        </label>
        <label>
            <i class="fa-solid fa-lock"></i>
            <input type="password" placeholder="Enter your password"  name= "password" id="password" required>
           <button type="button" style="margin-left: 10px" id="show-password">a</button>
            <img src=""alt="" class="icon">
        </label>
        <label>
            <i class="fa-solid fa-lock"></i>
            <input placeholder="Confirm password" type="password" name="password" id="confirm" required>
           <button type="button" style="margin-left: 13px" id="show">a</button>
        </label>

        <a href="" class="tiene">Already have an account?</a>
        
        <button class="button reg">Register</button>
        <button class="button log">Login</button>
        
    </form>        
<script src="https://kit.fontawesome.com/0d34bde1b9.js" crossorigin="anonymous"></script>
</body> 
</html>