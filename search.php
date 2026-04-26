<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search — Inkwave</title>
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
            <p class="iw-home-kicker">Search</p>
            <h1 class="iw-page-title">Find essays, notes, and authors faster.</h1>
            <p class="iw-page-copy">This is now a designed search landing shell rather than an empty route.</p>
        </section>
        <section class="iw-surface-card">
            <div class="iw-table-filter">
                <i class="bi bi-search"></i>
                <input type="text" class="iw-studio-input" placeholder="Search by title, author, or category">
            </div>
            <div class="iw-search-results">
                <article class="iw-search-item">
                    <span class="iw-badge-soft is-success">Essay</span>
                    <h2>The architecture of attention in a feed-driven world</h2>
                    <p>A long-form piece on quiet interfaces, reading behavior, and digital depth.</p>
                </article>
                <article class="iw-search-item">
                    <span class="iw-badge-soft is-warning">Draft</span>
                    <h2>Why quiet interfaces produce better drafts</h2>
                    <p>A product-minded reflection on focus, visual hierarchy, and publishing systems.</p>
                </article>
            </div>
        </section>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
