<?php
include_once 'cookiemanager.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$reverse = htmlentities($_SERVER["REQUEST_URI"]);
$url = htmlentities($_SERVER["REQUEST_URI"]);
$url = explode('/', $url);
$url = $url[sizeof($url) - 2];
if (isset($_GET["logout"])) {
    session_unset();
    session_destroy();
    if (isset($_COOKIE["username"]) && isset($_COOKIE["token"])) {
        cookie_remover($_COOKIE["username"], $_COOKIE["token"]);
        setcookie("username", "", time() - 50000);
        setcookie("token", "", time() - 5000);
    }
    header("Location: http://localhost/" . $url);
}

?>
<style>
    .dropdown-toggle::after {
        display: none;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }
</style>
<?php
if ($url == "") {
?>
    <nav class="navbar navbar-light navbar-expand-md" style="background-color: 9B87FF;">
        <div class="container-fluid">
            <a class="navbar-brand h1" href="http://localhost" style="font-family: 'Yusei Magic', sans-serif;">
                <img src="\images\logo.png" alt="" width="30" height="24" class="d-inline-block align-top">
                Chalkpiece
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo01">

                <ul class="navbar-nav ml-auto text-white text-right">
                    <li class="nav-item">
                        <a class="btn btn-warning" href="./teacher/index.php">Sign in(teachers)</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-success ml-2" href="./student/index.php">Sign in(Students)</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php
} else if ($url == "admin") {
?>
    <nav class="navbar navbar-light navbar-expand-md" style="background-color: 9B87FF;">
        <div class="container-fluid">
            <a class="navbar-brand h1" href="http://localhost" style="font-family: 'Yusei Magic', sans-serif;">
                <img src="\images\logo.png" alt="" width="30" height="24" class="d-inline-block align-top">
                Chalkpiece
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo01">
                <ul class="navbar-nav text-white">
                    <?php
                    if (isset($_SESSION["username"])) {
                        $username = $_SESSION["username"];
                    ?>
                        <div><a href="/admin/profile.php" class="nav-link">Profile</a></div>
                        <div class="dropdown mx-2">
                            <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Add/remove
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="/admin/addteacher.php">Add Teacher</a>
                                <a class="dropdown-item" href="/admin/addstudent.php">Add Student</a>
                                <a class="dropdown-item" href="/admin/addclass.php">Add Class</a>
                                <a class="dropdown-item" href="/admin/addsubject.php">Add Subject</a>
                                <a class="dropdown-item" href="/admin/removeteacher.php">Remove Teacher</a>
                                <a class="dropdown-item" href="/admin/removestudent.php">Remove Student</a>
                                <a class="dropdown-item" href="/admin/removeclass.php">Remove Class</a>
                                <a class="dropdown-item" href="/admin/removesubject.php">Remove Subject</a>
                                <a class="dropdown-item" href="/admin/assignclass.php">Assign subject staffs</a>
                            </div>
                        </div>
                        <div class=" mx-2">
                            <form action="/admin/searchdetails.php" method="POST">
                                <input type="hidden" name="prev" value="<?php echo $reverse; ?>">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="rollno" aria-label="Username" aria-describedby="basic-addon1" name="rollno" required>
                                    <div class="input-group-prepend">
                                        <input type="submit" class="btn btn-dark" value="&#128270;">
                                    </div>
                                    <select name="people" id="people" class="btn btn-dark">
                                        <option value="student">Student</option>
                                        <option value="teachers">Teacher</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <li>
                            <button onclick='location.href="?logout"' class="btn btn-danger">Logout</button>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item ">
                            <p class="nav-link">Welcome , please sign in</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
<?php
} elseif ($url == "teacher") {
?>
    <nav class="navbar navbar-light navbar-expand-md" style="background-color: 9B87FF;">
        <div class="container-fluid">
            <a class="navbar-brand h1" href="http://localhost" style="font-family: 'Yusei Magic', sans-serif;">
                <img src="\images\logo.png" alt="" width="30" height="24" class="d-inline-block align-top">
                Chalkpiece
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo01">
                <ul class="navbar-nav text-white ">
                    <?php
                    if (isset($_SESSION["username"])) {
                        $username = $_SESSION["username"];
                    ?>
                        <div class="nav-item mx-1"><a href="/teacher/profile.php" class="nav-link ">Profile</a></div>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Add/remove student
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="/teacher/addstudent.php">Add Student</a>
                                <a class="dropdown-item" href="/teacher/removestudent.php">Remove Student</a>
                            </div>
                        </div>
                        <div class="mx-1">
                            <form action="/teacher/searchdetails.php" method="POST">
                                <input type="hidden" name="prev" value="<?php echo $reverse; ?>">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="rollno" aria-label="Username" aria-describedby="basic-addon1" name="rollno" required>
                                    <div class="input-group-prepend">
                                        <input type="submit" value="&#128270;" class="btn btn-dark">
                                    </div>
                                    <select name="people" id="people" class="btn btn-dark">
                                        <option value="student">Student</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <li class="nav-item">
                            <button onclick='location.href="?logout"' class="btn btn-danger">Logout</button>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item">
                            <p class="nav-link">Welcome , please sign in</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
<?php
} elseif ($url == "student") {
?>
    <nav class="navbar navbar-light navbar-expand-md" style="background-color: 9B87FF;">
        <div class="container-fluid">
            <a class="navbar-brand h1" href="http://localhost" style="font-family: 'Yusei Magic', sans-serif;">
                <img src="\images\logo.png" alt="" width="30" height="24" class="d-inline-block align-top">
                Cambridge
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo01">
                <ul class="navbar-nav">
                    <?php
                    if (isset($_SESSION["username"])) {
                        $username = $_SESSION["username"];
                    ?>
                        <li class="mx-3">
                            <button onclick='location.href="?logout"' class="btn btn-danger">Logout</button>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item">
                            <p class="nav-link">Welcome , please sign in</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
<?php
}
?>