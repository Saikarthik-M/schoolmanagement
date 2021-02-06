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
        <form action="" method="post">
            <div>
                <label for="class">Class</label>
                <?php isset($_POST["class"]) ? $clremove = $_POST["class"] : $clremove = "" ?>
                <select id="class" name="class" required>
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
            <input type="submit" value="Remove class course">
        </form>
        <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label for="class">Class</label>
                <?php isset($_POST["classview"]) ? $clview = $_POST["classview"] : $clview = "" ?>
                <select id="class" name="classview" onchange='this.form.submit();' required>
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
        </form>
        <?php
        if (isset($_POST["class"])) {
            $classremove = $_POST["class"];
            if (preg_match("/^[0-9]{1,2}$/", $classremove)) {
                $query3 = "DELETE FROM class where class_id = '$classremove';";
                mysqli_query($conn, $query3);
                $query4 = "SELECT rollno from student where class_id='$classremove';";
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
        }
        function viewclass($classview)
        {
            global $conn;
            if (preg_match("/^[0-9]{1,2}$/", $classview)) {
        ?>
                <table>
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
    </body>

    </html>
<?php
}
?>