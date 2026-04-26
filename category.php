<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories — Inkwave</title>
    <link rel="icon" type="image/x-icon" href="./assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <main class="iw-page-shell container">
        <section class="iw-page-hero">
            <p class="iw-home-kicker">Browse by theme</p>
            <h1 class="iw-page-title">Categories that keep the reading experience structured.</h1>
            <p class="iw-page-copy">Even before backend content is wired in, this route now carries a complete layout instead of a blank page.</p>
        </section>
        <div class="row g-4">
            <div class="col-md-4"><article class="iw-surface-card"><h2>Culture</h2><p>Essays on media, taste, habits, and the way language shapes public life.</p></article></div>
            <div class="col-md-4"><article class="iw-surface-card"><h2>Writing</h2><p>Process notes, editorial thinking, creative discipline, and the realities of making drafts better.</p></article></div>
            <div class="col-md-4"><article class="iw-surface-card"><h2>Technology</h2><p>Interfaces, tools, and product decisions that affect how we read and publish.</p></article></div>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
