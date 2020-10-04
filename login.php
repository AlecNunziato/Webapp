<?php
include "assets/functions.php";

$msgs[] = "";
    if(!empty($_COOKIE['user'])) {
        header("Location: index");
        exit();
    }
    if(isset($_POST['email']) && ($_POST['password'])) {
        $data = validateUser($_POST['email']);
        if(!empty($data)) {
            if($_POST['password'] == $data['password']) {
                setcookie('user', serialize($data), time() + 3600);
                header("Location: index");
                exit();
            } else {
                $msgs[] = "<p id='msg error' style='text-align:center; color:red; margin-top:15px;'>";
                $msgs[] = "The Password entered is incorrect.";
                $msgs[] = "</p>";
            }
        } else {
            $msgs[] = "<p id='msg error' style='text-align:center; color:red; margin-top:15px;'>";
            $msgs[] = "The Email provided is incorrect.";
            $msgs[] = "</p>";
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - KUTutoring</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center" data-aos="fade-up" data-aos-duration="900" data-aos-delay="250" data-aos-once="true">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;assets/img/home/student-group.png&quot;);"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5" style="height: 70vh;"><img id="bear-logo" src="assets/img/home/bear-logo.png">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Welcome Back!</h4>
                                    </div>
                                    <?php
                                        if (!empty($msgs)) {
                                            foreach($msgs as $msg){	
                                                print($msg);
                                            }
                                        }
                                    ?>
                                    <form class="user" method="post" id="loginform" action="login">
                                        <div class="form-group"><input class="form-control form-control-user" type="email" id="email" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email"></div>
                                        <div class="form-group"><input class="form-control form-control-user" type="password" id="password" placeholder="Password" name="password"></div>
                                        <div class="form-group">
                                            <!-- <div class="custom-control custom-checkbox small">
                                                <div class="form-check"><input class="form-check-input custom-control-input" type="checkbox" id="formCheck-1"><label class="form-check-label custom-control-label" for="formCheck-1">Remember Me</label></div>
                                            </div> -->
                                        </div><button class="btn btn-primary btn-block text-white btn-user" type="submit">Login</button>
                                        <hr>
                                    </form>
                                    <div class="text-center"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>