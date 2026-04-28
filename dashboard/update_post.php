<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['PostErr'] = "Something went wrong. Try again.";
    header("Location: ./posts.php");
    exit();
}

$postId = isset($_POST['post_id']) ? (int) $_POST['post_id'] : 0;
$userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;
$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');
$categoryId = isset($_POST['category_id']) ? (int) $_POST['category_id'] : 0;
$status = ($_POST['status'] ?? 'draft') === 'publish' ? 'publish' : 'draft';
$imageName = null;
$imagePath = null;
$moveImage = false;

$_SESSION['edit_post_form_data'] = [
    'id' => $postId,
    'title' => $title,
    'content' => $content,
    'category_id' => $categoryId,
];

if ($userId <= 0 || $postId <= 0) {
    $_SESSION['PostErr'] = "We couldn't identify the post you want to update.";
    header("Location: ./posts.php");
    exit();
}

if ($title === '') {
    $_SESSION['PostErr'] = "Give a clear title before continuing.";
    header("Location: ./edit-post.php?id=" . $postId);
    exit();
}

if ($content === '') {
    $_SESSION['PostErr'] = "Your blog is empty. Write something before continuing.";
    header("Location: ./edit-post.php?id=" . $postId);
    exit();
}

if ($categoryId <= 0) {
    $_SESSION['PostErr'] = "Select a category for your story.";
    header("Location: ./edit-post.php?id=" . $postId);
    exit();
}

if (!isset($_FILES['banner'])) {
    $_SESSION['PostErr'] = "Image upload field is missing.";
    header("Location: ./edit-post.php?id=" . $postId);
    exit();
}

if (($_FILES['banner']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE && ($_FILES['banner']['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
    $_SESSION['PostErr'] = "Upload failed or the image is corrupted.";
    header("Location: ./edit-post.php?id=" . $postId);
    exit();
}

if (($_FILES['banner']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
    $imageName = time() . '_' . basename($_FILES['banner']['name']);
    $imagePath = $_FILES['banner']['tmp_name'];
    $imageSize = round($_FILES['banner']['size'] / 1000000, 2);

    if (@getimagesize($imagePath) === false) {
        $_SESSION['PostErr'] = "Invalid image file. Try another.";
        header("Location: ./edit-post.php?id=" . $postId);
        exit();
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['banner']['type'], $allowedTypes, true)) {
        $_SESSION['PostErr'] = "Image not supported. Use JPEG, PNG, or GIF.";
        header("Location: ./edit-post.php?id=" . $postId);
        exit();
    }

    if ($imageSize > 5) {
        $_SESSION['PostErr'] = "Image too large. It should be under 5 MB.";
        header("Location: ./edit-post.php?id=" . $postId);
        exit();
    }

    $moveImage = true;
}

require_once '../config/db.php';

$checkStmt = mysqli_prepare($db_connect, "SELECT image FROM posts WHERE id = ? AND user_id = ? LIMIT 1");
$checkStmt->bind_param("ii", $postId, $userId);
$checkStmt->execute();
$existingPost = $checkStmt->get_result()->fetch_assoc();

if (!$existingPost) {
    $_SESSION['PostErr'] = "That post could not be found.";
    header("Location: ./posts.php");
    exit();
}

$finalImage = $moveImage ? $imageName : ($existingPost['image'] ?? null);

$updateStmt = mysqli_prepare(
    $db_connect,
    "UPDATE posts SET title = ?, content = ?, category_id = ?, image = ?, status = ? WHERE id = ? AND user_id = ?"
);
$updateStmt->bind_param("ssissii", $title, $content, $categoryId, $finalImage, $status, $postId, $userId);

if ($updateStmt->execute()) {
    if ($moveImage) {
        move_uploaded_file($imagePath, '../uploads/posts/' . $imageName);
    }
    unset($_SESSION['edit_post_form_data']);
    $_SESSION['PostSucc'] = $status === 'publish' ? "Your story is live." : "Draft updated successfully.";
    header("Location: ./edit-post.php?id=" . $postId);
    exit();
}

$_SESSION['PostErr'] = "We couldn't save your changes. Please try again.";
header("Location: ./edit-post.php?id=" . $postId);
exit();
