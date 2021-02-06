<?php
include_once '../head.php';
include_once '../databaseconnector.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["username"])) {
    echo "<h1>unauthenticated</h1>";
} else if (isset($_POST["no"])) {

    $no = $_POST["no"];
    $class = $_POST["class"];
    if (preg_match("/^[0-9]+$/", $no)) {
        if (preg_match("/^[0-9]{1,2}$/", $class)) {
            $params = "&no=" . $no . "&class=" . $class;
            $check = 0;
            for ($i = 0; $i < intval($no); $i++) {
                $subject = $_POST["subject" . $i];
                if (!preg_match("/^[0-9]{3}$/", $subject)) {
                    $check = 1;
                    continue;
                }
                $params .= "&subject" . $i . "=" . $subject;
            }
            if ($check == 1) {
                $url = htmlentities($_SERVER["PHP_SELF"]);
                header("Location: $url?error=2" . $params);
            } else {
                $params = "&no=" . $no . "&class=" . $class;
                $check = 0;
                for ($i = 0; $i < intval($no); $i++) {
                    $subject = $_POST["subject" . $i];
                    if (subject_exists_in_class($subject, $class) == '1' || subject_exists($subject) == '0') {
                        $check = 1;
                        continue;
                    }
                    $params .= "&subject" . $i . "=" . $subject;
                }
                if ($check == 1) {
                    $url = htmlentities($_SERVER["PHP_SELF"]);
                    header("Location: $url?error=2" . $params);
                } else {
                    $query0 = "SELECT rollno from student where class='$class';";
                    $query0 = mysqli_query($conn, $query0);
                    if ($query0) {
                        while ($result = mysqli_fetch_assoc($query0)["rollno"]) {
                            for ($k = 0; $k < intval($no); $k++) {
                                $subject = $_POST["subject" . $k];
                                $query1 = "INSERT INTO mark(`rollno`,`subject_id`) values('$result','$subject');";
                                mysqli_query($conn, $query1);
                            }
                        }
                        for ($k = 0; $k < intval($no); $k++) {
                            $subject = $_POST["subject" . $k];
                            $query = "INSERT INTO class(`class_id`,`subject_id`) values('$class','$subject');";
                            mysqli_query($conn, $query);
                        }
                    } else {
                        for ($k = 0; $k < intval($no); $k++) {
                            $subject = $_POST["subject" . $k];
                            $query = "INSERT INTO class(`class_id`,`subject_id`) values('$class','$subject');";
                            mysqli_query($conn, $query);
                        }
                    }

                    $url = htmlentities($_SERVER["PHP_SELF"]);
                    header("Location: $url?classnumber=" . urlencode($class));
                }
            }
        } else {
            $url = htmlentities($_SERVER["PHP_SELF"]);
            header("Location: $url?error=1");
        }
    } else {
        $url = htmlentities($_SERVER["PHP_SELF"]);
        header("Location: $url?error=1");
    }
} else {

    include_once '../navigation.php';
?>
    <html>

    <body onload="fieldcreator()">
        <?php
        if (isset($_GET["error"])) {
            echo "<p>Give proper input</p>";
        }
        ?>
        <div class="row">
            <div class="col">
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
                    </div>
                    <div>
                        <label for="no">No of Subjects</label>
                        <input type="text" name="no" id="myText" pattern="^[0-9]+$" value="<?php echo isset($_GET["no"]) ? $_GET["no"] : "" ?>" onkeyup="fieldcreator()">
                    </div>
                    <div id="field">

                    </div>
                    <input type="submit" value="Assign">
                </form>
            </div>
            <script>
                function fieldcreator() {
                    var valuee = document.getElementById("myText").value;
                    var checker = 0;
                    for (var j = 0; j < valuee.length; j++) {
                        var k = valuee.charCodeAt(j);
                        if (k < 48 || k > 57) {
                            checker = 1;
                            break;
                        }
                    }
                    if (checker == 0) {
                        var a = parseInt(valuee);
                        document.getElementById("field").innerHTML = "";
                        var url = window.location.href;
                        url = url.split("?")[1];

                        if (url == undefined) {
                            for (var i = 0; i < a; i++) {
                                document.getElementById("field").innerHTML += "<div><label for='subject" + i + "'>Subject " + (i + 1) + " id </label><input type='text' name='subject" + i + "' pattern = '^[0-9]{3}$' id='subject" + i + "' required >" + "</div>";
                            }
                        } else {
                            for (var i = 0; i < a; i++) {
                                var reg = new RegExp("^[a-z=0-9&]*(subject" + i + "+=[0-9a-zA-Z]+)[a-z=0-9&]*$");
                                var val = url.match(reg);
                                if (val) {
                                    val = val[1];
                                    val = val.split("=", 2)[1];
                                    document.getElementById("field").innerHTML += "<div><label for='subject" + i + "'>Subject " + (i + 1) + " id </label><input type='text' name='subject" + i + "' pattern = '^[0-9]{3}$' id='subject" + i + "' value='" + val + "'required >" + "</div>";
                                } else {
                                    document.getElementById("field").innerHTML += "<div><label for='subject" + i + "'>Subject " + (i + 1) + " id </label><input type='text' name='subject" + i + "' pattern = '^[0-9]{3}$' id='subject" + i + "'required >" + "</div>";
                                }
                            }
                        }
                    } else {
                        document.getElementById("field").innerHTML = "";
                    }

                }
            </script>
            <div class="col">
                <table>
                    <thead>
                        <th>Subject ID</th>
                        <th>Subject name</th>
                    </thead>
                    <?php

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
                <?php
                if (isset($_GET["classnumber"])) {
                    $class = $_GET["classnumber"];
                    if (preg_match("/^[0-9]{1,2}$/", $class)) {
                ?>
                        <script>
                            $(document).ready(function() {
                                $("#myModal").modal();
                            });
                        </script>
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog model-dialog-centered model-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6>class : <?php echo $class ?></h6>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <table>
                                            <thead>
                                                <th>Subject ID</th>
                                                <th>Subject Name</th>
                                            </thead>
                                            <?php
                                            $result = "SELECT * from class RIGHT JOIN subject ON class.subject_id = subject.subject_id where class_id='$class';";
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
                                            ?>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </body>

    </html>
<?php
}
function subject_exists_in_class($subject, $class)
{
    global $conn;
    $query = "SELECT EXISTS(SELECT subject_id from class where subject_id='$subject' and class_id='$class') as numbers;";
    $query = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($query);
    return $row["numbers"];
}
function subject_exists($subject)
{
    global $conn;
    $query = "SELECT EXISTS(SELECT subject_name from subject where subject_id='$subject') as numbers;";
    $query = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($query);
    return $row["numbers"];
}
?>