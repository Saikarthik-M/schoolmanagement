<?php
include_once '../databaseconnector.php';
include_once '../cookiemanager.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_COOKIE["username"]) && isset($_COOKIE["token"])) {
    $username = $_COOKIE["username"];
    $token = $_COOKIE["token"];
    if (cookie_verifier($username, $token)) {
        $_SESSION["username"] = $username;
        header("Location: profile.php");
    }
}
if (isset($_SESSION["username"])) {
    header("Location: profile.php");
} else if (isset($_POST["username"])) {
    $username = $_POST["username"];
    $username = strtoupper($username);
    if (preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $students_in_database = "SELECT EXISTS(SELECT * FROM student where rollno='$username') as numbers;";
        $students_in_database = mysqli_query($conn, $students_in_database);
        $row = mysqli_fetch_assoc($students_in_database);
        if ($row["numbers"] == '1') {
            $password = $_POST["password"];
            if (preg_match("/^[-0-9]{8,15}$/", $password)) {
                $dob_in_db = "SELECT * from student where rollno='$username';";
                $dob_in_db = mysqli_query($conn, $dob_in_db);
                $row = mysqli_fetch_assoc($dob_in_db);
                if ($row["dob"] == $password) {
                    $_SESSION["username"] = $username;
                    if ($_POST["rememberme"] == '1') {
                        old_cookie_remover($username);
                        cookie_generator($username);
                    }
                    header("Location: profile.php");
                } else {
                    header("Location: http://localhost/student?error=3");
                }
            } else {
                header("Location: http://localhost/student?error=3");
            }
        } else {
            header("Location: http://localhost/student?error=4");
        }
    } else {
        header("Location: http://localhost/student?error=4");
    }
} else {
?>
    <html>
    <?php include_once '../head.php' ?>

    <body>
        <?php include_once '../navigation.php'; ?>
        <div class="container mx-auto mt-3">

            <h1 class="display-4 text-center">WELCOME Student!</h1>
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="post">
                <div class="form-group">
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '3') {
                    ?>
                        <p class="text-danger">Invalid login details</p>
                    <?php
                    }
                    ?>
                    <label for="username">Roll No</label>
                    <input class="form-control" type="text" name="username" pattern="^[a-zA-Z0-9_]+$" id="username" class="col-md-6 col-sm-6" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '4') {
                    ?>
                        <p class="text-danger">Invalid Roll No</p>
                    <?php
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="password">Date of Birth</label>
                    <input class="form-control" type="date" name="password" id="password" class="col-md-6 col-sm-6 mt-2" required>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="rememberme" id="rememberme" value="1">
                    <label for="rememberme">Remember me</label>
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="sign in" class="text-center col-md-4 col-sm-3">
                </div>
            </form>

        </div>
        <?php include_once '../footer.php' ?>
    </body>

    </html>
<?php
}
?>