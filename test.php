<?php
if (isset($_GET["mon"])) {
    include_once 'databaseconnector.php';
    $query = "SELECT * FROM teachers where rollno='18EUIT129';";
    $query = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($query);
    print_r($row);
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <input type="text" name="mon" id="" onkeyup="loaddoc(this.value)">
                <input type="text" name="sal" id="sal">
            </div>
        </form>
        <script>
            function loaddoc(str) {
                if (!(str >= 1 && str <= 12)) {

                    document.getElementById("sal").value = "";
                    return;
                }

                var obj = new XMLHttpRequest();
                obj.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("sal").value = this.responseText;
                    }
                };
                obj.open("GET", "test.php?mon=" + str, true);
                obj.send();
            }
        </script>
    </body>

    </html>
<?php
}
?>