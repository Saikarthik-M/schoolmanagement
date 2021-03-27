<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["username"])) {
    echo "<h1>unauthenticated</h1>";
} else {
    include_once '../databaseconnector.php';
    include_once '../head.php';
    include_once '../navigation.php';
?>
    <html>

    <body>
        <div class="container mx-auto mt-3">
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <label for="class">Class</label>
                    <?php isset($_POST["class"]) ? $clremove = $_POST["class"] : $clremove = "" ?>
                    <select class="form-control" id="class" name="class" required>
                        <?php
                        $class = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
                        for ($sec = 0; $sec < 12; $sec++) {
                        ?>
                            <option value="<?php echo $sec + 1; ?>" <?php echo intval($clremove) == $sec + 1 ? "selected" : "" ?>><?php echo $class[$sec]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
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
                <input type="submit" class="btn btn-danger mt-3" value="Remove class course">
            </form>

            <!-- ajax work pending here  -->

            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <label for="class">Class</label>
                    <?php isset($_POST["classview"]) ? $clview = $_POST["classview"] : $clview = "" ?>
                    <select class="form-control" id="class" name="classview" onchange='this.form.submit();' required>
                        <?php
                        $class = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
                        for ($sec = 0; $sec < 12; $sec++) {
                        ?>
                            <option value="<?php echo $sec + 1; ?>" <?php echo intval($clview) == $sec + 1 ? "selected" : "" ?>><?php echo $class[$sec]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
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
            </form>

            <!-- ajax work pending here  -->

            <?php
            if (isset($_POST["class"])) {
                $classremove = $_POST["class"];
                $section = $_POST["sec"];
                if (preg_match("/^[0-9]{1,2}$/", $classremove)) {
                    if (preg_match("/^[ABC]$/", $section)) {
                        $query3 = "DELETE FROM class where class_id = '$classremove' and section='$section';";
                        mysqli_query($conn, $query3);
                        $query4 = "SELECT rollno from student where class_id='$classremove' and section='$section';";
                        $query4 = mysqli_query($conn, $query4);
                        if ($query4) {
                            while ($row = mysqli_fetch_assoc($query4)["rollno"]) {
                                $query5 = "DELETE FROM mark where rollno='$row';";
                                mysqli_query($conn, $query5);
                            }
                        }
                    } else {
                        echo "<p>give a valid input</p>";
                    }
                } else {
                    echo "<p>give a valid input</p>";
                }
            }
            function viewclass($classview)
            {
                global $conn;
                if (preg_match("/^[0-9]{1,2}$/", $classview)) {
            ?>
                    <table class="table table-striped table-dark">
                        <thead>
                            <th>Subject ID</th>
                            <th>Subject Name</th>
                        </thead>
                        <?php


                        $result = "SELECT * from class RIGHT JOIN subject ON class.subject_id = subject.subject_id where class_id='$classview';";
                        $result = mysqli_query($conn, $result);
                        while ($row = mysqli_fetch_assoc($result)) {
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
                    } else {
                        echo "<p>give a valid input</p>";
                    }
                }
                if (isset($_POST["classview"])) {
                    $classview = $_POST["classview"];
                    viewclass($classview);
                } else {
                    viewclass('1');
                }

                ?>

                    </table>
        </div>
        <?php include_once '../footer.php' ?>
    </body>

    </html>
<?php
}
?>