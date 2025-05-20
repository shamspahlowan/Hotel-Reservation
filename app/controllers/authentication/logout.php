<?php
session_start();
session_destroy();
header("Location: ../../../public/index.html");
setcookie("user_email", "", time() - 3600, "/");
setcookie("user_pass", "", time() - 3600, "/");

?>