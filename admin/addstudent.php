<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["username"])) {
    echo "<h1>unauthenticated</h1>";
} else if (isset($_POST["name"])) {
    include_once '../databaseconnector.php';
    $name = $_POST["name"];
    $fathername = $_POST["fathername"];
    $mothername = $_POST["mothername"];
    $fatheroccupation = $_POST["fatheroccupation"];
    $motheroccupation = $_POST["motheroccupation"];
    $birthcertificatenumber = $_POST["birthcertificatenumber"];
    $rollno = $_POST["rollno"];
    $rollno = strtoupper($rollno);
    $email = $_POST["email"];
    $address = $_POST["address"];
    $address = strip_tags($address);
    $address = stripslashes($address);
    $city = $_POST["city"];
    $district = $_POST["district"];
    $fatherphone = $_POST["fatherphone"];
    $dob = $_POST["dob"];
    $motherphone = $_POST["motherphone"];
    $class = $_POST["class"];
    $section = $_POST["sec"];
    if (preg_match("/^[A-Z ]+$/", $name)) {
        if (preg_match("/^[A-Z ]+$/", $fathername)) {
            if (preg_match("/^[A-Z ]+$/", $mothername)) {
                if (preg_match("/^[a-zA-Z ]{1,30}$/", $fatheroccupation)) {
                    if (preg_match("/^[a-zA-Z ]{1,30}$/", $motheroccupation)) {
                        if (preg_match("/^[0-9]{1,}$/", $birthcertificatenumber)) {
                            if (preg_match("/^[A-Z0-9]+$/", $rollno)) {
                                $rollno_check = "SELECT EXISTS(SELECT * from student where rollno='$rollno') as numbers;";
                                $rollno_check = mysqli_query($conn, $rollno_check);
                                $result = mysqli_fetch_assoc($rollno_check);
                                if ($result["numbers"] == '0') {
                                    if (preg_match_all("/^[0-9a-zA-Z \/,.]{2,50}$/m", $address)) {
                                        if (preg_match("/^[0-9]{10}$/", $fatherphone)) {
                                            if (preg_match("/^[0-9]{10}$/", $motherphone)) {
                                                if (preg_match("/^[0-9]{1,2}$/", $class)) {
                                                    if (preg_match("/^[a-zA-Z,. ]+$/", $city)) {
                                                        if (preg_match("/^[a-zA-Z ]+$/", $district)) {
                                                            if (preg_match("/^[ABC]$/", $section)) {
                                                                if (preg_match("/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/", $dob)) {
                                                                    $query = "INSERT INTO `student` (`name`, `rollno`, `email`, `address`, `city`, `district`, `class`,`section`, `dob`, `birth_certificate_number`, `father_name`, `father_number`, `father_occupation`, `mother_name`, `mother_number`, `mother_occupation`) VALUES ('$name', '$rollno', '$email', '$address', '$city', '$district', '$class','$section', '$dob', '$birthcertificatenumber', '$fathername', '$fatherphone', '$fatheroccupation', '$mothername', '$motherphone', '$motheroccupation');";
                                                                    mysqli_query($conn, $query);
                                                                    $query2 = "INSERT INTO `fees` (`rollno`) VALUES ('$rollno');";
                                                                    mysqli_query($conn, $query2);
                                                                    $query3 = "SELECT subject_id from class where class_id='$class';";
                                                                    $subarray = mysqli_query($conn, $query3);
                                                                    while ($row = mysqli_fetch_array($subarray, MYSQLI_NUM)[0]) {
                                                                        $query4 = "INSERT into mark(`rollno`,`subject_id`) values('$rollno','$row');";
                                                                        mysqli_query($conn, $query4);
                                                                    }
                                                                    $url = htmlentities($_SERVER["PHP_SELF"]);
                                                                    header("Location: $url?success=1");
                                                                } else {
                                                                    $url = htmlentities($_SERVER["PHP_SELF"]);
                                                                    header("Location:$url?error=15&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&address=" . urlencode($address) . "&fatherphone=" . urlencode($fatherphone) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&motherphone=" . urlencode($motherphone));
                                                                }
                                                            } else {
                                                                $url = htmlentities($_SERVER["PHP_SELF"]);
                                                                header("Location:$url?error=14&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&address=" . urlencode($address) . "&fatherphone=" . urlencode($fatherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&motherphone=" . urlencode($motherphone));
                                                            }
                                                        } else {
                                                            $url = htmlentities($_SERVER["PHP_SELF"]);
                                                            header("Location:$url?error=13&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&address=" . urlencode($address) . "&fatherphone=" . urlencode($fatherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&motherphone=" . urlencode($motherphone));
                                                        }
                                                    } else {
                                                        $url = htmlentities($_SERVER["PHP_SELF"]);
                                                        header("Location:$url?error=12&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&district=" . urlencode($district) . "&address=" . urlencode($address) . "&fatherphone=" . urlencode($fatherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&motherphone=" . urlencode($motherphone));
                                                    }
                                                } else {
                                                    $url = htmlentities($_SERVER["PHP_SELF"]);
                                                    header("Location:$url?error=11&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&address=" . urlencode($address) . "&fatherphone=" . urlencode($fatherphone) . "&dob=" . urlencode($dob) . "&sec=" . urlencode($section) . "&motherphone=" . urlencode($motherphone));
                                                }
                                            } else {
                                                $url = htmlentities($_SERVER["PHP_SELF"]);
                                                header("Location: $url?error=10&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&address=" . urlencode($address) . "&fatherphone=" . urlencode($fatherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section));
                                            }
                                        } else {
                                            $url = htmlentities($_SERVER["PHP_SELF"]);
                                            header("Location: $url?error=9&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&address=" . urlencode($address) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section));
                                        }
                                    } else {
                                        $url = htmlentities($_SERVER["PHP_SELF"]);
                                        header("Location: $url?error=8&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section));
                                    }
                                } else {
                                    $url = htmlentities($_SERVER["PHP_SELF"]);
                                    header("Location: $url?error=7&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&address=" . urlencode($address) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section));
                                }
                            } else {
                                $url = htmlentities($_SERVER["PHP_SELF"]);
                                header("Location: $url?error=7&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&address=" . urlencode($address) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section));
                            }
                        } else {
                            $url = htmlentities($_SERVER["PHP_SELF"]);
                            header("Location: $url?error=6&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&rollno=" . urlencode($rollno) . "&address=" . urlencode($address) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section));
                        }
                    } else {
                        $url = htmlentities($_SERVER["PHP_SELF"]);
                        header("Location: $url?error=5&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&rollno=" . urlencode($rollno) . "&address=" . urlencode($address) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section));
                    }
                } else {
                    $url = htmlentities($_SERVER["PHP_SELF"]);
                    header("Location: $url?error=4&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&rollno=" . urlencode($rollno) . "&address=" . urlencode($address) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section));
                }
            } else {
                $url = htmlentities($_SERVER["PHP_SELF"]);
                header("Location: $url?error=3&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&rollno=" . urlencode($rollno) . "&address=" . urlencode($address) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section));
            }
        } else {
            $url = htmlentities($_SERVER["PHP_SELF"]);
            header("Location: $url?error=2&name=" . urlencode($name) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&rollno=" . urlencode($rollno) . "&address=" . urlencode($address) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section));
        }
    } else {
        $url = htmlentities($_SERVER["PHP_SELF"]);
        header("Location: $url?error=1&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&rollno=" . urlencode($rollno) . "&address=" . urlencode($address) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section));
    }
} else {
    include_once '../head.php';
    include_once '../navigation.php';

?>
    <html>

    <body>
        <div class="container mx-auto">
            <h1 class="text-center">Fill the student details</h1>
            <div class="jumbotron">
                <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="name">Name (in capital with initial at end)</label>
                        <input class="form-control" type="text" name="name" pattern="^[A-Z ]+$" id="name" value="<?php echo isset($_GET["name"]) ? $_GET["name"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '1') {
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
                        if (isset($_GET["error"]) && $_GET["error"] == '7') {
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
                        if (isset($_GET["error"]) && $_GET["error"] == '8') {
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
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '12') {
                        ?>
                            <p>city is not in the right format</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="district">District</label>
                        <?php isset($_GET["district"]) ? $districtid = $_GET["district"] : $districtid = "129" ?>
                        <select name="district" id="district" class="form-control" required>
                            <option value="Tirunelveli" <?php echo $districtid == "Tirunelveli" ? "selected" : "" ?>>Tirunelveli</option>
                            <option value="Tenkasi" <?php echo $districtid == "Tenkasi" ? "selected" : "" ?>>Tenkasi</option>
                        </select>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '13') {
                        ?>
                            <p>District is not in the right format</p>
                        <?php
                        }
                        ?>
                    </div>


                    <div class="form-group">
                        <label for="dob">DOB</label>
                        <input class="form-control" type="date" name="dob" id="dob" value="<?php echo isset($_GET["dob"]) ? $_GET["dob"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '15') {
                        ?>
                            <p>DOB is not in the right format</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="class">Class</label>
                        <?php isset($_GET["class"]) ? $classid = $_GET["class"] : $classid = "129" ?>
                        <select id="class" name="class" class="form-control" required>
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
                        if (isset($_GET["error"]) && $_GET["error"] == '11') {
                        ?>
                            <p>Class is not in the right format</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="sec">Section</label>
                        <?php isset($_GET["sec"]) ? $secid = $_GET["sec"] : $secid = "129" ?>
                        <select id="sec" name="sec" class="form-control" required>
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
                        if (isset($_GET["error"]) && $_GET["error"] == '14') {
                        ?>
                            <p>Section is not in the right format</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="fathername">Father Name (in capital with initial at end)</label>
                        <input class="form-control" type="text" name="fathername" pattern="^[A-Z ]+$" id="fathername" value="<?php echo isset($_GET["fathername"]) ? $_GET["fathername"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '2') {
                        ?>
                            <p>Father Name is not in the right format</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="mothername">Mother Name (in capital with initial at end)</label>
                        <input class="form-control" type="text" name="mothername" pattern="^[A-Z ]+$" id="mothername" value="<?php echo isset($_GET["mothername"]) ? $_GET["mothername"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '3') {
                        ?>
                            <p>Mother Name is not in the right format</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="fatherphone">Father phone no</label>
                        <input class="form-control" type="text" name="fatherphone" pattern="^[0-9]{10}$" id="fatherphone" value="<?php echo isset($_GET["fatherphone"]) ? $_GET["fatherphone"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '9') {
                        ?>
                            <p>Phone number must be 10 digit number</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="motherphone">Mother phone no</label>
                        <input class="form-control" type="text" name="motherphone" pattern="^[0-9]{10}$" id="motherphone" value="<?php echo isset($_GET["motherphone"]) ? $_GET["motherphone"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '10') {
                        ?>
                            <p>Phone number must be 10 digit number</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="fatheroccupation">Father Occupation</label>
                        <input class="form-control" type="text" name="fatheroccupation" pattern="^[a-zA-Z ]{1,30}$" id="fatheroccupation" value="<?php echo isset($_GET["fatheroccupation"]) ? $_GET["fatheroccupation"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '4') {
                        ?>
                            <p>Father occupation is not in the right format</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="motheroccupation">Mother Occupation</label>
                        <input class="form-control" type="text" name="motheroccupation" pattern="^[a-zA-Z ]{1,30}$" id="motheroccupation" value="<?php echo isset($_GET["motheroccupation"]) ? $_GET["motheroccupation"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '5') {
                        ?>
                            <p>Mother occupation is not in the right format</p>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="birthcertificatenumber">Birth Certificate Number</label>
                        <input class="form-control" type="text" name="birthcertificatenumber" pattern="^[0-9]{1,}$" id="birthcertificatenumber" value="<?php echo isset($_GET["birthcertificatenumber"]) ? $_GET["birthcertificatenumber"] : "" ?>" required>
                        <?php
                        if (isset($_GET["error"]) && $_GET["error"] == '6') {
                        ?>
                            <p>Birth Certificate Number is not in the right format</p>
                        <?php
                        }
                        ?>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Add student">
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
                                Added student successfully
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