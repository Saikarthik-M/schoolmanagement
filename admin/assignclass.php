<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["username"])) {
    echo "<h1>unauthenticated</h1>";
} else if (isset($_POST["rollno"])) {
} else {
    include_once '../databaseconnector.php';
    include_once '../head.php';
    include_once '../navigation.php';
?>

    <body>
        <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="post">
            <div>
                <label for="class">Class</label>
                <?php isset($_GET["class"]) ? $classid = $_GET["class"] : $classid = "129" ?>
                <select id="class" name="class" required>
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
            <div>
                <label for="sec">Section</label>
                <?php isset($_GET["sec"]) ? $secid = $_GET["sec"] : $secid = "129" ?>
                <select id="sec" name="sec" required>
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
            <div>
                <label for="rollno">Roll No</label>
                <input type="text" name="rollno" pattern="^[A-Za-z0-9]+$" id="rollno" value="<?php echo isset($_GET["rollno"]) ? $_GET["rollno"] : "" ?>" required>
                <?php
                if (isset($_GET["error"]) && $_GET["error"] == '3') {
                ?>
                    <p>Roll no is not in the right format or already exists</p>
                <?php
                }
                ?>
            </div>
            <div>
                <label for="subject">subject</label>
                <?php isset($_GET["subject"]) ? $subjectid = $_GET["subject"] : $subjectid = "a" ?>
                <select id="subject" name="subject" required>
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
        </form>
        <label>Class - I</label>
        <table>
            <thead>
                <th>Section</th>
                <th>A</th>
                <th>B</th>
                <th>C</th>
            </thead>
            <tr>
                <td>Staff</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <script>

        </script>
    </body>
<?php
}
?>