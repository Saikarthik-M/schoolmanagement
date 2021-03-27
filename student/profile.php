<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["username"])) {
    echo "unauthenticated";
} else {
    include_once '../databaseconnector.php';
    $username = $_SESSION["username"];
    $student_details = "SELECT * FROM student where rollno = '$username';";
    $student_details = mysqli_query($conn, $student_details);
    $row = mysqli_fetch_assoc($student_details);
?>

    <?php include_once '../head.php' ?>

    <body>
        <?php include_once '../navigation.php' ?>
        <div class="container mx-auto mt-3">
            <h1 class="text-center">Student detail</h1>
            <div class="alert alert-success">
                <p>Username : <strong> <?php echo $row["name"] ?></strong></p>
                <p>Email : <strong> <?php echo $row["email"] ?> </strong></p>
                <p>Phone : <strong><?php echo $row["father_number"] ?> </strong></p>
            </div>
            <table class="table table-striped mt-5">
                <?php
                $rollno = $row["rollno"];
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

                    $total_q = 0;
                    foreach ($quart as $q) {
                    ?>
                        <td><?php echo $q; ?>
                        </td>
                    <?php
                        $total_q += intval($q);
                    }
                    ?>
                    <td><?php echo $total_q; ?></td>
                </tr>
                <tr>
                    <td>Half-yearly</td>
                    <?php
                    $total_h = 0;
                    foreach ($half as $q) {
                    ?>
                        <td><?php echo $q; ?>
                        </td>
                    <?php
                        $total_h += intval($q);
                    }

                    ?>
                    <td><?php echo $total_h; ?></td>
                </tr>
                <tr>
                    <td>Annual</td>
                    <?php
                    $total_a = 0;
                    foreach ($annual as $q) {
                    ?>
                        <td><?php echo $q; ?>
                        </td>
                    <?php
                        $total_a += intval($q);
                    }
                    ?>
                    <td><?php echo $total_a; ?></td>
                </tr>
            </table>
            <table class="table table-striped table-dark mt-5">
                <?php
                $feesdetails = mysqli_query($conn, "SELECT * from fees where rollno='$rollno';");
                $row = mysqli_fetch_assoc($feesdetails);
                ?>
                <thead>
                    <th>Term 1 Paid/No</th>
                    <th>Term 1 Amount</th>
                    <th>Paid Date</th>
                    <th>Term 2 Paid/No</th>
                    <th>Term 2 Amount</th>
                    <th>Paid Date</th>
                    <th>Fine Amount Balance</th>
                </thead>
                <tr>
                    <td><?php echo $row['term1'] == 1 ? "Paid" : "No"; ?></td>
                    <td><?php echo $row['feespaid1']; ?></td>
                    <td><?php echo $row['paiddate1']; ?></td>
                    <td><?php echo $row['term2'] == 1 ? "Paid" : "No"; ?></td>
                    <td><?php echo $row['feespaid2']; ?></td>
                    <td><?php echo $row['paiddate2']; ?></td>
                    <td><?php echo $row['fineamount']; ?></td>
                </tr>
            </table>
        </div>
        <?php include_once '../footer.php' ?>
    </body>
<?php
}
?>