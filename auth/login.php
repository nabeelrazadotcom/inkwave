<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['username']) || empty($_POST['username'])) {
        $_SESSION['Login_Err'] = "Enter Your Username";
        header("Location: login_form.php");
        exit();
    } else if (!isset($_POST['password']) || empty($_POST['password'])) {
        $_SESSION['Login_Err'] = "Enter Your Password";
        header("Location: login_form.php");
        exit();
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Connecting to Database
        require_once "../config/db.php";
        // Checking if Username is registered or not
        $stmt = mysqli_prepare($db_connect, "SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            $data = $stmt->get_result()->num_rows;
            if ($data === 1) {
                $_SESSION['Loggedin'] = true;
                $_SESSION['username'] = $username;
                header("refresh:2 url=./login_form");
                header("Location: ../dashboard/index.php");
                exit();
            } else {
                $_SESSION['Login_Err'] = "Incorrect Username or Not Registered.";
                header("Location: ./login_form.php");
                exit();
            }
        }
    }
}
