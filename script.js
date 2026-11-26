function openloginmenu()
   {
   var menu = document.getElementById("loginmenuid");
   if(menu.classList.contains("hidden"))
      {
      menu.classList.remove("hidden");
      }
   else
      {
      menu.classList.add("hidden");
      }
   }
function showpassword()
   {
   document.getElementById("passwordid").type = "text";
   }
function hidepassword()
   {
   document.getElementById("passwordid").type = "password";
   }