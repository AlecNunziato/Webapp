<?php
include "assets/functions.php";

if (!isLoggedIn()) {
    header("Location: login");
    exit();
}
$permissionLevel = getUserPerms();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Session History - KUTutoring</title>
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
                    <li class="nav-item"><a class="nav-link active" href="sessionHistory"><i class="fas fa-tachometer-alt"></i><span>Session History</span></a></li>
                    <?php if ($permissionLevel > 0) { ?><li class="nav-item"><a class="nav-link" href="managetutor"><i class="fas fa-user"></i><span>Manage Tutors</span></a></li><?php } ?>
                    <?php if ($permissionLevel > 0) { ?><li class="nav-item"><a class="nav-link" href="managecourses"><i class="fas fa-user"></i><span>Manage Courses</span></a></li><?php } ?>
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
                <h3 class="text-dark mb-4">Session History</h3>
                <div class="card shadow">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 font-weight-bold">Session History</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0" id="studentHistTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Student ID</th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Course</th>
                                        <th>Tutor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $studentData = getStudentHistory();
                                        foreach($studentData as $session) {
                                            print('<tr>');
                                                print('<td>'.$session['timeTutored'].'</td>');
                                                print('<td>'.$session['stuID'].'</td>');
                                                print('<td>'.$session['email'].'</td>');
                                                print('<td>'.$session['fName'].' '.$session['lName'].'</td>');
                                                print('<td>'.$session['course'].'</td>');
                                                print('<td>'.$session['tutorLname'].'</td>');
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
    <script type="text/javascript" src="js/addons/datatables.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script>
        $(document).ready(function(){
            $('#studentHistTable').dataTable();
        });
    </script>
</body>

</html>