<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["username"])) {
    echo "<h1>unauthenticated</h1>";
} else if (isset($_POST["rollno"])) {
    include_once '../databaseconnector.php';
    $rollno = $_POST["rollno"];
    $rollno = strtoupper($rollno);
    $reason = $_POST["reason"];
    if (preg_match("/^[a-z0-9]+$/i", $rollno)) {
        $rollno_check = "SELECT EXISTS(SELECT * from teachers where rollno='$rollno') as numbers;";
        $rollno_check = mysqli_query($conn, $rollno_check);
        $result = mysqli_fetch_assoc($rollno_check);
        if ($result["numbers"] == '1') {
            if (preg_match_all("/^[0-9a-zA-Z \/,.]{2,50}$/m", $reason)) {
                $teacherdetails = "SELECT * from teachers where rollno='$rollno';";
                $teacherdetails = mysqli_query($conn, $teacherdetails);
                $result = mysqli_fetch_assoc($teacherdetails);
                $name = $result["name"];
                $address = $result["address"];
                $phone = $result["phone"];
                $dateofjoining = $result["date_of_joining"];
                $email = $result["email"];
                $city = $result["city"];
                $district = $result["district"];
                $dob = $result["dob"];
                $subject = $result["subject"];
                $query = "INSERT INTO `removedteacher` (`rollno`, `reason`, `name`, `address`, `phone`, `dateofjoining`, `email`, `city`, `district`, `dob`, `subject`) VALUES ('$rollno', '$reason', '$name', '$address', '$phone', '$dateofjoining', '$email', '$city', '$district', '$dob', '$subject');";
                mysqli_query($conn, $query);
                $deletequery = "DELETE FROM teachers where rollno='$rollno';";
                mysqli_query($conn, $deletequery);
                $deletequery1 = "DELETE FROM salary where rollno='$rollno';";
                mysqli_query($conn, $deletequery1);
                $deletequery2 = "DELETE FROM teacherrecords where rollno='$rollno';";
                mysqli_query($conn, $deletequery2);
                $url = htmlentities($_SERVER["PHP_SELF"]);
                header("Location: $url?success=1");
            } else {
                $url = htmlentities($_SERVER["PHP_SELF"]);
                header("Location: $url?error=2&rollno=" . urlencode($rollno));
            }
        } else {
            $url = htmlentities($_SERVER["PHP_SELF"]);
            header("Location: $url?error=1&reason=" . urlencode($reason));
        }
    } else {
        $url = htmlentities($_SERVER["PHP_SELF"]);
        header("Location: $url?error=1&reason=" . urlencode($reason));
    }
} else {
    include_once '../head.php';
    include_once '../navigation.php';
?>
    <html>

    <body>
        <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="post">
            <div>
                <label for="rollno">Roll No</label>
                <input type="text" name="rollno" pattern="^[A-Za-z0-9]+$" id="rollno" value="<?php echo isset($_GET["rollno"]) ? $_GET["rollno"] : "" ?>" required>
                <?php
                if (isset($_GET["error"]) && $_GET["error"] == '1') {
                ?>
                    <p>Roll no is not in the right format or already exists</p>
                <?php
                }
                ?>
            </div>
            <div>
                <label for="reason">Reason (within 50 letters including whitespace)</label>
                <input type="text" name="reason" id="reason" pattern="^[0-9a-zA-Z \/,.]{2,50}$" value="<?php echo isset($_GET["reason"]) ? $_GET["reason"] : "" ?>" required>
                <?php
                if (isset($_GET["error"]) && $_GET["error"] == '2') {
                ?>
                    <p>Reason is not in the right format</p>
                <?php
                }
                ?>
            </div>
            <input type="submit" value="Remove teacher">
            <?php
            if (isset($_GET["success"])) {
            ?>
                <div class="toast" data-autohide=false>
                    <div class="toast-header">
                        <strong class="mr-auto text-success">Success</strong>
                        <small class="text-muted">1 sec ago</small>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" id="btn">&times;</button>
                    </div>
                    <div class="toast-body">
                        Removed staff successfully
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        $('.toast').toast('show');
                    });
                </script>
            <?php
            }
            ?>
        </form>
    </body>

    </html>
<?php
}
?>