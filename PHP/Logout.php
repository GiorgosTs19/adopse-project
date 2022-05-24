<?php
session_start();
session_destroy();
$_SESSION = array();
header("Location: http://localhost/ADOPSE/PHP/Login.php");
?>
