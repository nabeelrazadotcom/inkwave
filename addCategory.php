<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $_SESSION['categoryErr'] = "Add a category name.";
        header("Location: ./category_form.php");
        exit;
    } else if (!isset($_POST['description']) || empty($_POST['description'])) {
        $_SESSION['categoryErr'] = "Add a category description.";
        header("Location: ./category_form.php");
        exit;
    } else if (str_word_count($_POST['description']) < 10) {
        $_SESSION['categoryErr'] = "Description must be at least 10 words.";
        header("Location: ./category_form.php");
        exit;
    } else {
        $name = trim($_POST['name']);
        $description = $_POST['description'];

        // Connecting Database
        require_once "./config/db.php";
        if (isset($_SESSION['DatabaseError'])) {
            $_SESSION['categoryErr'] = "Couldn't connect to Database.";
            header("Location: ./category_form.php");
            exit;
        } else {

            // Inserting Data
            $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
            $stmt = $db_connect->prepare($sql);
            $stmt->bind_param("ss", $name, $description);


            if ($stmt->execute()) {
                $_SESSION['categorySucc'] = "New Category Added Successfully. ($name)";
                header("Location: ./category_form.php");
                exit();
            } else {
                $_SESSION['categoryErr'] = "Error adding category.";
                header("Location: ./category_form.php");
                exit();
            }
        }
    }
} else {
    $_SESSION['categoryErr'] = "Something Went Wrong.";
    header("Location: ./category_form.php");
    exit();
}
