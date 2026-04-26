<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (!isset($_POST['title']) || empty($_POST['title'])) {
        $_SESSION['PostErr'] = "Give a clear title before continuing.";
        header("Location: ./create-post.php");
        exit();
    }

} else {
    $_SESSION['PostErr'] = "Something Went Wrong, Try Again.";
    header("Location: ./create-post.php");
    exit();
}
