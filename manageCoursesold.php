<?php
include "assets/functions.php";

if (!isLoggedIn()) {
    header("Location: login");
    exit();
}
?>

<?php
if(!empty($_POST)) {
    $data = $_POST;
    if ($data['action'] == 'add') {
        addCourse($data['coursePrefix'], $data['courseNumber'], $data['courseName'], $data['proctor'], $data['courseTime']);
    } elseif ($data['action'] == 'remove') {
        removeCourse($data['coursePrefix']);
    } else {
        print("<p>Invalid Option</p>");
    }
}
?>

<form class="manage-course" method="post" action="managecourse">
<div class="form-row manage-radio" id="radio">
<div class="col">
<input type="radio" id="add" class="radio" name="action" value="add" checked=""><label id="add" class="radio-label" for="add">Add</label>
<input type="radio" id="remove" class="radio" name="action" value="remove"><label id="remove" class="radio-label" for="remove">Remove</label></div>

<div class="form-row" id="info">
<div class="col">
    <div class="tutor-info" id="form-data">
        <label class="input-label" for="coursePrefix">Course Prefix</label>
        <input class="form-control input-field" type="text" name="coursePrefix" required>
        <label class="input-label" for="courseNumber">Course Number</label>
        <input class="form-control input-field" type="number" name="courseNumber" required>
        <label class="input-label" for="courseName">Course Name</label>
        <input class="form-control input-field" type="text" name="courseName" required>
        <label class="input-label" for="proctor">Proctor</label>
        <input class="form-control input-field" type="text" name="proctor" required>
        <label class="input-label" for="courseTime">Course Time</label>
        <input class="form-control input-field" type="text" name="courseTime" required>
        <button class="btn btn-primary input-button" type="submit">Submit</button>
    </div>
</div>
</div>

