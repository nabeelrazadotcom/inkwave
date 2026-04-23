<?php

session_start();


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Data Validation
    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $_SESSION['register_Err'] = "Enter Your Name...";
        header("Location: register_form.php");
        exit();
    } else if (!isset($_POST['username']) || empty($_POST['username'])) {
        $_SESSION['register_Err'] = "Enter Your Username...";
        header("Location: register_form.php");
        exit();
    } else if (!isset($_POST['email']) || empty($_POST['email'])) {
        $_SESSION['register_Err'] = "Enter Your Email...";
        header("Location: register_form.php");
        exit();
    } else if (!isset($_POST['password']) || empty($_POST['password'])) {
        $_SESSION['register_Err'] = "Enter Your Password...";
        header("Location: register_form.php");
        exit();
    } else if (!strlen($_POST['password']) >= 8) {
        $_SESSION['register_Err'] = "Atleast 8 Characters are Required in Password...";
        header("Location: register_form.php");
        exit();
    } else {

        // Fetching Form Data
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Connecting Database
        require_once "../config/db.php";
        if (isset($_SESSION['DatabaseError'])) {
            header("Location: Couldn't connect to Database.");
            exit();
        }

        // Storing Data into Database
        $stmt = mysqli_prepare($db_connect, "INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $username, $email, $password);

        if ($stmt->execute()) {
            $_SESSION['register_suc'] = "Your Account has been Created! Redirecting...";
            header("refresh: 2 url=register_form.php");
            $_SESSION['register_suc'] = "Login to Continue.";
            header("Location: login_form.php");
            exit();
        } else {
            $_SESSION['register_Err'] = "Couldn't Creat Your Account. Try Again.";
            header("Location: register_form.php");
            exit();
        }
    }

} else {
    $_SESSION['register_Err'] = "Something Went Wrong, Try Again.";
    header("Location: register_form.php");
    exit();
}