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
        $teachers_in_database = "SELECT EXISTS(SELECT * FROM teachers where rollno='$username') as numbers;";
        $teachers_in_database = mysqli_query($conn, $teachers_in_database);
        $row = mysqli_fetch_assoc($teachers_in_database);
        if ($row["numbers"] == '1') {
            $password = $_POST["password"];
            if (preg_match("/^[a-zA-Z0-9]{8,15}$/", $password)) {
                $hashed_password_in_db = "SELECT * from teachers where rollno='$username';";
                $hashed_password_in_db = mysqli_query($conn, $hashed_password_in_db);
                $row = mysqli_fetch_assoc($hashed_password_in_db);
                if (password_verify($password, $row["password"])) {
                    $_SESSION["username"] = $username;
                    if ($_POST["rememberme"] == '1') {
                        old_cookie_remover($username);
                        cookie_generator($username);
                    }
                    header("Location: profile.php");
                } else {
                    header("Location: http://localhost/teacher?error=3");
                }
            } else {
                header("Location: http://localhost/teacher?error=3");
            }
        } else {
            header("Location: http://localhost/teacher?error=4");
        }
    } else {
        header("Location: http://localhost/teacher?error=4");
    }
} else {
?>
    <html>
    <?php include_once '../head.php' ?>

    <body>
        <?php include_once '../navigation.php'; ?>
        <div class="container my-5">
            <div class="col-md-6 col-sm-6">
                <h1 class="display-4 row">WELCOME Teacher!</h1>
                <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="post" class="">
                    <div class="form-group">
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '3') {
                        ?>
                            <p class="text-danger">Invalid login details</p>
                        <?php
                        }
                        ?>
                        <label for="username">Roll No</label>
                        <input type="text" name="username" pattern="^[a-zA-Z0-9_]+$" id="username" class="form-control" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '4') {
                        ?>
                            <p class="text-danger">Invalid Roll No</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" pattern="^[a-zA-Z0-9]{8,15}$" id="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="rememberme" id="rememberme" value="1">
                        <label for="rememberme">Remember me</label>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" value="Sign in" class="text-center btn btn-primary px-5 btn-md">
                    </div>
                </form>
            </div>
        </div>
    </body>

    </html>
<?php
}
?>