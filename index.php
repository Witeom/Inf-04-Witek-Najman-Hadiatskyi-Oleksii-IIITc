<!DOCTYPE html>
<html lang="pl">
<head>
   <meta charset="UTF-8">
   <link rel="stylesheet" href="style.css">
   <link rel="script" href="script.js">
   <title>Strona</title>
</head>
<body>
   <div class="main">
      <div class="topbar">
         <h1 class="logo"> EduResource Manager </h1>
         <div class="topbarbuttons">
            <button class="topbarbuttonstyle"> Język </button>
            <button class="topbarbuttonstyle" onclick="openloginmenu()"> Zaloguj </button>
         </div>
      </div>
      <div class="body">
         <div class="welcome"> 
            <h1> Siemka! </h1> 
         </div>
      </div>
   </div>
   <div id="loginmenuid" class="loginmenu hidden">
      <div id="close" class="closebutton"> <button onclick="openloginmenu()"> X </button> </div>
      <div class="logininput">
         <div class="loginmenuinputstyle">
            <label for="emailid"> Email: </label> <br>
            <input id="emailid" type="email" name="emailinput"> <br>
         </div>
         <div class="loginmenuinputstyle">
            <label for="passwordid"> Hasło: </label> <br>
            <input id="passwordid" type="password" name="passowrdinput">
            <svg class="showpasswordeye" height="20" width="40" xmlns="http://www.w3.org/2000/svg" role="img" viewBox="105 110 5 20" onmousedown="showpassword()" onmouseup="hidepassword()">
               <path d="M89 120C88 108 122 108 121 120 122 132 88 132 89 120M92 120C91 128 119 128 118 120 119 112 91 112 92 120M105 126C97 126 97 114 105 114 113 114 113 126 105 126" fill="rgb(82, 93, 139)"> </path>
            </svg>
         </div>
         <div class="loginbuttonstyle">
            <button class="topbarbuttonstyle"> Zaloguj </button>
         </div>
         <div class="otherloginstuff">
            <p> Nie pamiętam emaila. </p>
            <p> Nie pamiętam hasła. </p>
         </div>
      </div>
   </div>
</body>
</html>