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
        $pass = '';
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

/* HASH EXAMPLE
    $pass = strtoupper(hash('whirlpool', $_POST['password']));
    $pass = sprintf("%s%d%s$%s$", $data['SALT'], 24713018, $pass, "2y");
    $pass = strtoupper(hash('whirlpool', $pass));
*/
?>