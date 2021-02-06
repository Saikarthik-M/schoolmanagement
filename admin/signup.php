<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '../databaseconnector.php';

$producttoken = $_SESSION["productverify"];
if (isset($_POST["username"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    if (preg_match("/^[a-z0-9_]+$/i", $username)) {
        $username_available = "SELECT EXISTS(SELECT * FROM admin WHERE username='$username') as numbers;";
        $username_available = mysqli_query($conn, $username_available);
        $row = mysqli_fetch_assoc($username_available);
        if ($row["numbers"] == '0') {
            if (preg_match("/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/", $email)) {
                $email_available = "SELECT EXISTS(SELECT * FROM admin WHERE email='$email') as numbers;";
                $email_available = mysqli_query($conn, $email_available);
                $row = mysqli_fetch_assoc($email_available);
                if ($row["numbers"] == '0') {
                    if (preg_match("/^[0-9]{10}$/", $phone)) {
                        $password = $_POST["password"];
                        if (preg_match("/^[a-zA-Z0-9]{8,15}$/", $password)) {
                            $repassword = $_POST["repassword"];
                            if (preg_match("/^[a-zA-Z0-9]{8,15}$/", $repassword)) {
                                if ($password == $repassword) {
                                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                                    $query = "INSERT INTO `admin` (`username`, `phone`, `email`, `password`) VALUES ('$username', '$phone', '$email', '$hashed_password');";
                                    if (mysqli_query($conn, $query)) {
                                        $productchecker = "SELECT EXISTS(SELECT * from productverify where productverifier='$producttoken') as numbers;";
                                        $productchecker = mysqli_query($conn, $productchecker);
                                        unset($_SESSION["productverify"]);
                                        $_SESSION["username"] = $username;
                                        $deletechecker = "DELETE from productverify where productverifier='$producttoken';";
                                        mysqli_query($conn, $deletechecker);
                                        header("Location: http://localhost/admin");
                                    } else {
                                        echo "something went wrong";
                                    }
                                } else {
                                    $url = htmlentities($_SERVER["PHP_SELF"]);
                                    header("Location: $url?error=0&username=" . urlencode($username) . "&email=" . urlencode($email) . "&phone=" . urlencode($phone));
                                }
                            } else {
                                $url = htmlentities($_SERVER["PHP_SELF"]);
                                header("Location: $url?error=1&username=" . urlencode($username) . "&email=" . urlencode($email) . "&phone=" . urlencode($phone));
                            }
                        } else {
                            $url = htmlentities($_SERVER["PHP_SELF"]);
                            header("Location: $url?error=1&username=" . urlencode($username) . "&email=" . urlencode($email) . "&phone=" . urlencode($phone));
                        }
                    } else {
                        $url = htmlentities($_SERVER["PHP_SELF"]);
                        header("Location: $url?error=2&username=" . urlencode($username) . "&email=" . urlencode($email));
                    }
                } else {
                    $url = htmlentities($_SERVER["PHP_SELF"]);
                    header("Location: $url?error=3&username=" . urlencode($username) . "&phone=" . urlencode($phone));
                }
            } else {
                $url = htmlentities($_SERVER["PHP_SELF"]);
                header("Location: $url?error=3&username=" . urlencode($username) . "&phone=" . urlencode($phone));
            }
        } else {
            $url = htmlentities($_SERVER["PHP_SELF"]);
            header("Location: $url?error=4" . "&email=" . urlencode($email) . "&phone=" . urlencode($phone));
        }
    } else {
        $url = htmlentities($_SERVER["PHP_SELF"]);
        header("Location: $url?error=4" . "&email=" . urlencode($email) . "&phone=" . urlencode($phone));
    }
}
if (isset($_SESSION["productverify"])) {
    $productchecker = "SELECT EXISTS(SELECT * from productverify where productverifier='$producttoken') as numbers;";
    $productchecker = mysqli_query($conn, $productchecker);
    $row = mysqli_fetch_assoc($productchecker);
    if ($row["numbers"] == '1') {

?>
        <html>

        <head>
            <title>signup here</title>
        </head>

        <body>
            <h1>Fill the details here</h1>
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="post">
                <div class="row">
                    <label for="username">Username</label>
                    <input type="text" name="username" pattern="^[a-z0-9_]+$" id="username" value="<?php echo isset($_GET["username"]) ? $_GET["username"] : "" ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '4') {
                    ?>
                        <p>Username is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <div class="row">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo isset($_GET["email"]) ? $_GET["email"] : "" ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '3') {
                    ?>
                        <p>Email is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <div class="row">
                    <label for="phone">Phone number</label>
                    <input type="text" name="phone" id="phone" pattern="^[0-9]{10}$" value="<?php echo isset($_GET["phone"]) ? $_GET["phone"] : "" ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '2') {
                    ?>
                        <p>Phone number must be 10 digit number</p>
                    <?php
                    }
                    ?>
                </div>
                <div class="row">
                    <label for="password">Password</label>
                    <input type="password" pattern="^[a-zA-Z0-9]{8,15}$" name="password" id="password" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '1') {
                    ?>
                        <p>Password is not in the right format</p>
                    <?php
                    } else if (isset($_GET["error"]) && $_GET["error"] == '0') {
                    ?>
                        <p>Password and rewrite password mismatch</p>
                    <?php
                    }
                    ?>
                </div>
                <div class="row">
                    <label for="repassword">Re-write Password</label>
                    <input type="password" pattern="^[a-zA-Z0-9]{8,15}$" name="repassword" id="repassword" required>
                </div>
                <input type="submit" value="Sign up">
            </form>
        </body>

        </html>
    <?php
    }
} else {
    ?>
    <h1 class="display-4">you don't have permission to do this</h1>
<?php
}
?>