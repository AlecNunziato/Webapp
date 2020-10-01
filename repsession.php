<?php
include "assets/functions.php";
 if(!empty($_POST)) {
    $tutLastName = unserialize($_COOKIE['user'])['lName'];
    reportSession($_POST['studentID'], $_POST['email'], $_POST['fName'], $_POST['lName'], $_POST['major'], $_POST['courseNumber'], $tutLastName);
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

    <body>
        <form action="repsession.php" method="post" id="repsesh">
            <label for="studentID">Student ID:</label>
            <input type="number" name="studentID" required /><br>
            <label for="email">Email:</label>
            <input type="text" name="email" required /><br>
            <label for="fName">First name:</label>
            <input type="text" name="fName" required /><br>
            <label for="lName">Last name:</label>
            <input type="text" name="lName" required /><br>
            <label for="major">Major:</label>
            <input type="text" name="major" required /><br>
            <label for="courseNumber">Course Number:</label>
            <input type="number" name="courseNumber" required /><br>
            <button type="submit">Submit</button>
        </form>
        <!-- IGNORE THESE -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>