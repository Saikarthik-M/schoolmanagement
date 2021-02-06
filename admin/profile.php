<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["username"])) {
    echo "unauthenticated";
} else {
    include_once '../databaseconnector.php';
    $username = $_SESSION["username"];
    $admin_details = "SELECT * FROM admin where username = '$username';";
    $admin_details = mysqli_query($conn, $admin_details);
    $row = mysqli_fetch_assoc($admin_details);
?>
    <html>
    <?php include_once '../head.php' ?>

    <body>
        <?php include_once '../navigation.php' ?>
        <h1>Admin detail</h1>
        <h6>Username : <?php echo $row["username"] ?></h6>
        <h6>Email : <?php echo $row["email"] ?></h6>
        <h6>Phone : <?php echo $row["phone"] ?></h6>
    </body>

    </html>
<?php
}
?>