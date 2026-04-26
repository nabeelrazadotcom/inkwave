<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story — Inkwave</title>
    <link rel="icon" type="image/x-icon" href="./assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <main class="iw-page-shell container">
        <article class="iw-reading-shell mx-auto">
            <p class="iw-home-kicker">Featured reading</p>
            <h1 class="iw-page-title">The language we lose when we stop writing by hand</h1>
            <p class="iw-page-copy">This story template now has a polished reading layout and typography shell so the route no longer feels broken while backend content is still being connected.</p>
            <div class="iw-reading-meta">Elena Sorova · 8 min read · Essays</div>
            <div class="iw-reading-body">
                <p>Some interfaces make us faster. Others make us pay attention. The pen still belongs to the second kind.</p>
                <p>When friction enters the act of writing, thought can no longer sprint unchecked. It must choose. It must slow down enough to know what matters.</p>
                <blockquote>Good publishing design should never compete with the sentence. It should escort it.</blockquote>
                <p>That same principle applies to digital products. The best writing tools remove clutter, clarify hierarchy, and help the writer stay with the work.</p>
            </div>
        </article>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
