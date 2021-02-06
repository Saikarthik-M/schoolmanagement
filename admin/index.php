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
}
if (isset($_POST["productkey"])) {
    $productkey = $_POST["productkey"];
    if (preg_match("/^[a-z0-9]+$/i", $productkey)) {
        $productkey_in_database = "SELECT * from `product key` ;";
        $productkey_in_database = mysqli_query($conn, $productkey_in_database);
        $result = mysqli_fetch_assoc($productkey_in_database);
        if ($result["product key"] == $productkey) {
            $producttoken = rand(100000, 999999);
            $product_verify = "INSERT INTO productverify(`productverifier`) values('$producttoken');";
            mysqli_query($conn, $product_verify);
            $_SESSION["productverify"] = $producttoken;
            header("Location: signup.php");
        } else {
            header("Location: http://localhost/admin?error=1");
        }
    } else {
        header("Location: http://localhost/admin?error=1");
    }
} else if (isset($_POST["username"])) {
    $username = $_POST["username"];
    if (preg_match("/^[a-z0-9_]+$/", $username)) {
        $admins_in_database = "SELECT EXISTS(SELECT * FROM admin where username='$username') as numbers;";
        $admins_in_database = mysqli_query($conn, $admins_in_database);
        $row = mysqli_fetch_assoc($admins_in_database);
        if ($row["numbers"] == '1') {
            $password = $_POST["password"];
            if (preg_match("/^[a-zA-Z0-9]{8,15}$/", $password)) {
                $hashed_password_in_db = "SELECT * from admin where username='$username';";
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
                    header("Location: http://localhost/admin?error=3");
                }
            } else {
                header("Location: http://localhost/admin?error=3");
            }
        } else {
            header("Location: http://localhost/admin?error=4");
        }
    } else {
        header("Location: http://localhost/admin?error=4");
    }
} else {
?>
    <html>
    <?php include_once '../head.php' ?>

    <body>
        <?php include_once '../navigation.php'; ?>
        <div class="jumbotron container">
            <div class="row">
                <div class="col-md-6 col-sm-6 border-right border-success">
                    <h1 class="display-4 row">New admin signup!</h1>
                    <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="post" class="row input-group">
                        <label for="product">Product key</label>
                        <input type="text" name="productkey" id="product" class="col-md-6 col-sm-6" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '1') {
                        ?>
                            <p class="text-danger">Invalid product key</p>
                        <?php
                        }
                        ?>
                        <input type="submit" value="submit" class="text-center col-md-4 col-sm-3">
                    </form>
                </div>

                <div class="col-md-6 col-sm-6">
                    <h1 class="display-4 row">WELCOME admin!</h1>
                    <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="post" class="">
                        <div class="row">
                            <?php
                            if (isset($_GET["error"]) && $_GET["error"] == '3') {
                            ?>
                                <p class="text-danger">Invalid login details</p>
                            <?php
                            }
                            ?>
                            <label for="username">Username</label>
                            <input type="text" name="username" pattern="^[a-z0-9_]+$" id="username" class="col-md-6 col-sm-6" required>
                            <?php
                            if (isset($_GET["error"]) && $_GET["error"] == '4') {
                            ?>
                                <p class="text-danger">Invalid username</p>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="row ">
                            <label for="password">Password</label>
                            <input type="password" name="password" pattern="^[a-zA-Z0-9]{8,15}$" id="password" class="col-md-6 col-sm-6 mt-2" required>
                        </div>
                        <div class="row">
                            <input type="checkbox" name="rememberme" id="rememberme" value="1">
                            <label for="rememberme">Remember me</label>
                        </div>
                        <div class="row ">
                            <input type="submit" value="sign in" class="text-center col-md-4 col-sm-3">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
}
?>