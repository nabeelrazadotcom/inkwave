<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $category_id = isset($_POST['category_id']) ? (int) $_POST['category_id'] : 0;
    $user_id = isset($_POST['user_id']) ? (int) $_POST['user_id'] : 0;
    $status = ($_POST['status'] ?? 'draft') === 'publish' ? 'publish' : 'draft';
    $imageName = null;
    $imagePath = null;
    $moveImage = false;

    $_SESSION['create_post_form_data'] = [
        'title' => $title,
        'content' => $content,
        'category_id' => $category_id,
    ];

    if ($title === '') {
        $_SESSION['PostErr'] = "Give a clear title before continuing.";
        header("Location: ./create-post.php");
        exit();
    } elseif ($content === '') {
        $_SESSION['PostErr'] = "Your blog is empty. Write something before continuing.";
        header("Location: ./create-post.php");
        exit();
    } elseif ($category_id <= 0) {
        $_SESSION['PostErr'] = "Select a category for your story.";
        header("Location: ./create-post.php");
        exit();
    } elseif ($user_id <= 0) {
        $_SESSION['PostErr'] = "User information is missing. Please log in again.";
        header("Location: ./create-post.php");
        exit();
    } elseif (!isset($_FILES['banner'])) {
        $_SESSION['PostErr'] = "Image upload field is missing.";
        header("Location: ./create-post.php");
        exit();
    } elseif (($_FILES['banner']['error'] !== UPLOAD_ERR_NO_FILE) && ($_FILES['banner']['error'] !== UPLOAD_ERR_OK)) {
        $_SESSION['PostErr'] = "Upload Failed OR Image is Corrupted.";
        header("Location: ./create-post.php");
        exit();
    } else {
        if ($_FILES['banner']['error'] === UPLOAD_ERR_OK) {
            // Get the file information
            $imageName = time() . '_' . $_FILES['banner']['name'];
            $imagePath = $_FILES['banner']['tmp_name'];
            $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
            $imageSize = round($_FILES['banner']['size'] / 1000000, 2);

            // Check if the image is valid
            if (@getimagesize($imagePath) === false) {
                $_SESSION['PostErr'] = "Invalid Image File. Try another.";
                header("Location: ./create-post.php");
                exit();
            }

            // Check if the uploaded file is an image and matches the size
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['banner']['type'], $allowedTypes)) {
                if ($imageSize <= 5) {
                    $moveImage = true;
                } else {
                    $_SESSION['PostErr'] = "Image Too Large. Should be < 5 MB";
                    header("Location: ./create-post.php");
                    exit();
                }
            } else {
                $_SESSION['PostErr'] = "Image Not Supported. Should only be JPEG, PNG, or GIF.";
                header("Location: ./create-post.php");
                exit();
            }
        }
        // Connecting Database
        require_once '../config/db.php';

        $stmt = mysqli_prepare($db_connect, "INSERT INTO posts (title, content, category_id, user_id, image, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiss", $title, $content, $category_id, $user_id, $imageName, $status);

        if ($stmt->execute()) {
            $_SESSION['PostSucc'] = "Your Post is successfully $status" . "ed!";
            unset($_SESSION['create_post_form_data']);
            if ($moveImage) {
                move_uploaded_file($imagePath, '../uploads/posts/' . $imageName);
            }
            header("Location: ./create-post.php");
            exit();
        } else {
            $_SESSION['PostErr'] = "Your Post didn't be saved, due to some Database issue.";
            header("Location: ./create-post.php");
            exit();
        }
    }
} else {
    $_SESSION['PostErr'] = "Something Went Wrong, Try Again.";
    header("Location: ./create-post.php");
    exit();
}
