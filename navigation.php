<?php
include_once 'cookiemanager.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET["logout"])) {
    session_unset();
    session_destroy();
    if (isset($_COOKIE["username"]) && isset($_COOKIE["token"])) {
        cookie_remover($_COOKIE["username"], $_COOKIE["token"]);
        setcookie("username", "", time() - 50000);
        setcookie("token", "", time() - 5000);
    }
    header("Location: http://localhost/admin");
}
$reverse = htmlentities($_SERVER["REQUEST_URI"]);
$url = htmlentities($_SERVER["REQUEST_URI"]);
$url = explode('/', $url);
$url = $url[sizeof($url) - 2];

if ($url == "") {
?>
    <nav class="navbar navbar-light navbar-expand-md bg-secondary bg-gradient">
        <div class="container-fluid">
            <a class="navbar-brand h1" href="http://localhost" style="font-family: 'Yusei Magic', sans-serif;">
                <img src="\images\logo.png" alt="" width="30" height="24" class="d-inline-block align-top">
                Cambridge
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo01">

                <ul class="navbar-nav mr-auto nav-tabs text-white">
                    <li class="nav-item">
                        <a class="nav-link" href="teacherlogin.php">Sign in(teachers)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sign in(Students)</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php
} else if ($url == "admin") {
?>
    <nav class="navbar navbar-light navbar-expand-md bg-secondary bg-gradient">
        <div class="container-fluid">
            <a class="navbar-brand h1" href="http://localhost" style="font-family: 'Yusei Magic', sans-serif;">
                <img src="\images\logo.png" alt="" width="30" height="24" class="d-inline-block align-top">
                Cambridge
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo01">
                <ul class="navbar-nav mr-auto nav-tabs text-white">
                    <?php
                    if (isset($_SESSION["username"])) {
                        $username = $_SESSION["username"];
                    ?>
                        <div><a href="/admin/profile.php" class="nav-link">Profile</a></div>
                        <div class="dropdown">
                            <a class="btn btn-danger dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <div class="">
                            <form action="/admin/searchdetails.php" method="POST">
                                <input type="hidden" name="prev" value="<?php echo $reverse; ?>">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="rollno" aria-label="Username" aria-describedby="basic-addon1" name="rollno" required>
                                    <div class="input-group-prepend">
                                        <input type="submit" value="&#128270;">
                                    </div>
                                    <select name="people" id="people" class="btn btn-secondary">
                                        <option value="student">Student</option>
                                        <option value="teachers">Teacher</option>
                                    </select>
                                </div>
                            </form>
                        </div>

                        <li class="">
                            <p class="">Welcome ,<?php echo $username; ?></p>
                        </li>
                        <li>
                            <button onclick='location.href="?logout"'>Logout</button>
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