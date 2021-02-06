<?php

include_once 'databaseconnector.php';
function cookie_generator($username)
{
    global $conn;
    $hashed_token = token_generator($username);
    setcookie("username", $username, time() + 2.628e+6);
    setcookie("token", $hashed_token, time() + 2.628e+6);
    $token_inserting_into_database = "INSERT INTO cookie(`token`,`username`) values('$hashed_token','$username');";
    mysqli_query($conn, $token_inserting_into_database);
}
function token_generator($username)
{
    return md5(strval(rand(100000, 999999)) . $username . strval(rand(10000, 99999)));
}
function cookie_verifier($username, $token)
{
    global $conn;
    $token_checking_in_db = "SELECT EXISTS(SELECT * FROM cookie where username='$username' and token='$token') as numbers;";
    $token_checking_in_db = mysqli_query($conn, $token_checking_in_db);
    $result = mysqli_fetch_assoc($token_checking_in_db);
    if ($result["numbers"] == '1') {
        return 1;
    }
    echo "helo";
    return 0;
}

function cookie_remover($username, $token)
{
    global $conn;
    $token_removing_in_db = "DELETE from cookie where username='$username' and token='$token';";
    mysqli_query($conn, $token_removing_in_db);
}
function old_cookie_remover($username)
{
    global $conn;
    $token_removing_in_db = "DELETE from cookie where username='$username';";
    mysqli_query($conn, $token_removing_in_db);
}
