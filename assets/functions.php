<?php
/* Function Name: validateUser
* Description: Check user login to validate that they are a user
* Parameters: email, password
* Return Value: user information
*/
function validateUser($email) {
    try {
        $dsn = 'mysql:dbname=kututoring;host=localhost';
        $user = 'root';
        $pass = 'kututoring';
        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM `users` WHERE email='$email'";
        $stmt = $db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        print('<p>'.$e.'</p>');
        return array();
    }
}

function isLoggedIn() {
    if(!empty($_COOKIE['user'])) {
        return true;
    } else {
        return false;
    }
}

/* Function Name: reportSession
* Description: Report Session given by tutor to a student
* Parameters: stuID, email, fName, lName, major, course
* Return Value: user information
*/
function reportSession($stuID, $email, $fName, $lName, $major, $courseNum, $notes, $tutLName) {
    try {
        $dsn = 'mysql:dbname=kututoring;host=localhost';
        $user = 'root';
        $pass = 'kututoring';
        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `sessions` (`stuID`, `email`, `fName`, `lName`, `major`, `courseNumber`, `notes`, `tutorLname`) VALUES ('$stuID', '$email', '$fName', '$lName', '$major', '$courseNum', '$notes', '$tutLName')";
        $stmt = $db->query($sql);
    } catch (Exception $e) {
        print('<p>'.$e.'</p>');
        return array();
    }
}

/* Function Name: addTutor
* Description: Adds Tutor(s) based on user input 
* Parameters: stuID, email, password, fName, lName, major
* Return Value: user information
*/
function addTutor($stuID, $email, $passwd, $fName, $lName, $major) {
    try {
        $dsn = 'mysql:dbname=kututoring;host=localhost';
        $user = 'root';
        $pass = 'kututoring';
        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `users` (`stuID`, `email`, `password`, `fName`, `lName`, `major`) VALUES ('$stuID', '$email', '$passwd', '$fName', '$lName', '$major')";
        $stmt = $db->query($sql);
    } catch (Exception $e) {
        print('<p>'.$e.'</p>');
        return array();
    }
}

/* Function Name: removeTutor
* Description: Removes Tutor(s) specified by the user based on email
* Parameters: email
* Return Value: user information
*/
function removeTutor($email) {
    try {
        $dsn = 'mysql:dbname=kututoring;host=localhost';
        $user = 'root';
        $pass = 'kututoring';
        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM `users` WHERE `email` = '$email'";
        $stmt = $db->query($sql);
    } catch (Exception $e) {
        print('<p>'.$e.'</p>');
        return array();
    }
}

/* HASH EXAMPLE
    $pass = strtoupper(hash('whirlpool', $_POST['password']));
    $pass = sprintf("%s%d%s$%s$", $data['SALT'], 24713018, $pass, "2y");
    $pass = strtoupper(hash('whirlpool', $pass));
*/
?>