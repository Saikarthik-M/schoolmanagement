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
        <div class="container mx-auto">
            <h1 class="text-center">Admin detail</h1>
            <div class="alert alert-success">
                <p>Username : <strong> <?php echo $row["username"] ?></strong></p>
                <p>Email : <strong> <?php echo $row["email"] ?> </strong></p>
                <p>Phone : <strong><?php echo $row["phone"] ?> </strong></p>
            </div>
        </div>
        <?php include_once '../footer.php' ?>
    </body>

    </html>
<?php
}
?>