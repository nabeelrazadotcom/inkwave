<?php
session_start();

if (!($_SESSION['Loggedin'])) {
    header("Location: ../auth/login_form.php");
    exit();
} 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inkwave — Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

    <!-- BACKGROUND -->
    <div class="background-flow"></div>

    
    <!-- TOP IDENTITY BAR -->
    <header class="topbar">
        <div class="brand-small">Inkwave</div>

        <div class="user-meta">
            <span class="username"><?= $_SESSION['username'] ?></span>
            <div class="avatar"></div>
        </div>
    </header>

    <!-- MAIN FEED -->
    <main class="feed-container">

        <!-- WRITING ENTRY PROMPT -->
        <section class="write-entry">
            <p class="prompt">What are you writing today?</p>
            <div class="fake-input">Start writing...</div>
        </section>

        <!-- CONTENT STREAM -->
        <article class="post">
            <h2>First Story Fragment</h2>
            <p>
                This is where writing flows like a continuous editorial stream.
                No boxes. No cards. Just text living in space.
            </p>
        </article>

        <article class="post">
            <h2>Another Thought</h2>
            <p>
                Inkwave treats every post as part of a single flowing manuscript.
            </p>
        </article>

    </main>

</body>

</html>