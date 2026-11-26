function openloginmenu()
   {
   if(document.getElementById("loginmenuid").classList.contains("hidden"))
      {
      loginmenuid.classList.remove("hidden");
      }
   else
      {
      loginmenuid.classList.add("hidden");
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