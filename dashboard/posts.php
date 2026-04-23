<?php

session_start();

if (empty($_SESSION['Loggedin'])) {
    header("Location: ../auth/login_form.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['id']) || empty($_GET['id']) || !ctype_digit($_GET['id'])) {
        $_SESSION['posts_Err'] = "ID not found.";
        header("Location: ./index.php");
        exit();
    }
    $id = $_GET['id'];
    // Connecting to Database
    require_once "../config/db.php";
    $stmt = mysqli_prepare($db_connect, "SELECT * FROM WHERE id=?");
    $stmt->bind_param("i", $id);
}
