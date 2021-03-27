<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["username"])) {
    echo "<h1>unauthenticated</h1>";
} else if (isset($_POST["name"])) {
    include_once '../databaseconnector.php';
    $name = $_POST["name"];
    $rollno = $_POST["rollno"];
    $rollno = strtoupper($rollno);
    $email = $_POST["email"];
    $address = $_POST["address"];
    $address = strip_tags($address);
    $address = stripslashes($address);
    $city = $_POST["city"];
    $district = $_POST["district"];
    $phone = $_POST["phone"];
    $dob = $_POST["dob"];
    $doj = $_POST["doj"];
    $subject = $_POST["subject"];
    $classteacher = $_POST["classteacher"];
    if (preg_match("/^[A-Z ]+$/", $name)) {
        if (preg_match("/^[A-Z0-9]+$/", $rollno)) {
            $rollno_check = "SELECT EXISTS(SELECT * from teachers where rollno='$rollno') as numbers;";
            $rollno_check = mysqli_query($conn, $rollno_check);
            $result = mysqli_fetch_assoc($rollno_check);
            if ($result["numbers"] == '0') {
                if (preg_match("/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/", $email)) {
                    if (preg_match_all("/^[0-9a-zA-Z \/,.]{2,50}$/m", $address)) {
                        if (preg_match("/^[0-9]{10}$/", $phone)) {
                            if (preg_match("/^[a-zA-Z,. ]+$/", $city)) {
                                if (preg_match("/^[a-zA-Z ]+$/", $district)) {
                                    if (preg_match("/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/", $doj)) {
                                        if (preg_match("/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/", $dob)) {
                                            if (preg_match("/^[0-9]{3}$/", $subject)) {
                                                if (preg_match("/^[IVX]+-[ABC]+$/", $classteacher) || $classteacher == "NULL") {
                                                    $hashed_rollno = password_hash($rollno, PASSWORD_DEFAULT);
                                                    $query = "INSERT INTO `teachers` (`name`, `rollno`, `email`, `password`, `address`, `city`, `district`, `phone`, `dob`, `date_of_joining`, `class_teacher`, `subject`) VALUES ('$name', '$rollno', '$email', '$hashed_rollno', '$address', '$city', '$district', '$phone', '$dob', '$doj', '$classteacher', '$subject');";
                                                    mysqli_query($conn, $query);
                                                    $query1 = "INSERT INTO teacherrecords(`rollno`) values('$rollno');";
                                                    mysqli_query($conn, $query1);
                                                    $url = htmlentities($_SERVER["PHP_SELF"]);
                                                    header("Location: $url?success=1");
                                                } else {
                                                    $url = htmlentities($_SERVER["PHP_SELF"]);
                                                    header("Location: $url?error=11&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&phone=" . urlencode($phone));
                                                }
                                            } else {
                                                $url = htmlentities($_SERVER["PHP_SELF"]);
                                                header("Location: $url?error=10&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&classteacher=" . urlencode($classteacher) . "&phone=" . urlencode($phone));
                                            }
                                        } else {
                                            $url = htmlentities($_SERVER["PHP_SELF"]);
                                            header("Location: $url?error=9&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher) . "&phone=" . urlencode($phone));
                                        }
                                    } else {
                                        $url = htmlentities($_SERVER["PHP_SELF"]);
                                        header("Location: $url?error=8&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher) . "&phone=" . urlencode($phone));
                                    }
                                } else {
                                    $url = htmlentities($_SERVER["PHP_SELF"]);
                                    header("Location: $url?error=7&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher) . "&phone=" . urlencode($phone));
                                }
                            } else {
                                $url = htmlentities($_SERVER["PHP_SELF"]);
                                header("Location: $url?error=6&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher) . "&phone=" . urlencode($phone));
                            }
                        } else {
                            $url = htmlentities($_SERVER["PHP_SELF"]);
                            header("Location: $url?error=1&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher));
                        }
                    } else {
                        $url = htmlentities($_SERVER["PHP_SELF"]);
                        header("Location: $url?error=2&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&phone=" . urlencode($phone) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher));
                    }
                } else {
                    $url = htmlentities($_SERVER["PHP_SELF"]);
                    header("Location: $url?error=3&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&phone=" . urlencode($phone) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher));
                }
            } else {
                $url = htmlentities($_SERVER["PHP_SELF"]);
                header("Location: $url?error=4&name=" . urlencode($name) . "&phone=" . urlencode($phone) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher));
            }
        } else {
            $url = htmlentities($_SERVER["PHP_SELF"]);
            header("Location: $url?error=4&name=" . urlencode($name) . "&phone=" . urlencode($phone) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher));
        }
    } else {
        $url = htmlentities($_SERVER["PHP_SELF"]);
        header("Location: $url?error=5&rollno=" . urlencode($rollno) . "&phone=" . urlencode($phone) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher));
    }
} else {
    include_once '../head.php';
    include_once '../navigation.php';

?>
    <html>

    <body>
        <div class="container">
            <h1 class="text-center">Fill the staff details</h1>
            <div class="jumbotron">
                <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="post">
                    <div class="form-group">
                        <label for="name">Name (in capital with initial at end)</label>
                        <input class="form-control" type="text" pattern="^[A-Z ]+$" name="name" id="name" value="<?php echo isset($_GET["name"]) ? $_GET["name"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '5') {
                        ?>
                            <p>Name is not in the right format</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="rollno">Roll No</label>
                        <input class="form-control" type="text" name="rollno" pattern="^[A-Za-z0-9]+$" id="rollno" value="<?php echo isset($_GET["rollno"]) ? $_GET["rollno"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '4') {
                        ?>
                            <p>Roll no is not in the right format or already exists</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email" id="email" value="<?php echo isset($_GET["email"]) ? $_GET["email"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '3') {
                        ?>
                            <p>Email is not in the right format</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="address">Address (within 50 letters including whitespace)</label>
                        <input class="form-control" type="text" name="address" id="address" pattern="^[0-9a-zA-Z \/,.]{2,50}$" value="<?php echo isset($_GET["address"]) ? $_GET["address"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '2') {
                        ?>
                            <p>Address is not in the right format</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <?php isset($_GET["city"]) ? $cityid = $_GET["city"] : $cityid = "129" ?>
                        <select name="city" id="city" class="form-control" required>
                            <?php
                            $citylist = ['Achankuttam', 'Adaiyakarunkulam', 'Aiyansingampatty', 'Aiyanthiruvaliswaram', 'Alangulam', 'Ambasamudram', 'Ayiraperi', 'Ayyanarkulam', 'Balapathiramapuram', 'Bramadesam', 'Cheranmahadevi', 'Gunaramanallur', 'Ilanji', 'Indra Nagar, Courtallam', 'K.pillaivalasai', 'Kadanganeri', 'Kaduvetti', 'Karisalpatty', 'Karuvantha', 'Kasimajorpuram', 'Kavalakuruchi', 'Keelakalangal', 'Keelaveeranam', 'Kidarakulam', 'Kodarankulam', 'Koniyoor', 'Kunnakudi', 'Kurichanpatty', 'Kurippankulam', 'Kuthukalvalasai', 'M.m.puram', 'Malayankulam', 'Mannarkoil', 'Maranthai', 'Marukalankulam', 'Mathalamparai', 'Mayamankuruchi', 'Melagaram', 'Melakalangal', 'Melapuliyur', 'Melaveeranam', 'Moolachi', 'N.krishnapuram', 'Nallur', 'Nannagaram, Courtallam', 'Naranapuram', 'Nettur', 'Padikkattupalli', 'Pattakuruchi', 'Pattapathu', 'Periyapillaivalasai', 'Piranoor', 'Pottal', 'Pudukudi', 'S.v.p.karadiudaippu', 'Sevalarkulam', 'Sillaripuravoo', 'Sivanthipuram', 'Subbihapuram', 'Sumaitherthanpuram', 'T.ariyanayagipuram', 'T.veeravanallur', 'Tenkasi', 'Tenkasi Vaikalpaalam', 'Thenpothai', 'Therkku Pappankulam', 'Thiruchittambalam', 'Thiruvirunthanpuli', 'Ulagankulam', 'Uthumalai', 'V. Kavalakuruchi', 'Vadakkukarukuruchi', 'Vadiyoor', 'Vagaikulam', 'Vairavikulam', 'Vallam', 'Vellanguli', 'Venkatarengapuram', 'Zamin Singampatty'];
                            foreach ($citylist as $val) {
                            ?>
                                <option value="<?php echo $val; ?>" <?php echo $cityid == $val ? "selected" : "" ?>><?php echo $val; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="district">District</label>
                        <?php isset($_GET["district"]) ? $districtid = $_GET["district"] : $districtid = "129" ?>
                        <select name="district" id="district" class="form-control" required>
                            <option value="Tirunelveli" <?php echo $districtid == "Tirunelveli" ? "selected" : "" ?>>Tirunelveli</option>
                            <option value="Tenkasi" <?php echo $districtid == "Tenkasi" ? "selected" : "" ?>>Tenkasi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone No</label>
                        <input class="form-control" type="text" name="phone" id="phone" pattern="^[0-9]{10}$" value="<?php echo isset($_GET["phone"]) ? $_GET["phone"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '1') {
                        ?>
                            <p>Phone number must be 10 digit number</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="dob">DOB</label>
                        <input class="form-control" type="date" name="dob" id="dob" value="<?php echo isset($_GET["dob"]) ? $_GET["dob"] : "" ?>" required>
                    </div>
                    <div>
                        <label for="doj">Date of joining</label>
                        <input class="form-control" type="date" name="doj" id="doj" value="<?php echo isset($_GET["doj"]) ? $_GET["doj"] : "" ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">subject</label>
                        <?php isset($_GET["subject"]) ? $subjectid = $_GET["subject"] : $subjectid = "a" ?>
                        <select id="subject" name="subject" class="form-control" required>
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
                    <div class="form-group">
                        <label for="classteacher">Class Teacher</label>
                        <?php isset($_GET["classteacher"]) ? $classteacherid = $_GET["classteacher"] : $classteacherid = "" ?>
                        <select id="classteacher" name="classteacher" class="form-control">
                            <option selected>NULL</option>
                            <?php
                            $class = ["I-A", "I-B", "I-C", "II-A", "II-B", "II-C", "III-A", "III-B", "III-C", "IV-A", "IV-B", "IV-C", "V-A", "V-B", "V-C", "VI-A", "VI-B", "VI-C", "VII-A", "VII-B", "VII-C", "IX-A", "IX-B", "IX-C", "X-A", "X-B", "X-C", "XI-A", "XI-B", "XI-C", "XII-A", "XII-B", "XII-C"];
                            foreach ($class as $sec) {
                            ?>
                                <option value="<?php echo $sec; ?>" <?php echo $classteacherid == $sec ? "selected" : "" ?>><?php echo $sec; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Add staff">
                    <h6 class="my-3">NOTE : Password will be the ROLL NUMBER (in caps) , staffs can change it anytime they want</h6>
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
                                Added staff successfully
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
        <?php include_once '../footer.php' ?>
    </body>

    </html>
<?php
}
?>