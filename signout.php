<?php session_start();
    setcookie('user', "", time - 3600);
    unset($_COOKIE['user']);
    header("Location: login.php");				//Redirects to the home page
	exit();
?>
