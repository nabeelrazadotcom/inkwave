<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    // echo "<pre>";
    // print_r($_POST);
    // print_r($_FILES);
    // echo "</pre>";
    // exit();

    if (!isset($_POST['title']) || empty($_POST['title'])) {
        $_SESSION['PostErr'] = "Give a clear title before continuing.";
        header("Location: ./create-post.php");
        exit();
    } elseif (!isset($_POST['content']) || empty($_POST['content'])) {
        $_SESSION['PostErr'] = "Your blog is empty. Write something before continuing.";
        header("Location: ./create-post.php");
        exit();
    } elseif (!isset($_POST['category']) || empty($_POST['category'])) {
        $_SESSION['PostErr'] = "Select a category for your story.";
        header("Location: ./create-post.php");
        exit();
    } elseif (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
        $_SESSION['PostErr'] = "User information is missing. Please log in again.";
        header("Location: ./create-post.php");
        exit();
    } elseif (($_FILES['banner']['error'] !== UPLOAD_ERR_NO_FILE) && ($_FILES['banner']['error'] !== UPLOAD_ERR_OK)) {
        $_SESSION['PostErr'] = "Upload Failed OR Image is Corrupted.";
        header("Location: ./create-post.php");
        exit();
    } elseif ($_FILES['banner']['error'] === UPLOAD_ERR_OK) {
        // Get the file information
        $imageName = $_FILES['banner']['name'];
        $imagePath = $_FILES['banner']['tmp_name'];
        $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
        $imageSize = round($_FILES['banner']['size'] / 1000000, 2);

        // Check if the image is valid
        if (@getimagesize($_FILES['banner']['tmp_name']) === false) {
            $_SESSION['PostErr'] = "Invalid Image File. Try another.";
            header("Location: ./create-post.php");
            exit();
        } 

        // Check if the uploaded file is an image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['banner']['type'], $allowedTypes)) {
            if ($imageSize <= 5) {
                
            }
        } 

    }
    else {
        // Here you would typically handle the form submission,
        // such as saving the post to a database.

        // For demonstration, we'll just set a success message.
        $_SESSION['PostSucc'] = "Your story has been created successfully!";
        header("Location: ./create-post.php");
        exit();
    }
} else {
    $_SESSION['PostErr'] = "Something Went Wrong, Try Again.";
    header("Location: ./create-post.php");
    exit();
}
