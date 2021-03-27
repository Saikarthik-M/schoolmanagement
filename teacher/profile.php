<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["username"])) {
    echo "unauthenticated";
} else {
    include_once '../databaseconnector.php';
    $username = $_SESSION["username"];
    $teacher_details = "SELECT * FROM teachers where rollno = '$username';";
    $teacher_details = mysqli_query($conn, $teacher_details);
    $row = mysqli_fetch_assoc($teacher_details);
?>
    <html>
    <?php include_once '../head.php' ?>

    <body>
        <?php include_once '../navigation.php' ?>
        <div class="container my-5">
            <h1 class="text-center">Teacher detail</h1>
            <div class="alert alert-success text-dark">
                <p>Username : <strong> <?php echo $row["name"] ?></strong></p>
                <p>Email : <strong> <?php echo $row["email"] ?> </strong></p>
                <p>Phone : <strong><?php echo $row["phone"] ?> </strong></p>
            </div>
            <?php
            $querypaid = "SELECT is_paid,month from salary where rollno = '$username';";
            $querypaid = mysqli_query($conn, $querypaid);
            $month = [];
            $is_paid = [];
            while ($row = mysqli_fetch_assoc($querypaid)) {
                $month[] = $row["month"];
                $is_paid[] = $row["is_paid"];
            }
            ?>
            <table class="table table-dark table-striped mt-5">
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

                    foreach ($is_paid as $paid) {
                    ?>
                        <td><?php echo $paid == '1' ? "Paid" :  "No"; ?></td>
                    <?php
                    }
                    ?>
                </tr>
            </table>
            <?php
            $query1 = mysqli_query($conn, "SELECT * from class where rollno='$username';");
            if (mysqli_num_rows($query1) == '0') {
            ?>
                <p>Not assigned for any classes</p>
            <?php
            } else {
            ?>
                <table class="table table-striped mt-5">
                    <thead>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Below 40</th>
                        <th>40 - 59</th>
                        <th>60 - 79</th>
                        <th>80 - 89</th>
                        <th>90 - 99</th>
                        <th>100</th>
                    </thead>

                    <?php
                    while ($row = mysqli_fetch_assoc($query1)) {
                        $class = $row["class_id"];
                        $section = $row["section"];
                        $subject = $row["subject_id"];
                        $query2 = mysqli_query($conn, "SELECT rollno from student where class='$class' and section='$section';");
                        $below40 = 0;
                        $from40to60 = 0;
                        $from60to80 = 0;
                        $from80to90 = 0;
                        $from90to99 = 0;
                        $centum = 0;
                        while ($row2 = mysqli_fetch_assoc($query2)) {
                            $studentnumber = $row2["rollno"];
                            $query3 = mysqli_query($conn, "SELECT * from mark where rollno='$studentnumber' and subject_id='$subject';");
                            $row3 = mysqli_fetch_assoc($query3);
                            $studentmark = $row3["quart_mark"];
                            if ($studentmark != 'N' && $studentmark != 'A') {
                                if ($studentmark < 40) {
                                    $below40++;
                                } else if ($studentmark >= 40 && $studentmark <= 59) {
                                    $from40to60++;
                                } else if ($studentmark >= 60 && $studentmark <= 79) {
                                    $from60to80++;
                                } else if ($studentmark >= 80 && $studentmark <= 89) {
                                    $from80to90++;
                                } else if ($studentmark >= 90 && $studentmark <= 99) {
                                    $from90to99++;
                                } else {
                                    $centum++;
                                }
                            }
                            $studentmark = $row3["half_mark"];
                            if ($studentmark != 'N' && $studentmark != 'A') {
                                if ($studentmark < 40) {
                                    $below40++;
                                } else if ($studentmark >= 40 && $studentmark <= 59) {
                                    $from40to60++;
                                } else if ($studentmark >= 60 && $studentmark <= 79) {
                                    $from60to80++;
                                } else if ($studentmark >= 80 && $studentmark <= 89) {
                                    $from80to90++;
                                } else if ($studentmark >= 90 && $studentmark <= 99) {
                                    $from90to99++;
                                } else {
                                    $centum++;
                                }
                            }
                            $studentmark = $row3["annual_mark"];
                            if ($studentmark != 'N' && $studentmark != 'A') {
                                if ($studentmark < 40) {
                                    $below40++;
                                } else if ($studentmark >= 40 && $studentmark <= 59) {
                                    $from40to60++;
                                } else if ($studentmark >= 60 && $studentmark <= 79) {
                                    $from60to80++;
                                } else if ($studentmark >= 80 && $studentmark <= 89) {
                                    $from80to90++;
                                } else if ($studentmark >= 90 && $studentmark <= 99) {
                                    $from90to99++;
                                } else {
                                    $centum++;
                                }
                            }
                        }
                    ?>
                        <tr>
                            <td><?php echo $class; ?></td>
                            <td><?php echo $section; ?></td>
                            <td><?php echo $below40; ?></td>
                            <td><?php echo $from40to60; ?></td>
                            <td><?php echo $from60to80; ?></td>
                            <td><?php echo $from80to90; ?></td>
                            <td><?php echo $from90to99; ?></td>
                            <td><?php echo $centum; ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
                </table>
        </div>
        </div>
    </body>

    </html>
<?php
}
?>