<?php
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION["username"])){
        echo "<h1>unauthenticated</h1>";
    }
    else if(isset($_POST["subid"])){
        include_once '../databaseconnector.php';
        $subid = $_POST["subid"];
        $subname = $_POST["subname"];
        if(preg_match("/^[0-9]{3}$/",$subid)){
            if(preg_match("/^[A-Z ]+$/",$subname)){
                $subject_id_checker = "SELECT EXISTS(SELECT subject_name FROM subject where subject_id='$subid') as numbers ;";
                $subject_id_checker = mysqli_query($conn,$subject_id_checker);
                $row = mysqli_fetch_assoc($subject_id_checker);
                if($row["numbers"]=='0'){
                    $subject_name_checker = "SELECT EXISTS(SELECT subject_id FROM subject where subject_name='$subname') as numbers ;";
                    $subject_name_checker = mysqli_query($conn,$subject_name_checker);
                    $row = mysqli_fetch_assoc($subject_name_checker);
                    if($row["numbers"]=='0'){
                        $query = "INSERT INTO `subject` (`subject_id`, `subject_name`) VALUES ('$subid', '$subname');";
                        mysqli_query($conn,$query);
                        $url = htmlentities($_SERVER["PHP_SELF"]);
                        header("Location: $url");
                    }
                    else{
                        $url = htmlentities($_SERVER["PHP_SELF"]);
                        header("Location: $url?error=1&subid=".urlencode($subid));
                    }
                }
                else{
                    $url = htmlentities($_SERVER["PHP_SELF"]);
                    header("Location: $url?error=1&subname".urlencode($subname));
                }
            }
            else{
                $url = htmlentities($_SERVER["PHP_SELF"]);
                header("Location: $url?error=2&subid=".urlencode($subid));
            }
        }
        else{
            $url = htmlentities($_SERVER["PHP_SELF"]);
            header("Location: $url?error=3&subname=".urlencode($subname));
        }
    }
    else{
        include_once '../head.php';
        include_once '../navigation.php';
        
?>
<html>
    <body>
        <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="post">
            <?php
                if(isset($_GET["error"])){
                    if($_GET["error"]=='1'){
                        echo "<p>Subject ID or subject name already exist.Please check below !</p>";
                    }
                    else if($_GET["error"]=='2'){
                        echo "<p>Subject name is not in the right format</p>";
                    }
                    else{
                       echo "<p>Subject ID is not in the right format</p>";
                    }
                }
            ?>
            <div>
                <label for="subid">Subject ID</label>
                <input type="text" name="subid" id="subid" pattern="^[0-9]{3}$" value="<?php echo isset($_GET["subid"])?$_GET["subid"]:""?>">
            </div>
            <div>
                <label for="subname">Subject name</label>
                <input type="text" name="subname" id="subname" pattern="^[A-Z ]+$" value="<?php echo isset($_GET["subname"])?$_GET["subname"]:""?>">
            </div>
            <input type="submit" value="Add Subject">
        </form>
        <div>
            <table>
                <thead>
                    <th>Subject ID</th>
                    <th>Subject name</th>
                </thead>
                <?php
                    include_once '../databaseconnector.php';
                    $queryresult1 = "SELECT * FROM subject";
                    $queryresult1 = mysqli_query($conn,$queryresult1);
                    while($row = mysqli_fetch_assoc($queryresult1)){
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
    </body>
</html>
<?php
    }
?>