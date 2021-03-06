<?php
include "assets/functions.php";

if (!isLoggedIn()) {
    header("Location: login");
    exit();
}
$permissionLevel = getUserPerms();
if (!($permissionLevel > 0)) {
    header("Location: index");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Manage Courses - KUTutoring</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><img id="nav-bear-logo" src="assets/img/home/bear-logo.png"></div>
                    <div class="sidebar-brand-text mx-3"><span>KUTutoring</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="index"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="sessionHistory"><i class="fas fa-tachometer-alt"></i><span>Session History</span></a></li>
                    <?php if ($permissionLevel > 0) { ?><li class="nav-item"><a class="nav-link" href="managetutor"><i class="fas fa-user"></i><span>Manage Tutors</span></a></li><?php } ?>
                    <?php if ($permissionLevel > 0) { ?><li class="nav-item"><a class="nav-link active" href="managecourses"><i class="fas fa-user"></i><span>Manage Courses</span></a></li><?php } ?>
                    <?php if ($permissionLevel > 0) { ?><li class="nav-item"><a class="nav-link" href="viewTutorHours"><i class="fas fa-user"></i><span>View Tutor Hours</span></a></li><?php } ?>
                    <li class="nav-item"><a class="nav-link" href="reportsession"><i class="icon-notebook"></i><span>Report Session</span></a></li>
                    <li class="nav-item"></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small"><?php print_r(unserialize($_COOKIE['user'])['fName'] . ' ' . unserialize($_COOKIE['user'])['lName']); ?></span><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar5.jpeg"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in"><a class="dropdown-item" href="signout"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            <div class="container-fluid">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark mb-0">Manage Courses</h3>
                </div>
                <?php
                if(!empty($_POST)) {
                    $data = $_POST;
                    if ($data['action'] == 'add') {
                        $done = addCourse($data['coursePrefix'], $data['courseNumber'], $data['courseSection'], $data['courseName'], $data['proctor'], $data['courseTime']);
                        if ($done) {
                            print("<div class=\"alert alert-success\" role=\"alert\">" . $data['coursePrefix'] . " " . $data['courseNumber'] . "-" . $data['courseSection'] . " has been added.</div>");
                        } else {
                            print("<div class=\"alert alert-danger\" role=\"alert\">There was an error in your input, please try again.</div>");
                        }
                    } elseif ($data['action'] == 'remove') {
                        $done = removeCourse($data['coursePrefix'], $data['courseNumber'], $data['courseSection']);
                        if ($done) {
                            print("<div class=\"alert alert-success\" role=\"alert\">" . $data['coursePrefix'] . " " . $data['courseNumber'] . "-" . $data['courseSection'] . " has been removed.</div>");
                        } else {
                            print("<div class=\"alert alert-danger\" role=\"alert\">Could not find " . $data['coursePrefix'] . " " . $data['courseNumber'] . "-" . $data['courseSection'] . ".</div>");
                        }
                    } else {
                        print("<p>Invalid Option</p>");
                    }
                }
                ?>
                <div class="row">
                    <div class="col col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-primary font-weight-bold m-0">Add/Remove Courses - Single</h6>
                            </div>
                            <div class="card-body">
                                <form class="manage-courses" method="post" action="managecourses">
                                    <div class="form-row manage-radio" id="radio">
                                        <div class="col">
                                            <input type="radio" id="add" class="radio" name="action" value="add" checked=""><label id="add" class="radio-label" for="add">Add</label>
                                            <input type="radio" id="remove" class="radio" name="action" value="remove"><label id="remove" class="radio-label" for="remove">Remove</label></div>
                                    </div>
                                    <div class="form-row" id="info">
                                        <div class="col">
                                            <div class="course-info" id="form-data">
                                                <label class="input-label" for="coursePrefix">Course Prefix</label>
                                                <input class="form-control input-field" type="text" name="coursePrefix" required>
                                                <label class="input-label" for="courseNumber">Course Number</label>
                                                <input class="form-control input-field" type="number" name="courseNumber" required>
                                                <label class="input-label" for="courseSection">Course Section</label>
                                                <input class="form-control input-field" type="number" name="courseSection" required>
                                                <label class="input-label" for="courseName">Course Name</label>
                                                <input class="form-control input-field" type="text" name="courseName" required>
                                                <label class="input-label" for="proctor">Proctor</label>
                                                <input class="form-control input-field" type="text" name="proctor" required>
                                                <label class="input-label" for="courseTime">Course Time</label>
                                                <input class="form-control input-field" type="time" name="courseTime" required>
                                                <button class="btn btn-primary input-button" type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 font-weight-bold">Course List</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                    <table class="table my-0" id="courseList">
                                        <thead>
                                            <tr>
                                                <th>Prefix</th>
                                                <th>Number</th>
                                                <th>Section</th>
                                                <th>Name</th>
                                                <th>Proctor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $courses = getCourses();
                                                foreach($courses as $course) {
                                                    print('<tr>');
                                                        print('<td>'.$course['coursePrefix'].'</td>');
                                                        print('<td>'.$course['courseNumber'].'</td>');
                                                        print('<td>'.$course['courseSection'].'</td>');
                                                        print('<td>'.$course['courseName'].'</td>');
                                                        print('<td>'.$course['proctor'].'</td>');
                                                    print('</tr>');
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © KUTutoring 2020</span></div>
            </div>
        </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script>
        $(document).ready(function() {
            $('#radio').change(function() {
                if ($('.radio:checked').val() === 'add') {
                    document.getElementById("form-data").innerHTML = '<label class="input-label" for="coursePrefix">Course Prefix</label><input class="form-control input-field" type="text" name="coursePrefix" required><label class="input-label" for="courseNumber">Course Number</label><input class="form-control input-field" type="number" name="courseNumber" required><label class="input-label" for="courseSection">Course Section</label><input class="form-control input-field" type="number" name="courseSection" required><label class="input-label" for="courseName">Course Name</label><input class="form-control input-field" type="text" name="courseName" required><label class="input-label" for="proctor">Proctor</label><input class="form-control input-field" type="text" name="proctor" required><label class="input-label" for="courseTime">Course Time</label><input class="form-control input-field" type="time" name="courseTime" required><button class="btn btn-primary input-button" type="submit">Submit</button>';
                } else {
                    document.getElementById("form-data").innerHTML = '<label class="input-label" for="coursePrefix">Course Prefix</label><input class="form-control input-field" type="text" name="coursePrefix" required><label class="input-label" for="courseNumber">Course Number</label><input class="form-control input-field" type="number" name="courseNumber" required><label class="input-label" for="courseSection">Course Section</label><input class="form-control input-field" type="number" name="courseSection" required><button class="btn btn-primary input-button" type="submit">Submit</button>';
                }
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $('#courseList').dataTable();
        });
    </script>
</body>

</html>