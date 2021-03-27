<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["username"])) {
    echo "<h1>unauthenticated</h1>";
} else if (isset($_POST["rollno"])) {
    include_once '../databaseconnector.php';
    $class = $_POST["class"];
    $section = $_POST["sec"];
    $rollno = $_POST["rollno"];
    $rollno = strtoupper($rollno);
    $subject = $_POST["subject"];
    if (preg_match("/^[A-Z0-9]+$/", $rollno)) {
        $rollno_check = "SELECT EXISTS(SELECT * from teachers where rollno='$rollno') as numbers;";
        $rollno_check = mysqli_query($conn, $rollno_check);
        $result = mysqli_fetch_assoc($rollno_check);
        if ($result["numbers"] == '1') {
            if (preg_match("/^[0-9]{1,2}$/", $class)) {
                if (preg_match("/^[ABC]$/", $section)) {
                    if (preg_match("/^[0-9]{3}$/", $subject)) {
                        $query = mysqli_query($conn, "UPDATE class SET `rollno` ='$rollno' where class_id='$class' and section='$section' and subject_id='$subject' ;");
                        $url = htmlentities($_SERVER["PHP_SELF"]);
                        header("Location: $url?success=1");
                    }
                }
            }
        }
    }
} else {
    include_once '../databaseconnector.php';
    include_once '../head.php';
    include_once '../navigation.php';
?>

    <body>
        <div class="container mx-auto mt-3">
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="post">
                <div class="form-group">
                    <label for="class">Class</label>
                    <?php isset($_GET["class"]) ? $classid = $_GET["class"] : $classid = "129" ?>
                    <select class="form-control" id="class" name="class" required>
                        <?php
                        $class = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
                        for ($sec = 0; $sec < 12; $sec++) {
                        ?>
                            <option value="<?php echo $sec + 1; ?>" <?php echo intval($classid) == $sec + 1 ? "selected" : "" ?>><?php echo $class[$sec]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '1') {
                    ?>
                        <p>Class is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="sec">Section</label>
                    <?php isset($_GET["sec"]) ? $secid = $_GET["sec"] : $secid = "129" ?>
                    <select class="form-control" id="sec" name="sec" required>
                        <?php
                        $section = ["A", "B", "C"];
                        foreach ($section as $sec) {
                        ?>
                            <option value="<?php echo $sec; ?>" <?php echo $secid == $sec ? "selected" : "" ?>><?php echo $sec; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '2') {
                    ?>
                        <p>Section is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="rollno">Roll No</label>
                    <input class="form-control" type="text" name="rollno" pattern="^[A-Za-z0-9]+$" id="rollno" value="<?php echo isset($_GET["rollno"]) ? $_GET["rollno"] : "" ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '3') {
                    ?>
                        <p>Roll no is not in the right format or already exists</p>
                    <?php
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="subject">subject</label>
                    <?php isset($_GET["subject"]) ? $subjectid = $_GET["subject"] : $subjectid = "a" ?>
                    <select class="form-control" id="subject" name="subject" required>
                        <?php
                        $queryresult1 = "SELECT * FROM subject";
                        $queryresult1 = mysqli_query($conn, $queryresult1);
                        while ($row = mysqli_fetch_assoc($queryresult1)) {
                        ?>
                            <option value="<?php echo $row["subject_id"]; ?>" <?php echo $subjectid == $row["subject_id"] ? "selected" : "" ?>><?php echo $row["subject_name"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <input class="btn btn-primary" type="submit" value="Assign staff">
            </form>
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
                        Assigned staff successfully
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
        </div>
        <?php include_once '../footer.php' ?>
    </body>
<?php
}
?>