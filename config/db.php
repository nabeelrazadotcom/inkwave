<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $db_connect = mysqli_connect("localhost", "root", '', "inkwave");
    if (!$db_connect) {
        throw new Exception("Couldn't connect to Database!");
    }
} catch (Exception $e) {
    $_SESSION['DatabaseError'] = "Coudn't connect to Database!";
}