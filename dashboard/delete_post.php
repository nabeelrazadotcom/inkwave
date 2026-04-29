<?php

session_start();

if (empty($_SESSION['Loggedin'])) {
    header("Location: ../auth/login_form.php");
    exit();
}

require_once '../config/db.php';


$postId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($postId <= 0) {
    $_SESSION['PostErr'] = "Choose a post to delete first.";
    header("Location: ./posts.php");
    exit();
}

$deleteStmt = mysqli_prepare(
    $db_connect,
    "DELETE FROM `posts` WHERE id = ?"
);
$deleteStmt->bind_param("i", $postId);

if ($deleteStmt->execute()) {
    $_SESSION['PostErr'] = "Post Deleted Successfully.";
    header("Location: ./posts.php");
    exit();
} 

$_SESSION['PostErr'] = "Your post couldn't be deleted. Try Again!";
header("Location: ./posts.php");
exit();