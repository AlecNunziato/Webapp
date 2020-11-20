<?php
// DATABASE INFO -- START
$dbName = 'kututoring';
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'kututoring';
// DATABASE INFO -- END

/* Function Name: getDB
* Description: Retrive the Database PDO
* Parameters: None
* Return Value: user information
*/
function getDB() {
    $dsn = 'mysql:dbname=' . $GLOBALS['dbName'] . ';host=' . $GLOBALS['dbHost'];
    return new PDO($dsn, $GLOBALS['dbUser'], $GLOBALS['dbPass']);
}
/* Function Name: validateUser
* Description: Check user login to validate that they are a user
* Parameters: email, password
* Return Value: user information
*/
function validateUser($email) {
    try {
        $db = getDB();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM `users` WHERE email='$email'";
        $stmt = $db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        //print('<p>'.$e.'</p>');
        return array();
    }
}

/* Function Name: getStudentHistory
* Description: Get Student history based on data provided
* Parameters: None
* Return Value: Array of student history
*/
function getStudentHistory() {
    try {
        $db = getDB();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM `sessions`";
        $stmt = $db->query($sql);
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        //print('<p>'.$e.'</p>');
        return array();
    }
}

/* Function Name: isLoggedIn
* Description: Checks if the user is logged in
* Parameters: None
* Return Value: True if the user is logged in, False if the user is logged out
*/
function isLoggedIn() {
    if(!empty($_COOKIE['user'])) {
        return true;
    } else {
        return false;
    }
}

/* Function Name: getUserPerms
* Description: Get users permissions
* Parameters: None
* Return Value: User Permission Level
*/
function getUserPerms() {
    if(!empty($_COOKIE['user'])) {
        $permLevel = unserialize($_COOKIE['user'])['permissions'];
        return $permLevel;
    } else {
        return 0;
    }
}

/* Function Name: reportSession
* Description: Report Session given by tutor to a student
* Parameters: stuID, email, fName, lName, major, course
* Return Value: user information
*/
function reportSession($stuID, $email, $fName, $lName, $major, $course, $notes, $tutLName) {
    try {
        $db = getDB();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `sessions` (`stuID`, `email`, `fName`, `lName`, `major`, `course`, `notes`, `tutorLname`) VALUES ('$stuID', '$email', '$fName', '$lName', '$major', '$course', '$notes', '$tutLName')";
        $stmt = $db->query($sql)->rowCount();
        return $stmt;
    } catch (Exception $e) {
        //print('<p>'.$e.'</p>');
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
        $db = getDB();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `users` (`stuID`, `email`, `password`, `fName`, `lName`, `major`) VALUES ('$stuID', '$email', '$passwd', '$fName', '$lName', '$major')";
        $stmt = $db->query($sql)->rowCount();
        return $stmt;
    } catch (Exception $e) {
        //print('<p>'.$e.'</p>');
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
        $db = getDB();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM `users` WHERE `email` = '$email'";
        $stmt = $db->query($sql)->rowCount();
        return $stmt;
    } catch (Exception $e) {
        //print('<p>'.$e.'</p>');
        return array();
    }
}

/* Function Name: getTutors
* Description: Gets a list of active tutors
* Parameters: None
* Return Value: An array of current tutors
*/
function getTutors() {
    try {
        $db = getDB();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM `users`";
        $stmt = $db->query($sql);
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        //print('<p>'.$e.'</p>');
        return array();
    }
}

/* Function Name: getTutorHours
* Description: Gets Tutor Hours by Week or Month
* Parameters: dates
* Return Value: An array of tutor Hours
*/
function getTutorHours($dates) {
    try {
        $startdate = $dates['start'];
        $enddate = $dates['end'];
        $db = getDB();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM `swipes` WHERE `swipein` > '$startdate' AND `swipein` < '$enddate'";
        $stmt = $db->query($sql);
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        //print('<p>'.$e.'</p>');
        return array();
    }
}

/* Function Name: calculateHours
* Description: Gets Hours between 2 given times
* Parameters: start, end
* Return Value: Hours
*/
function calculateHours($timeIn, $timeOut) {
    $date1 = new DateTime($timeIn);
    $date2 = new DateTime($timeOut);
    return $date2->diff($date1)->format('%S');
}

/* Function Name: getTutors
* Description: Gets a list of active tutors
* Parameters: None
* Return Value: An array of current tutors
*/
function getCourses() {
    try {
        $db = getDB();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM `courses`";
        $stmt = $db->query($sql);
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        //print('<p>'.$e.'</p>');
        return array();
    }
}

/* Function Name: removeCourse
* Description: Removes Course(s) based on user input 
* Parameters: coursePrefix, courseNumber, courseSection
* Return Value: Rows Deleted
*/
function removeCourse($coursePrefix, $courseNumber, $courseSection) {
    try {
        $db = getDB();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM `courses` WHERE `coursePrefix` = '$coursePrefix' AND `courseNumber` = '$courseNumber' AND `courseSection` = '$courseSection'";
        $stmt = $db->query($sql)->rowCount();
        return $stmt;
    } catch (Exception $e) {
        //print('<p>'.$e.'</p>');
        return false;
    }
}

/* Function Name: addCourse
* Description: Adds Course(s) based on user input 
* Parameters: coursePrefix, courseNumber, courseSection, courseName, proctor, courseTime
* Return Value: Rows Added
*/
function addCourse($coursePrefix, $courseNumber, $courseSection, $courseName, $proctor, $courseTime) {
    try {
        $db = getDB();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `courses` (`coursePrefix`, `courseNumber`, `courseSection`, `courseName`, `proctor`, `courseTime`) VALUES ('$coursePrefix', '$courseNumber', '$courseSection', '$courseName', '$proctor', '$courseTime')";
        $stmt = $db->query($sql)->rowCount();
        return $stmt;
    } catch (Exception $e) {
        //print('<p>'.$e.'</p>');
        return false;
    }
}

/* Function Name: getStartAndEndDate
* Description: Get Start & End date of week
* Parameters: type, date
* Return Value: Start & End of Week
*/
function getStartAndEndDate($type, $ddate) {
    if ($type == "week") {
        $date = new DateTime($ddate);
        $week = $date->format("W");
        $year = $date->format("Y");
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        $ret['start'] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret['end'] = $dto->format('Y-m-d');
    } elseif ($type == "month") {
        $ret['start'] = date('Y-m-01', strtotime($ddate));
        $ret['end'] = date('Y-m-t', strtotime($ddate));
    }
    return $ret;
}

/* HASH EXAMPLE
    $pass = strtoupper(hash('whirlpool', $_POST['password']));
    $pass = sprintf("%s%d%s$%s$", $data['SALT'], 24713018, $pass, "2y");
    $pass = strtoupper(hash('whirlpool', $pass));
*/
?>