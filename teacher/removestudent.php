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
    if (preg_match("/^[A-Z0-9]+$/", $rollno)) {
        $rollno_check = "SELECT EXISTS(SELECT * from student where rollno='$rollno') as numbers;";
        $rollno_check = mysqli_query($conn, $rollno_check);
        $result = mysqli_fetch_assoc($rollno_check);
        if ($result["numbers"] == '1') {
            if (preg_match_all("/^[0-9a-zA-Z \/,.]{2,50}$/m", $reason)) {
                $studentdetails = "SELECT * from student where rollno='$rollno';";
                $studentdetails = mysqli_query($conn, $studentdetails);
                $result = mysqli_fetch_assoc($studentdetails);
                $name = $result["name"];
                $address = $result["address"];
                $phone = $result["phone"];
                $fathername = $result["father_name"];
                $mothername = $result["mother_name"];
                $fatherphone = $result["father_number"];
                $motherphone = $result["mother_number"];
                $fatheroccupation = $result["father_occupation"];
                $motheroccupation = $result["mother_occupation"];
                $email = $result["email"];
                $city = $result["city"];
                $district = $result["district"];
                $dob = $result["dob"];
                $birthcertificatenumber = $result["birth_certificate_number"];
                $class = ["class"];
                $query = "INSERT INTO `removedstudent` (`name`, `rollno`, `reason`, `email`, `address`, `city`, `district`, `class`, `dob`, `birth_certificate_number`, `father_name`, `father_number`, `father_occupation`, `mother_name`, `mother_number`, `mother_occupation`) VALUES ('$name', '$rollno', '$reason', '$email', '$address', '$city', '$district', '$class', '$dob', '$birthcertificatenumber', '$fathername', '$fatherphone', '$fatheroccupation', '$mothername', '$motherphone', '$motheroccupation');";
                mysqli_query($conn, $query);
                $deletequery = "DELETE FROM student where rollno='$rollno';";
                mysqli_query($conn, $deletequery);
                $deletequery = "DELETE FROM fees where rollno='$rollno';";
                mysqli_query($conn, $deletequery);
                $deletequery = "DELETE FROM mark where rollno='$rollno';";
                mysqli_query($conn, $deletequery);
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
        <div class="container mx-auto my-2">
            <h1 class="text-center">Remove Student</h1>
            <div class="jumbotron">
                <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="post">
                    <div class="form-group">
                        <label for="rollno">Roll No</label>
                        <input class="form-control" type="text" name="rollno" pattern="^[A-Za-z0-9]+$" id="rollno" value="<?php echo isset($_GET["rollno"]) ? $_GET["rollno"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '1') {
                        ?>
                            <p>Roll no is not in the right format or already exists</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason (within 50 letters including whitespace)</label>
                        <input class="form-control" type="text" name="reason" pattern="^[0-9a-zA-Z \/,.]{2,50}$" id="reason" value="<?php echo isset($_GET["reason"]) ? $_GET["reason"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '2') {
                        ?>
                            <p>Reason is not in the right format</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="text-center"><input class="btn btn-md px-5 btn-danger" type="submit" value="Remove Student"></div>
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
                                Removed student successfully
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
            </div>
        </div>
    </body>
    <?php
    include_once '../footer.php'
    ?>

    </html>
<?php
}
?>