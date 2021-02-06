<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["username"])) {
    echo "<h1>unauthenticated</h1>";
} else if (isset($_POST["personal"])) {
    include_once '../databaseconnector.php';
    $url = htmlentities($_SERVER["PHP_SELF"]);
    $name = $_POST["name"];
    $fathername = $_POST["fathername"];
    $mothername = $_POST["mothername"];
    $fatheroccupation = $_POST["fatheroccupation"];
    $motheroccupation = $_POST["motheroccupation"];
    $birthcertificatenumber = $_POST["birthcertificatenumber"];
    $rollno = $_SESSION["searchrollno"];
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
    $people = $_SESSION["searchpeople"];
    if (preg_match("/^[A-Z ]+$/", $name)) {
        if (preg_match("/^[A-Z ]+$/", $fathername)) {
            if (preg_match("/^[A-Z ]+$/", $mothername)) {
                if (preg_match("/^[a-zA-Z ]{1,30}$/", $fatheroccupation)) {
                    if (preg_match("/^[a-zA-Z ]{1,30}$/", $motheroccupation)) {
                        if (preg_match("/^[0-9]{1,}$/", $birthcertificatenumber)) {
                            $rollno_check = "SELECT EXISTS(SELECT * from student where rollno='$rollno') as numbers;";
                            $rollno_check = mysqli_query($conn, $rollno_check);
                            $result = mysqli_fetch_assoc($rollno_check);
                            if ($result["numbers"] == '1') {
                                if (preg_match_all("/^[0-9a-zA-Z \/,.]{2,50}$/m", $address)) {
                                    if (preg_match("/^[0-9]{10}$/", $fatherphone)) {
                                        if (preg_match("/^[0-9]{10}$/", $motherphone)) {
                                            if (preg_match("/^[0-9]{1,2}$/", $class)) {
                                                if (preg_match("/^[a-zA-Z,. ]+$/", $city)) {
                                                    if (preg_match("/^[a-zA-Z ]+$/", $district)) {
                                                        if (preg_match("/^[ABC]$/", $section)) {
                                                            if (preg_match("/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/", $dob)) {
                                                                $query = "UPDATE `student` SET `name`='$name',`rollno`='$rollno',`email`='$email',`address`='$address',`city`='$city',`district`='$district',`class`='$class',`section`='$section',`dob`='$dob',`birth_certificate_number`='$birthcertificatenumber',`father_name`='$fathername',`father_number`='$fatherphone',`father_occupation`='$fatheroccupation',`mother_name`='$mothername',`mother_number`='$motherphone',`mother_occupation`='$motheroccupation' WHERE rollno='$rollno';";
                                                                mysqli_query($conn, $query);
                                                                header("Location: $url?&success=1");
                                                            } else {
                                                                header("Location:$url?error=15&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&address=" . urlencode($address) . "&fatherphone=" . urlencode($fatherphone) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&motherphone=" . urlencode($motherphone) . "&platform=1");
                                                            }
                                                        } else {
                                                            header("Location:$url?error=14&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&address=" . urlencode($address) . "&fatherphone=" . urlencode($fatherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&motherphone=" . urlencode($motherphone) . "&platform=1");
                                                        }
                                                    } else {
                                                        header("Location:$url?error=13&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&address=" . urlencode($address) . "&fatherphone=" . urlencode($fatherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&motherphone=" . urlencode($motherphone) . "&platform=1");
                                                    }
                                                } else {
                                                    header("Location:$url?error=12&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&email=" . urlencode($email) . "&district=" . urlencode($district) . "&address=" . urlencode($address) . "&fatherphone=" . urlencode($fatherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&motherphone=" . urlencode($motherphone) . "&platform=1");
                                                }
                                            } else {
                                                header("Location:$url?error=11&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&address=" . urlencode($address) . "&fatherphone=" . urlencode($fatherphone) . "&dob=" . urlencode($dob) . "&sec=" . urlencode($section) . "&motherphone=" . urlencode($motherphone) . "&platform=1");
                                            }
                                        } else {
                                            header("Location: $url?error=10&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&address=" . urlencode($address) . "&fatherphone=" . urlencode($fatherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&platform=1");
                                        }
                                    } else {
                                        header("Location: $url?error=9&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&address=" . urlencode($address) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&platform=1");
                                    }
                                } else {
                                    header("Location: $url?error=8&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&platform=1");
                                }
                            } else {
                                header("Location: $url");
                            }
                        } else {
                            header("Location: $url?error=6&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&address=" . urlencode($address) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&platform=1");
                        }
                    } else {
                        header("Location: $url?error=5&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&address=" . urlencode($address) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&platform=1");
                    }
                } else {
                    header("Location: $url?error=4&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&address=" . urlencode($address) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&platform=1");
                }
            } else {
                header("Location: $url?error=3&name=" . urlencode($name) . "&fathername=" . urlencode($fathername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&address=" . urlencode($address) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&platform=1");
            }
        } else {
            header("Location: $url?error=2&name=" . urlencode($name) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&address=" . urlencode($address) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&platform=1");
        }
    } else {
        header("Location: $url?error=1&fathername=" . urlencode($fathername) . "&mothername=" . urlencode($mothername) . "&fatheroccupation=" . urlencode($fatheroccupation) . "&motheroccupation=" . urlencode($motheroccupation) . "&birthcertificatenumber=" . urlencode($birthcertificatenumber) . "&address=" . urlencode($address) . "&email=" . urlencode($email) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&fatherphone=" . urlencode($fatherphone) . "&motherphone=" . urlencode($motherphone) . "&dob=" . urlencode($dob) . "&class=" . urlencode($class) . "&sec=" . urlencode($section) . "&platform=1");
    }
} else if (isset($_POST["mark"])) {

    $url = htmlentities($_SERVER["PHP_SELF"]);
    include_once '../databaseconnector.php';
    $rollno = $_SESSION["searchrollno"];
    $people = $_SESSION["searchpeople"];
    $rollno_check = "SELECT EXISTS(SELECT * from student where rollno='$rollno') as numbers;";
    $rollno_check = mysqli_query($conn, $rollno_check);
    $result = mysqli_fetch_assoc($rollno_check);
    if ($result["numbers"] != '1') {
        header("Location: $url");
    }

    $checker_plag = 0;
    $params = "mark=E467asd";
    function markchecker($key, $data)
    {
        if (preg_match("/^[qha][0-9]{3}$/", $key)) {
            if (preg_match("/^[0-9]{1,3}$/", $data)) {
                if (intval($data) >= 0 && intval($data) <= 100) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }
    $platform_counter = 0;
    foreach ($_POST as $key => $data) {
        if ($data == "E467asd" && $key == "mark" && $platform_counter == 0) {
            $platform_counter++;
            continue;
        }
        if (markchecker($key, $data)) {
            $checker_plag = 1;
            continue;
        }
        $params = $params . "&" . $key . "=" . $data;
    }
    if ($checker_plag == 1) {
        header("Location: $url?error=1" . $params . "&platform=3");
    } else {
        foreach ($_POST as $key => $data) {
            if ($key[0] == "q") {
                $examterm = "quart_mark";
            } else if ($key[0] == "h") {
                $examterm = "half_mark";
            } else {
                $examterm = "annual_mark";
            }
            $subjectid = $key[1] . $key[2] . $key[3];
            $querymark = "UPDATE mark SET `$examterm`='$data' where rollno='$rollno' and subject_id='$subjectid';";
            mysqli_query($conn, $querymark);
        }
        header("Location: $url?success=3");
    }
} else if (isset($_POST["fees"])) {
    $url = htmlentities($_SERVER["PHP_SELF"]);
    include_once '../databaseconnector.php';
    $rollno = $_SESSION["searchrollno"];
    $people = $_SESSION["searchpeople"];
    $rollno_check = "SELECT EXISTS(SELECT * from student where rollno='$rollno') as numbers;";
    $rollno_check = mysqli_query($conn, $rollno_check);
    $result = mysqli_fetch_assoc($rollno_check);
    if ($result["numbers"] != '1') {
        header("Location: $url");
    }
    if (isset($_POST["term1"])) {
        $term1 = $_POST["term1"];
        $fees1 = $_POST["fees1"];
        $paiddate1 = $_POST["date1"];
    } else {
        $term1 = "0";
        $fees1 = "0";
        $paiddate1 = "0";
    }
    if (isset($_POST["term2"])) {
        $term2 = $_POST["term2"];
        $fees2 = $_POST["fees2"];
        $paiddate2 = $_POST["date2"];
    } else {
        $term2 = "0";
        $fees2 = "0";
        $paiddate2 = "0";
    }
    $fine = $_POST["fine"];
    function termandfees($term, $fees)
    {
        if ($term == "0" && $fees == "0") {
            return 1;
        } else if ($term != "0" && $fees != "0") {
            return 1;
        }
        return 0;
    }
    if ($term1 == "1" || $term1 == "0") {
        if (preg_match("/^[0-9]+$/", $fees1) && termandfees($term1, $fees1)) {
            if (preg_match("/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/", $paiddate1) || $paiddate1 == "0") {
                if ($term2 == "1" || $term2 == "0") {
                    if (preg_match("/^[0-9]+$/", $fees2) && termandfees($term2, $fees2)) {
                        if (preg_match("/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/", $paiddate2) || $paiddate2 == "0") {
                            if (preg_match("/^[0-9]+$/", $fine)) {
                                $queryfees = "UPDATE `fees` SET `term1`='$term1',`feespaid1`='$fees1',`paiddate1`='$paiddate1',`term2`='$term2',`feespaid2`='$fees2',`paiddate2`='$paiddate2',`fineamount`='$fine' WHERE rollno='$rollno';";
                                mysqli_query($conn, $queryfees);
                                header("Location: $url?rollno=" . urlencode($rollno) . "&people=student" . "&success=2");
                            } else {
                                header("Location: $url?term1=" . urlencode($term1) . "&term2=" . urlencode($term2) . "&fees1=" . urlencode($fees1) . "&fees2=" . urlencode($fees2) . "&date1=" . urlencode($paiddate1) . "&date2=" . urlencode($paiddate2) . "&people=" . urlencode($people) . "&rollno=" . urlencode($rollno) . "&platform=2");
                            }
                        } else {
                            header("Location: $url?term1=" . urlencode($term1) . "&term2=" . urlencode($term2) . "&fees1=" . urlencode($fees1) . "&fees2=" . urlencode($fees2) . "&date1=" . urlencode($paiddate1) . "&fine=" . urlencode($fine) . "&people=" . urlencode($people) . "&rollno=" . urlencode($rollno) . "&platform=2");
                        }
                    } else {
                        header("Location: $url?term1=" . urlencode($term1) . "&term2=" . urlencode($term2) . "&fees1=" . urlencode($fees1) . "&date1=" . urlencode($paiddate1) . "&date2=" . urlencode($paiddate2) . "&fine=" . urlencode($fine) . "&people=" . urlencode($people) . "&rollno=" . urlencode($rollno) . "&platform=2");
                    }
                } else {
                    header("Location: $url?term1=" . urlencode($term1) . "&fees1=" . urlencode($fees1) . "&fees2=" . urlencode($fees2) . "&date1=" . urlencode($paiddate1) . "&date2=" . urlencode($paiddate2) . "&fine=" . urlencode($fine) . "&people=" . urlencode($people) . "&rollno=" . urlencode($rollno) . "&platform=2");
                }
            } else {
                header("Location: $url?term1=" . urlencode($term1) . "&term2=" . urlencode($term2) . "&fees1=" . urlencode($fees1) . "&fees2=" . urlencode($fees2) . "&date2=" . urlencode($paiddate2) . "&fine=" . urlencode($fine) . "&people=" . urlencode($people) . "&rollno=" . urlencode($rollno) . "&platform=2");
            }
        } else {
            header("Location: $url?term1=" . urlencode($term1) . "&term2=" . urlencode($term2) . "&fees2=" . urlencode($fees2) . "&date1=" . urlencode($paiddate1) . "&date2=" . urlencode($paiddate2) . "&fine=" . urlencode($fine) . "&people=" . urlencode($people) . "&rollno=" . urlencode($rollno) . "&platform=2");
        }
    } else {
        header("Location: $url?term2=" . urlencode($term2) . "&fees1=" . urlencode($fees1) . "&fees2=" . urlencode($fees2) . "&date1=" . urlencode($paiddate1) . "&date2=" . urlencode($paiddate2) . "&fine=" . urlencode($fine) . "&people=" . urlencode($people) . "&platform=2");
    }
} else if (isset($_POST["staffpersonal"])) {
    $url = htmlentities($_SERVER["PHP_SELF"]);
    include_once '../databaseconnector.php';
    $rollno = $_SESSION["searchrollno"];
    $people = $_SESSION["searchpeople"];
    $rollno_check = "SELECT EXISTS(SELECT * from teachers where rollno='$rollno') as numbers;";
    $rollno_check = mysqli_query($conn, $rollno_check);
    $result = mysqli_fetch_assoc($rollno_check);
    if ($result["numbers"] != '1') {
        header("Location: $url");
    } else {
        $name = $_POST["name"];
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
            if (preg_match("/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/", $email)) {
                if (preg_match_all("/^[0-9a-zA-Z \/,.]{2,50}$/m", $address)) {
                    if (preg_match("/^[0-9]{10}$/", $phone)) {
                        if (preg_match("/^[a-zA-Z,. ]+$/", $city)) {
                            if (preg_match("/^[a-zA-Z ]+$/", $district)) {
                                if (preg_match("/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/", $doj)) {
                                    if (preg_match("/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/", $dob)) {
                                        if (preg_match("/^[0-9]{3}$/", $subject)) {
                                            if (preg_match("/^[IVX]+-[ABC]+$/", $classteacher) || $classteacher == "NULL") {
                                                $query = "UPDATE `teachers` SET `name`='$name',`email`='$email',`address`='$address',`city`='$city',`district`='$district',`phone`='$phone',`dob`='$dob',`date_of_joining`='$doj',`class_teacher`='$classteacher',`subject`='$subject' WHERE rollno='$rollno';";
                                                mysqli_query($conn, $query);
                                                header("Location: $url?success=1");
                                            } else {
                                                $url = htmlentities($_SERVER["PHP_SELF"]);
                                                header("Location: $url?error=11&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&phone=" . urlencode($phone) . "&platform=1");
                                            }
                                        } else {
                                            $url = htmlentities($_SERVER["PHP_SELF"]);
                                            header("Location: $url?error=10&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&classteacher=" . urlencode($classteacher) . "&phone=" . urlencode($phone) . "&platform=1");
                                        }
                                    } else {
                                        $url = htmlentities($_SERVER["PHP_SELF"]);
                                        header("Location: $url?error=9&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher) . "&phone=" . urlencode($phone) . "&platform=1");
                                    }
                                } else {
                                    $url = htmlentities($_SERVER["PHP_SELF"]);
                                    header("Location: $url?error=8&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher) . "&phone=" . urlencode($phone) . "&platform=1");
                                }
                            } else {
                                $url = htmlentities($_SERVER["PHP_SELF"]);
                                header("Location: $url?error=7&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher) . "&phone=" . urlencode($phone) . "&platform=1");
                            }
                        } else {
                            $url = htmlentities($_SERVER["PHP_SELF"]);
                            header("Location: $url?error=6&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher) . "&phone=" . urlencode($phone) . "&platform=1");
                        }
                    } else {
                        $url = htmlentities($_SERVER["PHP_SELF"]);
                        header("Location: $url?error=1&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher) . "&platform=1");
                    }
                } else {
                    $url = htmlentities($_SERVER["PHP_SELF"]);
                    header("Location: $url?error=2&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&email=" . urlencode($email) . "&phone=" . urlencode($phone) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher) . "&platform=1");
                }
            } else {
                $url = htmlentities($_SERVER["PHP_SELF"]);
                header("Location: $url?error=3&name=" . urlencode($name) . "&rollno=" . urlencode($rollno) . "&phone=" . urlencode($phone) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher) . "&platform=1");
            }
        } else {
            $url = htmlentities($_SERVER["PHP_SELF"]);
            header("Location: $url?error=5&rollno=" . urlencode($rollno) . "&phone=" . urlencode($phone) . "&email=" . urlencode($email) . "&address=" . urlencode($address) . "&city=" . urlencode($city) . "&district=" . urlencode($district) . "&dob=" . urlencode($dob) . "&doj=" . urlencode($doj) . "&subject=" . urlencode($subject) . "&classteacher=" . urlencode($classteacher) . "&platform=1");
        }
    }
} else if (isset($_POST["salary"])) {
    $url = htmlentities($_SERVER["PHP_SELF"]);
    include_once '../databaseconnector.php';
    $rollno = $_SESSION["searchrollno"];
    $rollno_check = "SELECT EXISTS(SELECT * from teachers where rollno='$rollno') as numbers;";
    $rollno_check = mysqli_query($conn, $rollno_check);
    $result = mysqli_fetch_assoc($rollno_check);
    if ($result["numbers"] != '1') {
        header("Location: $url");
    } else {
        if (isset($_POST["actualsalary"])) {
            $salary = $_POST["actualsalary"];
            if (preg_match("/^[0-9]+$/", $salary)) {
                $cps_amount = (10 / 100) * $salary;
                for ($i = 1; $i <= 12; $i++) {
                    $month = date('F', mktime(0, 0, 0, $i));
                    $query = "INSERT INTO `salary`(`rollno`, `month`, `actual_salary`, `cps_amount`) VALUES ('$rollno','$month','$salary','$cps_amount')";
                    mysqli_query($conn, $query);
                }
                mysqli_query($conn, "INSERT INTO cps(`rollno`) values('$rollno');");
                header("Location: $url?success=2");
            } else {
                header("Location: $url?error=1&platform=2");
            }
        } else if (isset($_POST["salarychange"])) {
            $salary = $_POST["salarychange"];
            $explosion = explode("-", $_POST["implementmonth"]);
            $monthcheck = isset($explosion[1]) ? ((intval($explosion[1]) >= 1 && intval($explosion[1]) <= 12)   ? intval($explosion[1]) : "error123") : "error123";
            if (preg_match("/^[0-9]+$/", $salary)) {
                if ($monthcheck != "error123") {
                    $cps_amount = (10 / 100) * $salary;
                    for ($i = $monthcheck; $i <= 12; $i++) {
                        $month = date('F', mktime(0, 0, 0, $i));
                        $query = "UPDATE `salary` SET `actual_salary`='$salary',`cps_amount`='$cps_amount' WHERE rollno='$rollno' and `month`='$month';";
                        mysqli_query($conn, $query);
                    }
                    $query = "UPDATE `salary` SET `salary_updated`= '0' where `salary_updated`='1' and `rollno`='$rollno';";
                    mysqli_query($conn, $query);
                    $month = date('F', mktime(0, 0, 0, $monthcheck));
                    $query = "UPDATE `salary` SET `salary_updated`= '1' where `month`='$month' and `rollno`='$rollno';";
                    mysqli_query($conn, $query);
                    header("Location: $url?success=2");
                } else {
                    header("Location: $url?error=2&platform=2&salarychange=" . urlencode($salary));
                }
            } else {
                header("Location: $url?error=1&platform=2");
            }
        } else if (isset($_POST["paidsalary"])) {
            $checker_plag = 0;
            $params = "paidsalary=he34loa21&salary=d8as2d292sdn";
            $platform_counter = 0;
            function paidchecker($key, $value)
            {
                $month_indicator = $key[0];
                $month = intval(substr($key, 1, 2));
                if ($month_indicator == 'm' && ($month >= 1 && $month <= 12)) {
                    if ($value == '1' || $value == '0') {
                        return FALSE;
                    }
                }
                return TRUE;
            }
            foreach ($_POST as $key => $value) {
                if (($value == "he34loa21" && $key = "paidsalary" && $platform_counter <= 1) || ($value == "d8as2d292sdn" && $key = "salary" && $platform_counter <= 1)) {
                    $platform_counter++;
                    continue;
                }
                if (paidchecker($key, $value)) {
                    $checker_plag = 1;
                    continue;
                }
                $params .= "&" . urlencode($key) . "=" . urlencode($value);
            }
            if ($checker_plag == 1) {
                header("Location: $url?error=3&" . $params . "&platform=2");
            } else {
                $platform_counter = 0;
                foreach ($_POST as $key => $value) {
                    if (($value == "he34loa21" && $key = "paidsalary" && $platform_counter <= 1) || ($value == "d8as2d292sdn" && $key = "salary" && $platform_counter <= 1)) {
                        $platform_counter++;
                        continue;
                    }
                    $month = intval(substr($key, 1, 2));
                    $month = date('F', mktime(0, 0, 0, $month));
                    $query = mysqli_query($conn, "SELECT `actual_salary`,`cps_amount`,`is_paid` from salary where rollno='$rollno' and month='$month';");
                    $row = mysqli_fetch_assoc($query);

                    if ($row["is_paid"] != $value) {

                        if ($value == '1') {
                            $amountpaid = floatval($row["actual_salary"]) - floatval($row["cps_amount"]);
                            $query = mysqli_query($conn, "UPDATE salary SET `amount_paid`='$amountpaid' , `is_paid`='1' where rollno='$rollno' and month='$month';");
                            $query = mysqli_query($conn, "SELECT cps from cps where rollno='$rollno';");
                            $current_cps = floatval(mysqli_fetch_assoc($query)["cps"]);
                            $new_cps = $current_cps + floatval($row["cps_amount"]);
                            $query = mysqli_query($conn, "UPDATE cps SET `cps`='$new_cps' where rollno='$rollno';");
                        } else {

                            $query = mysqli_query($conn, "UPDATE salary SET `amount_paid`='0' , `is_paid`='0' where rollno='$rollno' and month='$month';");
                            $query = mysqli_query($conn, "SELECT cps from cps where rollno='$rollno';");
                            $current_cps = floatval(mysqli_fetch_assoc($query)["cps"]);
                            $new_cps = $current_cps - floatval($row["cps_amount"]);
                            $query = mysqli_query($conn, "UPDATE cps SET `cps`='$new_cps' where rollno='$rollno';");
                        }
                    }
                }
                header("Location: $url?success=2");
            }
        }
    }
} else if (isset($_POST["people"]) || isset($_GET["success"]) || isset($_GET["platform"])) {
    $url = htmlentities($_SERVER["PHP_SELF"]);
    include_once '../databaseconnector.php';
    if (isset($_POST["people"])) {
        $rollno = $_POST["rollno"];
        $rollno = strtoupper($rollno);
        $people = $_POST["people"];
        if ($people == "student" || $people == "teachers") {
            if (preg_match("/^[a-z0-9]+$/i", $rollno)) {
                $rollno_check = "SELECT * from `$people` where rollno='$rollno'";
                $rollno_check = mysqli_query($conn, $rollno_check);
                if (mysqli_num_rows($rollno_check)) {
                    $_SESSION["searchrollno"] = $rollno;
                    $_SESSION["searchpeople"] = $people;
                } else {
                    $url = isset($_POST["prev"]) ? $_POST["prev"] : htmlentities($_SERVER["PHP_SELF"]);
                    header("Location: $url");
                }
            } else {
                $url = isset($_POST["prev"]) ? $_POST["prev"] : htmlentities($_SERVER["PHP_SELF"]);
                header("Location: $url");
            }
        } else {
            $url = isset($_POST["prev"]) ? $_POST["prev"] : htmlentities($_SERVER["PHP_SELF"]);
            header("Location: $url");
        }
    }
    if ($_SESSION["searchpeople"] == "student") {
        include_once '../head.php';
        include_once '../navigation.php';
        $rollno = $_SESSION["searchrollno"];
        $people = $_SESSION["searchpeople"];
        $rollno_check = "SELECT * from student where rollno='$rollno';";
        $rollno_check = mysqli_query($conn, $rollno_check);
        $result = mysqli_fetch_assoc($rollno_check);
        $fees_check = "SELECT * FROM fees where rollno='$rollno';";
        $fees_check = mysqli_query($conn, $fees_check);
        $result1 = mysqli_fetch_assoc($fees_check);
?>
        <div class="btn-group btn-group-lg">
            <button type="button" data-section="section1" class="btn btn-primary segmentedButton" onclick="showing('section1')" id="btn1">personal information</button>
            <button type="button" data-section="section2" class="btn btn-primary segmentedButton" onclick="showing('section2')" id="btn2">fees details</button>
            <button type="button" data-section="section3" class="btn btn-primary segmentedButton" onclick="showing('section3')" id="btn3">Mark register</button>
        </div>
        <p>Here is the entire detail of <?php echo $people . " " . $rollno; ?> </p>
        <div class="content-section col-md-9" id="section1">
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <label for="name">Name (in capital with initial at end)</label>
                    <input type="text" name="name" id="name" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["name"] : (isset($_GET["name"]) ? $_GET["name"] : "")); ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '1') {
                    ?>
                        <p>Name is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["email"] : (isset($_GET["email"]) ? $_GET["email"] : "")); ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '3') {
                    ?>
                        <p>Email is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="address">Address (within 50 letters including whitespace)</label>
                    <input type="text" name="address" id="address" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["address"] : (isset($_GET["address"]) ? $_GET["address"] : "")); ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '8') {
                    ?>
                        <p>Address is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="city">City</label>
                    <select name="city" id="city" required>
                        <?php
                        $citylist = ['Achankuttam', 'Adaiyakarunkulam', 'Aiyansingampatty', 'Aiyanthiruvaliswaram', 'Alangulam', 'Ambasamudram', 'Ayiraperi', 'Ayyanarkulam', 'Balapathiramapuram', 'Bramadesam', 'Cheranmahadevi', 'Gunaramanallur', 'Ilanji', 'Indra Nagar, Courtallam', 'K.pillaivalasai', 'Kadanganeri', 'Kaduvetti', 'Karisalpatty', 'Karuvantha', 'Kasimajorpuram', 'Kavalakuruchi', 'Keelakalangal', 'Keelaveeranam', 'Kidarakulam', 'Kodarankulam', 'Koniyoor', 'Kunnakudi', 'Kurichanpatty', 'Kurippankulam', 'Kuthukalvalasai', 'M.m.puram', 'Malayankulam', 'Mannarkoil', 'Maranthai', 'Marukalankulam', 'Mathalamparai', 'Mayamankuruchi', 'Melagaram', 'Melakalangal', 'Melapuliyur', 'Melaveeranam', 'Moolachi', 'N.krishnapuram', 'Nallur', 'Nannagaram, Courtallam', 'Naranapuram', 'Nettur', 'Padikkattupalli', 'Pattakuruchi', 'Pattapathu', 'Periyapillaivalasai', 'Piranoor', 'Pottal', 'Pudukudi', 'S.v.p.karadiudaippu', 'Sevalarkulam', 'Sillaripuravoo', 'Sivanthipuram', 'Subbihapuram', 'Sumaitherthanpuram', 'T.ariyanayagipuram', 'T.veeravanallur', 'Tenkasi', 'Tenkasi Vaikalpaalam', 'Thenpothai', 'Therkku Pappankulam', 'Thiruchittambalam', 'Thiruvirunthanpuli', 'Ulagankulam', 'Uthumalai', 'V. Kavalakuruchi', 'Vadakkukarukuruchi', 'Vadiyoor', 'Vagaikulam', 'Vairavikulam', 'Vallam', 'Vellanguli', 'Venkatarengapuram', 'Zamin Singampatty'];
                        foreach ($citylist as $val) {
                        ?>
                            <option value="<?php echo $val; ?>" <?php echo isset($_POST["people"]) || isset($_GET["success"]) ? ($result["city"] == $val ? "selected" : "") : (isset($_GET["city"]) ? ($_GET["city"] == $val ? "selected" : "") : ""); ?>><?php echo $val; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="district">District</label>
                    <select name="district" id="district" required>
                        <option value="Tirunelveli" <?php echo isset($_POST["people"]) || isset($_GET["success"]) ? ($result["district"] == "Tirunelveli" ? "selected" : "") : (isset($_GET["district"]) ? ($_GET["district"] == "Tirunelveli" ? "selected" : "") : ""); ?>>Tirunelveli</option>
                        <option value="Tenkasi" <?php echo isset($_POST["people"]) || isset($_GET["success"]) ? ($result["district"] == "Tenkasi" ? "selected" : "") : (isset($_GET["district"]) ? ($_GET["district"] == "Tenkasi" ? "selected" : "") : ""); ?>>Tenkasi</option>
                    </select>
                </div>

                <div>
                    <label for="dob">DOB</label>
                    <input type="date" name="dob" id="dob" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["dob"] : (isset($_GET["dob"]) ? $_GET["dob"] : "")); ?>" required>
                </div>
                <div>
                    <label for="class">Class</label>
                    <select id="class" name="class" required>
                        <?php
                        $class = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
                        for ($sec = 0; $sec < 12; $sec++) {
                        ?>
                            <option value="<?php echo $sec + 1; ?>" <?php echo isset($_POST["people"]) || isset($_GET["success"]) ? ($result["class"] == $sec + 1 ? "selected" : "") : (isset($_GET["class"]) ? ($_GET["class"] == $sec + 1 ? "selected" : "") : ""); ?>><?php echo $class[$sec]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="sec">Section</label>
                    <select id="sec" name="sec" required>
                        <?php
                        $section = ["A", "B", "C"];
                        foreach ($section as $sec) {
                        ?>
                            <option value="<?php echo $sec; ?>" <?php echo isset($_POST["people"]) || isset($_GET["success"]) ? ($result["section"] == $sec ? "selected" : "") : (isset($_GET["sec"]) ? ($_GET["sec"] == $sec ? "selected" : "") : ""); ?>><?php echo $sec; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="fathername">Father Name (in capital with initial at end)</label>
                    <input type="text" name="fathername" id="fathername" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["father_name"] : (isset($_GET["fathername"]) ? $_GET["fathername"] : "")); ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '2') {
                    ?>
                        <p>Father Name is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="mothername">Mother Name (in capital with initial at end)</label>
                    <input type="text" name="mothername" id="mothername" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["mother_name"] : (isset($_GET["mothername"]) ? $_GET["mothername"] : "")); ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '3') {
                    ?>
                        <p>Mother Name is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="fatherphone">Father phone no</label>
                    <input type="text" name="fatherphone" id="fatherphone" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["father_number"] : (isset($_GET["fatherphone"]) ? $_GET["fatherphone"] : "")); ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '9') {
                    ?>
                        <p>Phone number must be 10 digit number</p>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="motherphone">Mother phone no</label>
                    <input type="text" name="motherphone" id="motherphone" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["mother_number"] : (isset($_GET["motherphone"]) ? $_GET["motherphone"] : "")); ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '10') {
                    ?>
                        <p>Phone number must be 10 digit number</p>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="fatheroccupation">Father Occupation</label>
                    <input type="text" name="fatheroccupation" id="fatheroccupation" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["father_occupation"] : (isset($_GET["fatheroccupation"]) ? $_GET["fatheroccupation"] : "")); ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '4') {
                    ?>
                        <p>Father occupation is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="motheroccupation">Mother Occupation</label>
                    <input type="text" name="motheroccupation" id="motheroccupation" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["mother_occupation"] : (isset($_GET["motheroccupation"]) ? $_GET["motheroccupation"] : "")); ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '5') {
                    ?>
                        <p>Mother occupation is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="birthcertificatenumber">Birth Certificate Number</label>
                    <input type="text" name="birthcertificatenumber" id="birthcertificatenumber" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["birth_certificate_number"] : (isset($_GET["birthcertificatenumber"]) ? $_GET["birthcertificatenumber"] : "")); ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '6') {
                    ?>
                        <p>Birth Certificate Number is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <input type="hidden" name="personal" value="E5asd268">
                <input type="submit" value="Save changes">
            </form>
        </div>
        <div class="content-section" id="section2">
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="post">
                <div>
                    <label for="term1">Term 1</label>
                    <input type="checkbox" name="term1" id="term1" <?php echo ((isset($_POST["people"]) || isset($_GET["success"])) ? ($result1["term1"] == '1' ? "checked" : "") : (isset($_GET["term1"]) ? ($_GET["term1"] == '1' ? "checked" : "") : "")); ?> value="1">
                </div>
                <div>
                    <label for="fees1">Fees paid</label>
                    <input type="text" name="fees1" id="fees1" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result1["feespaid1"] : (isset($_GET["fees1"]) ? $_GET["fees1"] : "")) ?>">
                </div>
                <div>
                    <label for="date1">Paid on</label>
                    <input type="date" name="date1" id="date1" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result1["paiddate1"] : (isset($_GET["date1"]) ? $_GET["date1"] : "")) ?>">
                </div>
                <div>
                    <label for="term2">Term 2</label>
                    <input type="checkbox" name="term2" id="term2" <?php echo ((isset($_POST["people"]) || isset($_GET["success"])) ? ($result1["term2"] == '1' ? "checked" : "") : (isset($_GET["term2"]) ? ($_GET["term2"] == '1' ? "checked" : "") : "")); ?> value="1">
                </div>
                <div>
                    <label for="fees2">Fees paid</label>
                    <input type="text" name="fees2" id="fees2" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result1["feespaid2"] : (isset($_GET["fees2"]) ? $_GET["fees2"] : "")) ?>">
                </div>
                <div>
                    <label for="date2">Paid on</label>
                    <input type="date" name="date2" id="date2" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result1["paiddate2"] : (isset($_GET["date2"]) ? $_GET["date2"] : "")) ?>">
                </div>
                <div>
                    <label for="fine">Fine amount Balance</label>
                    <input type="text" name="fine" id="fine" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result1["fineamount"] : (isset($_GET["fine"]) ? $_GET["fine"] : "")) ?>">
                </div>
                <input type="hidden" name="fees" value="w234sd268">
                <input type="submit" value="save changes">
            </form>
        </div>
        <div class="content-section" id="section3">
            <?php echo isset($_GET["error"]) ? "<p>submission failed ! invalid details . pls check</p>" : ""; ?>
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="post">
                <table>
                    <?php
                    $querymark = "SELECT * from mark where rollno='$rollno';";
                    $querymark = mysqli_query($conn, $querymark);
                    $subject = [];
                    $quart = [];
                    $half = [];
                    $annual = [];
                    while ($row = mysqli_fetch_assoc($querymark)) {
                        array_push($subject, $row["subject_id"]);
                        array_push($quart, $row["quart_mark"]);
                        array_push($half, $row["half_mark"]);
                        array_push($annual, $row["annual_mark"]);
                    }
                    $subname = [];
                    foreach ($subject as $sub) {
                        $querysub = "SELECT subject_name from subject where subject_id='$sub';";
                        $querysub = mysqli_query($conn, $querysub);
                        $row = mysqli_fetch_assoc($querysub);
                        array_push($subname, $row["subject_name"]);
                    }

                    ?>
                    <thead>
                        <th>Term</th>
                        <?php
                        foreach ($subname as $sub) {
                        ?>
                            <th>
                                <?php echo $sub; ?>
                            </th>
                        <?php
                        }
                        ?>
                        <th>Total</th>
                    </thead>
                    <tr>
                        <td>Quartely</td>
                        <?php
                        $i = 0;
                        $total_q = 0;
                        foreach ($quart as $q) {
                        ?>
                            <td><input type="text" value="<?php echo isset($_GET["q" . $subject[$i]]) ? $_GET["q" . $subject[$i]] : $q; ?>" name="<?php echo "q" . $subject[$i]; ?>">
                            </td>
                        <?php
                            isset($_GET["q" . $subject[$i]]) ? $total_q += intval($_GET["q" . $subject[$i]]) : $total_q += intval($q);
                            $i++;
                        }
                        ?>
                        <td><?php echo $total_q; ?></td>
                    </tr>
                    <tr>
                        <td>Half-yearly</td>
                        <?php
                        $i = 0;
                        $total_h = 0;
                        foreach ($half as $q) {
                        ?>
                            <td><input type="text" value="<?php echo isset($_GET["h" . $subject[$i]]) ? $_GET["h" . $subject[$i]] : $q; ?>" name="<?php echo "h" . $subject[$i]; ?>">
                            </td>
                        <?php
                            isset($_GET["h" . $subject[$i]]) ? $total_h += intval($_GET["h" . $subject[$i]]) : $total_h += intval($q);
                            $i++;
                        }

                        ?>
                        <td><?php echo $total_h; ?></td>
                    </tr>
                    <tr>
                        <td>Annual</td>
                        <?php
                        $i = 0;
                        $total_a = 0;
                        foreach ($annual as $q) {
                        ?>
                            <td><input type="text" value="<?php echo isset($_GET["a" . $subject[$i]]) ? $_GET["a" . $subject[$i]] : $q; ?>" name="<?php echo "a" . $subject[$i]; ?>">
                            </td>
                        <?php
                            isset($_GET["a" . $subject[$i]]) ? $total_a += intval($_GET["a" . $subject[$i]]) : $total_a += intval($q);
                            $i++;
                        }
                        ?>
                        <td><?php echo $total_a; ?></td>
                    </tr>
                </table>
                <input type="hidden" name="mark" value="E467asd">
                <input type="submit" value="Change Values">
            </form>
        </div>

    <?php
    } else if ($_SESSION["searchpeople"] == "teachers") {
        include_once '../head.php';
        include_once '../navigation.php';
        $rollno = $_SESSION["searchrollno"];
        $people = $_SESSION["searchpeople"];
        $rollno_check = "SELECT * from teachers where rollno='$rollno';";
        $rollno_check = mysqli_query($conn, $rollno_check);
        $result = mysqli_fetch_assoc($rollno_check);
    ?>
        <div class="btn-group btn-group-lg">
            <button type="button" data-section="section1" class="btn btn-primary segmentedButton" onclick="showing('section1')" id="btn1">personal information</button>
            <button type="button" data-section="section2" class="btn btn-primary segmentedButton" onclick="showing('section2')" id="btn2">salary</button>
            <button type="button" data-section="section3" class="btn btn-primary segmentedButton" onclick="showing('section3')" id="btn3">pass/fail record</button>
        </div>
        <p>Here is the entire detail of <?php echo "teacher" . " " . $rollno; ?> </p>
        <div class="content-section col-md-9" id="section1">
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="staffpersonal" value="as3ena78">
                <div>
                    <label for="name">Name (in capital with initial at end)</label>
                    <input type="text" name="name" id="name" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["name"] : (isset($_GET["name"]) ? $_GET["name"] : "")); ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '5') {
                    ?>
                        <p>Name is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["email"] : (isset($_GET["email"]) ? $_GET["email"] : "")); ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '3') {
                    ?>
                        <p>Email is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="address">Address (within 50 letters including whitespace)</label>
                    <input type="text" name="address" id="address" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["address"] : (isset($_GET["address"]) ? $_GET["address"] : "")); ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '2') {
                    ?>
                        <p>Address is not in the right format</p>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="city">City</label>
                    <select name="city" id="city" required>
                        <?php
                        $citylist = ['Achankuttam', 'Adaiyakarunkulam', 'Aiyansingampatty', 'Aiyanthiruvaliswaram', 'Alangulam', 'Ambasamudram', 'Ayiraperi', 'Ayyanarkulam', 'Balapathiramapuram', 'Bramadesam', 'Cheranmahadevi', 'Gunaramanallur', 'Ilanji', 'Indra Nagar, Courtallam', 'K.pillaivalasai', 'Kadanganeri', 'Kaduvetti', 'Karisalpatty', 'Karuvantha', 'Kasimajorpuram', 'Kavalakuruchi', 'Keelakalangal', 'Keelaveeranam', 'Kidarakulam', 'Kodarankulam', 'Koniyoor', 'Kunnakudi', 'Kurichanpatty', 'Kurippankulam', 'Kuthukalvalasai', 'M.m.puram', 'Malayankulam', 'Mannarkoil', 'Maranthai', 'Marukalankulam', 'Mathalamparai', 'Mayamankuruchi', 'Melagaram', 'Melakalangal', 'Melapuliyur', 'Melaveeranam', 'Moolachi', 'N.krishnapuram', 'Nallur', 'Nannagaram, Courtallam', 'Naranapuram', 'Nettur', 'Padikkattupalli', 'Pattakuruchi', 'Pattapathu', 'Periyapillaivalasai', 'Piranoor', 'Pottal', 'Pudukudi', 'S.v.p.karadiudaippu', 'Sevalarkulam', 'Sillaripuravoo', 'Sivanthipuram', 'Subbihapuram', 'Sumaitherthanpuram', 'T.ariyanayagipuram', 'T.veeravanallur', 'Tenkasi', 'Tenkasi Vaikalpaalam', 'Thenpothai', 'Therkku Pappankulam', 'Thiruchittambalam', 'Thiruvirunthanpuli', 'Ulagankulam', 'Uthumalai', 'V. Kavalakuruchi', 'Vadakkukarukuruchi', 'Vadiyoor', 'Vagaikulam', 'Vairavikulam', 'Vallam', 'Vellanguli', 'Venkatarengapuram', 'Zamin Singampatty'];
                        foreach ($citylist as $val) {
                        ?>
                            <option value="<?php echo $val; ?>" <?php echo isset($_POST["people"]) || isset($_GET["success"]) ? ($result["city"] == $val ? "selected" : "") : (isset($_GET["city"]) ? ($_GET["city"] == $val ? "selected" : "") : ""); ?>><?php echo $val; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="district">District</label>
                    <select name="district" id="district" required>
                        <option value="Tirunelveli" <?php echo isset($_POST["people"]) || isset($_GET["success"]) ? ($result["district"] == "Tirunelveli" ? "selected" : "") : (isset($_GET["district"]) ? ($_GET["district"] == "Tirunelveli" ? "selected" : "") : ""); ?>>Tirunelveli</option>
                        <option value="Tenkasi" <?php echo isset($_POST["people"]) || isset($_GET["success"]) ? ($result["district"] == "Tenkasi" ? "selected" : "") : (isset($_GET["district"]) ? ($_GET["district"] == "Tenkasi" ? "selected" : "") : ""); ?>>Tenkasi</option>
                    </select>
                </div>
                <div>
                    <label for="phone">Phone no</label>
                    <input type="text" name="phone" id="phone" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["phone"] : (isset($_GET["phone"]) ? $_GET["phone"] : "")); ?>" required>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '1') {
                    ?>
                        <p>Phone number must be 10 digit number</p>
                    <?php
                    }
                    ?>
                </div>
                <div>
                    <label for="dob">DOB</label>
                    <input type="date" name="dob" id="dob" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["dob"] : (isset($_GET["dob"]) ? $_GET["dob"] : "")); ?>" required>
                </div>
                <div>
                    <label for="doj">Date of joining</label>
                    <input type="date" name="doj" id="doj" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"]) ? $result["date_of_joining"] : (isset($_GET["doj"]) ? $_GET["doj"] : "")); ?>" required>
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
                            <option value="<?php echo $row["subject_id"]; ?>" <?php echo ($subjectid == $row["subject_id"] ? "selected" : (isset($_POST["people"]) || isset($_GET["success"]) ? ($result["subject"] == $row["subject_id"] ? "selected" : "") : "")); ?>><?php echo $row["subject_name"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="classteacher">Class Teacher</label>
                    <?php isset($_GET["classteacher"]) ? $classteacherid = $_GET["classteacher"] : $classteacherid = "" ?>
                    <select id="classteacher" name="classteacher">
                        <option selected>NULL</option>
                        <?php
                        $class = ["I-A", "I-B", "I-C", "II-A", "II-B", "II-C", "III-A", "III-B", "III-C", "IV-A", "IV-B", "IV-C", "V-A", "V-B", "V-C", "VI-A", "VI-B", "VI-C", "VII-A", "VII-B", "VII-C", "IX-A", "IX-B", "IX-C", "X-A", "X-B", "X-C", "XI-A", "XI-B", "XI-C", "XII-A", "XII-B", "XII-C"];
                        foreach ($class as $sec) {
                        ?>
                            <option value="<?php echo $sec; ?>" <?php echo ($classteacherid == $sec ? "selected" : (isset($_POST["people"]) || isset($_GET["success"]) ? ($result["class_teacher"] == $sec ? "selected" : "") : "")); ?>><?php echo $sec; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <input type="submit" value="Save changes">
            </form>
        </div>
        <div class="content-section" id="section2">
            <?php
            $query1 = "SELECT * FROM salary where rollno='$rollno';";
            $query = mysqli_query($conn, $query1);
            if (mysqli_num_rows($query)) {
                $result1 = mysqli_fetch_assoc($query);
                $query1 = "SELECT * FROM salary where rollno='$rollno' and salary_updated='1';";
                $query = mysqli_query($conn, $query1);
                if (mysqli_num_rows($query)) {
                    $result1 = mysqli_fetch_assoc($query);
                }
                $query = mysqli_query($conn, "SELECT cps from cps where rollno='$rollno';");
                $cps = mysqli_fetch_assoc($query);
            ?>
                <p>Salary increment/decrement</p>
                <?php
                if (isset($_GET["error"]) && $_GET["error"] != '1') {
                ?>
                    <p>Invalid form filling !</p>
                <?php
                }
                ?>
                <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div>
                        <label for="salarychange">Salary</label>
                        <input type="text" name="salarychange" id="salary" value="<?php echo (isset($_POST["people"]) || isset($_GET["success"])) ? $result1["actual_salary"] : (isset($_GET["salarychange"]) ? $_GET["salarychange"] : "");  ?>" onkeyup="cpscreator(this.value)" required>
                    </div>
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == '1') {
                        echo "<p>Salary must be a valid number</p>";
                    }
                    ?>
                    <div>
                        <label for="implementmonth">Implementing month</label>
                        <input type="month" name="implementmonth" id="implementmonth">
                    </div>
                    <div>
                        <label for="cpscurrent">Current cps balance</label>
                        <input type="text" name="cpscurrent" id="cpscurrent" value="<?php echo $cps["cps"]; ?>" readonly>
                    </div>
                    <div>
                        <label for="cpsamount">current cps amount</label>
                        <input type="text" name="cpsamount" id="cpsamount" value="<?php echo $result1["cps_amount"]; ?>" readonly>
                    </div>
                    <input type="hidden" name="salary" value="asd425sws">
                    <input type="submit" value="Assign salary changes">
                </form>
                <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">
                    <?php
                    $querypaid = "SELECT is_paid,month from salary where rollno = '$rollno';";
                    $querypaid = mysqli_query($conn, $querypaid);
                    $month = [];
                    $is_paid = [];
                    while ($row = mysqli_fetch_assoc($querypaid)) {
                        $month[] = $row["month"];
                        $is_paid[] = $row["is_paid"];
                    }
                    ?>
                    <table>
                        <thead>
                            <th>Month</th>

                            <?php
                            foreach ($month as $mon) {
                            ?>
                                <th><?php echo $mon; ?></th>
                            <?php
                            }
                            ?>
                        </thead>
                        <tr>
                            <td>Paid</td>
                            <?php
                            $i = 1;
                            foreach ($is_paid as $paid) {
                            ?>
                                <td><input type="hidden" name="<?php echo 'm' . $i; ?>" value="0"><input type="checkbox" name="<?php echo 'm' . $i; ?>" value="1" <?php echo $paid == '1' ? "checked" : (isset($_GET['m' . $i]) ? $_GET['m' . $i] : ""); ?>></td>
                            <?php
                                $i++;
                            }
                            ?>
                        </tr>
                    </table>
                    <input type="hidden" name="paidsalary" value="he34loa21">
                    <input type="hidden" name="salary" value="d8as2d292sdn">
                    <input type="submit" value="update paid details">
                </form>

            <?php
            } else {
                if (isset($_GET["error"]) && $_GET["error"] = '1') {
                    echo "<p>Invalid salary</p>";
                }
            ?>

                <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div>
                        <label for="actualsalary">Actual Salary</label>
                        <input type="text" name="actualsalary" id="actualsalary">
                    </div>
                    <input type="hidden" name="salary" value="asd425sws">
                    <input type="submit" value="Assign Salary">
                </form>
            <?php
            }
            ?>
        </div>
        <div class="content-section" id="section3">
        </div>
    <?php
    }

    if (isset($_GET["success"])) {
    ?>
        <div class="toast" data-autohide=false>
            <div class="toast-header">
                <strong class="mr-auto text-success">Success</strong>
                <small class="text-muted">1 sec ago</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" id="btn">&times;</button>
            </div>
            <div class="toast-body">
                Changes done
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
    <style>
        .content-section {
            display: none;
        }
    </style>
    <script>
        function cpscreator(amount) {

            amount = parseInt(amount);
            if (!isNaN(amount)) {
                document.getElementById("cpsamount").value = amount * (10 / 100);
            } else {
                document.getElementById("cpsamount").value = 0;
            }
        }

        function showing(name) {
            $(".content-section").hide();
            $("#" + name).show();
        }
        var a = window.location.search.substr(1);
        if (a.search("success") != -1) {
            var b = a.search("success") + "success=".length;
            var c = (a.substring(b, b + 1));
            if (c.charCodeAt(0) >= 49 && c.charCodeAt(0) <= 51) {
                $("#btn" + c).trigger('click');
            } else {
                $("#btn1").trigger('click');
            }
        } else if (a.search("platform") != -1) {
            var b = a.search("platform") + "platform=".length;
            var c = (a.substring(b, b + 1));
            if (c.charCodeAt(0) >= 49 && c.charCodeAt(0) <= 51) {
                $("#btn" + c).trigger('click');
            } else {
                $("#btn1").trigger('click');
            }
        } else {
            $("#btn1").trigger('click');
        }
    </script>
<?php
} else {

?>

    <h1>no data available</h1>
<?php
}
?>