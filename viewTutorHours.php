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
    <title>Manage Tutors - KUTutoring</title>
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
                    <?php if ($permissionLevel > 0) { ?><li class="nav-item"><a class="nav-link" href="managecourses"><i class="fas fa-user"></i><span>Manage Courses</span></a></li><?php } ?>
                    <?php if ($permissionLevel > 0) { ?><li class="nav-item"><a class="nav-link active" href="viewTutorHours"><i class="fas fa-user"></i><span>View Tutor Hours</span></a></li><?php } ?>
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
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in"><a class="dropdown-item" href="signout"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a></div>
                    </div>
                    </li>
                    </ul>
            </div>
            </nav>
            <div class="container-fluid">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark mb-0">Tutor Hours</h3>
                </div>
                <div class="row">
                    <div class="col col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-primary font-weight-bold m-0">Select Date</h6>
                            </div>
                            <div class="card-body">
                                <form class="tutor-hours" method="post" action="viewTutorHours">
                                    <div class="form-row date-radio" id="radio">
                                        <div class="col">
                                            <input type="radio" id="week" class="radio" name="action" value="week" checked=""><label id="week" class="radio-label" for="week">Week</label>
                                            <input type="radio" id="month" class="radio" name="action" value="month"><label id="month" class="radio-label" for="month">Month</label>
                                        </div>
                                    </div>
                                    <div class="form-row" id="info">
                                        <div class="col">
                                            <div class="hours-info" id="form-data">
                                                <label class="input-label" for="week">Week</label>
                                                <input class="form-control input-field" type="date" id="date-picker" name="week" <?php if(!empty($_POST)) { if(isset($_POST['week'])) { print("value=" . $_POST['week']); } } ?> required>
                                                <button class="btn btn-primary input-button" type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 font-weight-bold">Tutor Hours</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                    <table class="table my-0" id="tutorHours">
                                        <thead>
                                            <tr>
                                                <th>Student ID</th>
                                                <th>Email</th>
                                                <th>Name</th>
                                                <th>Swipe In</th>
                                                <th>Swipe Out</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!empty($_POST)) {
                                                    $data = $_POST;
                                                    if (isset($data['week'])) {
                                                        $dates = getStartAndEndDate("week", $data['week']);
                                                    } elseif (isset($data['month'])) {
                                                        $dates = getStartAndEndDate("month", $data['month']);
                                                    }
                                                    $tutorHours = getTutorHours($dates);
                                                    $totalTutorHours = array();
                                                    foreach($tutorHours as $tutor) {
                                                        if (!isset($totalTutorHours[$tutor['studentID']])) {
                                                            $totalTutorHours[$tutor['studentID']] = $tutor;
                                                            $totalTutorHours[$tutor['studentID']]['time'] = calculateHours($tutor['swipein'], $tutor['swipeout']);
                                                        } else {
                                                            $totalTutorHours[$tutor['studentID']]['time'] = $totalTutorHours[$tutor['studentID']]['time'] + calculateHours($tutor['swipein'], $tutor['swipeout']);
                                                        }
                                                    }
                                                    foreach($totalTutorHours as $tutor) {
                                                        print('<tr>');
                                                            print('<td>'.$tutor['studentID'].'</td>');
                                                            print('<td>'.$tutor['email'].'</td>');
                                                            print('<td>'.$tutor['name'].'</td>');
                                                            print('<td>'.$tutor['swipein'].'</td>');
                                                            print('<td>'.$tutor['swipeout'].'</td>');
                                                            print('<td>'.gmdate("H:i:s", $tutor['time']).'</td>');
                                                        print('</tr>');
                                                    }
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
        $(document).ready(function(){
            $('#radio').change(function() {
                if ($('.radio:checked').val() === 'week') {
                    document.getElementById("form-data").innerHTML = '<div class="form-row" id="info"><div class="col"><div class="hours-info" id="form-data"><label class="input-label" for="week">Week</label><input class="form-control input-field" type="date" id="date-picker" name="week" <?php if(!empty($_POST)) { if($_POST['week']) { print("value=" . $_POST['week']); } } ?> required><button class="btn btn-primary input-button" type="submit">Submit</button></div></div></div>';
                } else {
                    document.getElementById("form-data").innerHTML = '<div class="form-row" id="info"><div class="col"><div class="hours-info" id="form-data"><label class="input-label" for="month">Month</label><input class="form-control input-field" type="month" id="date-picker" name="month" <?php if(!empty($_POST)) { if($_POST['month']) { print("value=" . $_POST['month']); } } ?> required><button class="btn btn-primary input-button" type="submit">Submit</button></div></div></div>';
                }
            });
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!
            var yyyy = today.getFullYear();
            if(dd<10){
                dd='0'+dd
            }
            if(mm<10){
                mm='0'+mm
            }
            today = yyyy+'-'+mm+'-'+dd;
            document.getElementById("date-picker").setAttribute("max", today);
        });
    </script>
    <script>
        $(document).ready(function(){
            $('#tutorHours').dataTable();
        });
    </script>
</body>

</html>