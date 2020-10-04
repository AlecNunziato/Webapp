<?php
include "assets/functions.php";
 if(!empty($_POST)) {
    $data = $_POST;
    if ($data['action'] == 'add') {
        addTutor($data['studentID'], $data['email'], $data['password'], $data['fName'], $data['lName'], $data['major']);
    } elseif ($data['action'] == 'remove') {
        removeTutor($data['email']);
    } else {
        print("<p>Invalid Option</p>");
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

    <body>
        <form action="managetutors.php" method="post" id="manTutors">
            <p>Please select an option:</p>
            <input type="radio" id="add" name="action" value="add" checked>
            <label for="add">Add</label><br>
            <input type="radio" id="remove" name="action" value="remove">
            <label for="remove">Remove</label><br>
            <label for="studentID">Student ID:</label>
            <input type="number" name="studentID" required /><br>
            <label for="email">Email:</label>
            <input type="text" name="email" required /><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required /><br>
            <label for="fName">First name:</label>
            <input type="text" name="fName" required /><br>
            <label for="lName">Last name:</label>
            <input type="text" name="lName" required /><br>
            <label for="major">Major:</label>
            <input type="text" name="major" required /><br>         
            <button type="submit">Submit</button>
        </form>
        <!-- IGNORE THESE -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>