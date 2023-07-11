@extends('layouts.app')

@section('title', 'Profile')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ url('/css/profileStyle2.css') }}">
@endsection

@section('js')
<script async src="{{ url('/js/showPassword.js') }}"></script>
@endsection

@section('header')
@endsection



@section('content')
    <body>
        <div class ="primero"><!-- Cuadro donde va la imagen -->
            <img class ="circle" src="ProfileImage.jpg" alt="ProfileImage"/>
           
           
           
            <h1 class = "name">Username<h1>
            <button id="openPopup">Edit Profile</button>  
        </div>
        <ul class ="list"><!-- Lista donde se meten los numeros de subs seguidos y likes -->
           
           
         
            <li><!-- en el numero meter variable de followers following y likes -->
                <a href= "followers.php">2222</a>
                <p>Followers</p>
            </li>
            <li>
                <a href= "following.php">2222</a>
               <p>Following</p>
            </li> 
            <li>
            
            <h2>2222</h2>
            <p>Likes</p>
          
            </li>
           <li><!-- en el numero meter variable de followers following y likes -->
                <i class="fa-solid fa-heart"></i>
            </li>
               
        </ul>
        
          
           
           
   
</form>
           
        </div>   
       <div class="videos">
          <h1>Uploaded Videos</h1>
          
          @section('My Videos')
       </div>   
       <div id="PopupWindow" class="popup">
        <div class="popupContent">
            <span class="closePopup">&times;</span>
            
            <form action="" method="POST">
               
               
               
               <h1 class="titulo">Change picture</h1>
            <label>
                
           
             <i class="fa-solid fa-pen-to-square"></i>
            <input placeholder="image route" type="text">
              </label>
               
               
               <h1 class="titulo">Change username</h1>
            <label>
                
           
              <i class="fa-solid fa-image"></i>
            <input placeholder="username" type="text">
              </label> 
               
               
            <h1 class="titulo">Change E-mail</h1>
            <label>
                
           
              <i class="fa-solid fa-envelope"></i>
            <input placeholder="e-mail" type="text">
              </label>  
               
               
               
               
               
               
               <h1 class="titulo">Change your password</h1>
            <label>
                <i class="fa-solid fa-lock"></i>
                <input type="password" placeholder="Password"  name= "password" id="password" required>
            
                <img src=""alt="" class="icon">
            </label>
            <label>
                <i class="fa-solid fa-lock"></i>
                <input placeholder="Confirm password" type="password" name="password" id="confirm" required>
            
            </label>
            <button class="button res">Confirm changes</button>
        
    </form> 
        </div>
    </div>
       
    <script src="https://kit.fontawesome.com/0d34bde1b9.js" crossorigin="anonymous"></script>
    </body>


@endsection


@section('footer')
@endsection