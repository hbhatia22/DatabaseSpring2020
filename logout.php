<?php

echo " Thank You! <br><br>Successfully logged out. <br> <br>";
echo '<a href="index.html">Project home page</a>';
setcookie("id",$id,time() - 36000);
setcookie("balance",$balance,time() - 36000);
setcookie("sid",$sid,time() - 36000);
setcookie("name",$name,time() - 36000);
setcookie("userName",$name,time() - 36000);
setcookie("password",$password,time() - 36000);
setcookie("code",$code,time() - 36000);
setcookie("ID",$id,time() - 36000);







?>