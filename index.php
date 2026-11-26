<!DOCTYPE html>
<html lang="pl">
<head>
   <meta charset="UTF-8">
   <link rel="stylesheet" href="style.css">
   <script src="script.js" defer></script>
   <title>EduResource Manager</title>
</head>
<body>
   <div class="main">
      <div class="topbar">
         <h1 class="logo">EduResource Manager</h1>
         <div class="topbarbuttons">
            <button class="topbarbuttonstyle" type="button">Jezyk</button>
            <button class="topbarbuttonstyle" type="button" onclick="openloginmenu()">Zaloguj</button>
         </div>
      </div>
      <div class="body">
         <div class="welcome">
            <h1>System zarzadzania zasobami szkolnymi</h1>
         </div>
      </div>
   </div>
   <div id="loginmenuid" class="loginmenu hidden">
      <div id="close" class="closebutton">
         <button type="button" onclick="openloginmenu()">X</button>
      </div>
      <form class="logininput" action="auth/login_action.php" method="POST">
         <div class="loginmenuinputstyle">
            <label for="emailid">Email lub login:</label><br>
            <input id="emailid" type="text" name="emailinput" required><br>
         </div>
         <div class="loginmenuinputstyle">
            <label for="passwordid">Haslo:</label><br>
            <input id="passwordid" type="password" name="passwordinput" required>
            <svg class="showpasswordeye" height="20" width="40" xmlns="http://www.w3.org/2000/svg" role="img" viewBox="105 110 5 20" onmousedown="showpassword()" onmouseup="hidepassword()">
               <path d="M89 120C88 108 122 108 121 120 122 132 88 132 89 120M92 120C91 128 119 128 118 120 119 112 91 112 92 120M105 126C97 126 97 114 105 114 113 114 113 126 105 126" fill="rgb(82, 93, 139)"></path>
            </svg>
         </div>
         <div class="loginbuttonstyle">
            <button class="topbarbuttonstyle" type="submit">Zaloguj</button>
         </div>
      </form>
   </div>
</body>
</html>
