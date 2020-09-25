<?php
include "assets/functions.php";

$msgs[] = "";
    if(empty($_COOKIE)) {
        if(isset($_POST['email']) && ($_POST['password'])) {
            $data = validateUser($_POST['email']);
            if(!empty($data)) {
                if($_POST['password'] == $data['password']) {
                    setcookie('user', serialize($data), time()+3600);
                } else {
                    $msgs[] = "<p style='text-align:center; color:red'>";
                    $msgs[] = "The Password entered is incorrect.";
                    $msgs[] = "</p>";
                }
            } else {
                $msgs[] = "<p style='text-align:center; color:red'>";
                $msgs[] = "The Email provided is incorrect.";
                $msgs[] = "</p>";
            }
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body style="background: linear-gradient(#701931 9%, rgb(122,45,57) 44%, rgb(157,112,84) 85%, #b6a268);height: 100vh;width: 100%;">
    <?php
        if(!empty($_COOKIE)) {
            $cookie = unserialize($_COOKIE['user']);
            print($cookie['stuID']);
        }
    ?>
    <div class="login-dark">
        <form method="post" style="opacity: 0.95;filter: blur(0px);border-radius: 13px;box-shadow: 0px 14px 19px 7px rgb(0,0,0);" id="loginform" action="login.php">
            <div class="illustration">
                <h1 style="color: #b6a268;font-size: 28px;text-align: center;">Kutztown Tutoring</h1><img src="assets/img/bear_logo.png"></div>
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background: #b6a268;">Log In</button><!--</div><a class="forgot" href="#">Forgot your email or password?</a>-->
            <?php
                if(!empty($msgs)) {
                    foreach($msgs as $msg)
                    {
                        print($msg);
                    }
                }
            ?>
        </form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>