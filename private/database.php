<?php

// require_once('db_credentials.php');

function db_connect()
{
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    db_connect_confirm();
    return $connection;
}

function db_disconnect($connection)
{
    if (isset($connection)) {
        mysqli_close($connection);
    }
}

function db_connect_confirm()
{
    if (mysqli_connect_errno()) {
        $meessage = "Database connection faild: ";
        $meessage .= mysqli_connect_error();
        $meessage .= " (" . mysqli_connect_errno() . ")";
        echo $meessage;
        exit();
    }
}

function confirm_result_set($result)
{
    if (!$result) {
        exit("Database query wrong");
    }
}

function db_escape($db, $str)
{
    return mysqli_real_escape_string($db, $str);
}

?>