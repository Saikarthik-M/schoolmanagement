<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["username"])) {
    echo "<h1>unauthenticated</h1>";
} else if (isset($_POST["subid"])) {
    include_once '../databaseconnector.php';
    $subid = $_POST["subid"];
    if (preg_match("/^[0-9]{3}$/", $subid)) {
        $subject_id_checker = "SELECT EXISTS(SELECT subject_name FROM subject where subject_id='$subid') as numbers ;";
        $subject_id_checker = mysqli_query($conn, $subject_id_checker);
        $row = mysqli_fetch_assoc($subject_id_checker);
        if ($row["numbers"] == '1') {
            $query = "DELETE FROM subject where subject_id='$subid';";
            mysqli_query($conn, $query);
            $query1 = "DELETE FROM class where subject_id='$subid';";
            mysqli_query($conn, $query1);
            $query2 = "DELETE FROM mark where subject_id='$subid';";
            mysqli_query($conn, $query2);
            $url = htmlentities($_SERVER["PHP_SELF"]);
            header("Location: $url");
        } else {
            $url = htmlentities($_SERVER["PHP_SELF"]);
            header("Location: $url?error=3");
        }
    } else {
        $url = htmlentities($_SERVER["PHP_SELF"]);
        header("Location: $url?error=3");
    }
} else {
    include_once '../head.php';
    include_once '../navigation.php';

?>
    <html>

    <body>
        <div class="container mx-auto mt-3">
            <div class="row">
                <div class="col">
                    <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="post">
                        <?php
                        if (isset($_GET["error"])) {
                            echo "<p>Subject ID is not in the right format or does not exists</p>";
                        }
                        ?>
                        <div class="form-group">
                            <label for="subid">Subject ID</label>
                            <input class="form-control" type="text" name="subid" pattern="^[0-9]{3}$" id="subid">
                        </div>
                        <input class="btn btn-danger px-5" type="submit" value="Remove Subject">
                    </form>
                </div>
                <div class="col">
                    <table class="table table-striped table-dark">
                        <thead>
                            <th>Subject ID</th>
                            <th>Subject name</th>
                        </thead>
                        <?php
                        include_once '../databaseconnector.php';
                        $queryresult1 = "SELECT * FROM subject";
                        $queryresult1 = mysqli_query($conn, $queryresult1);
                        while ($row = mysqli_fetch_assoc($queryresult1)) {
                        ?>
                            <tr>
                                <td>
                                    <?php echo $row["subject_id"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["subject_name"]; ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <?php include_once '../footer.php' ?>
    </body>

    </html>
<?php
}
?>