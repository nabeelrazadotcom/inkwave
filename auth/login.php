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
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Connecting to Database
        require_once "../config/db.php";

        // Checking if Username is registered or not
        $stmt = mysqli_prepare($db_connect, "SELECT id, username, password FROM users WHERE username=? LIMIT 1");
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $user = $result ? $result->fetch_assoc() : null;

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['Loggedin'] = true;
                $_SESSION['user_id'] = (int) $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: ../dashboard/index.php");
                exit();

            } else {
                $_SESSION['Login_Err'] = "Incorrect username or password.";
                header("Location: ./login_form.php");
                exit();

            }
        } else {
            $_SESSION['Login_Err'] = "Something went wrong. Try again.";
            header("Location: ./login_form.php");
            exit();
            
        }
    }
}
