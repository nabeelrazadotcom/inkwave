<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category — Inkwave</title>
    <link rel="icon" type="image/x-icon" href="./assets/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body class="iw-auth-login">

    <div class="iw-bg-flow" aria-hidden="true"></div>
    <div class="iw-bg-animated" aria-hidden="true"></div>

    <main class="container iw-auth-container py-5">
        <div class="row g-5 align-items-center min-vh-100 iw-auth-row">
            <section class="col-lg-6 iw-auth-welcome">
                <p class="iw-auth-kicker">Organize the stream</p>
                <h1>Define a new space for your ideas.</h1>
                <p class="iw-auth-brandline">Categories keep the reading experience structured and intentional.</p>
                <p class="iw-auth-brand">Ink<em>wave</em></p>

                <div class="iw-auth-notes" aria-hidden="true">
                    <div class="iw-auth-note">
                        <span class="iw-auth-note-label">Clear title</span>
                        <span class="iw-auth-note-value">Use familiar words instead of clever ones.</span>
                    </div>
                    <div class="iw-auth-note">
                        <span class="iw-auth-note-label">Focused scope</span>
                        <span class="iw-auth-note-value">Each category should hold a specific type of writing.</span>
                    </div>
                    <div class="iw-auth-note">
                        <span class="iw-auth-note-label">Readable</span>
                        <span class="iw-auth-note-value">Explain what belongs here in one calm paragraph.</span>
                    </div>
                </div>
            </section>

            <section class="col-lg-5 ms-lg-auto">
                <div class="iw-auth-panel">
                    <div class="iw-auth-panel-header">
                        <span class="iw-auth-panel-label">New category</span>
                        <h2 class="iw-auth-panel-title">Category details</h2>
                        <?php if (!empty($_SESSION['categoryErr'])): ?>

                            <div class="alert alert-warning d-flex px-2 py-1 gap-1 align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <div>
                                    <?= $_SESSION['categoryErr'];
                                    unset($_SESSION['categoryErr']); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($_SESSION['categorySucc'])): ?>
                            <div class="alert alert-success d-flex gap-1 px-2 py-1 align-items-center" role="alert">
                                <i class="bi bi-check-circle-fill"></i>
                                <div>
                                    <?= $_SESSION['categorySucc'];
                                    unset($_SESSION['categorySucc']); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <form class="iw-login-form" action="./addCategory.php" method="post">
                        <div class="iw-form-group">
                            <input class="iw-form-input" name="name" type="text" required>
                            <label class="iw-form-label">Category Name</label>
                        </div>

                        <div class="iw-form-group">
                            <textarea class="iw-form-input" name="description" rows="4" required></textarea>
                            <label class="iw-form-label">Description</label>
                        </div>

                        <button class="iw-btn-primary mb-3" type="submit">Create Category</button>

                        <p class="iw-auth-secondary">
                            Changed your mind? <a href="./index.php">Return to home</a>
                        </p>
                    </form>
                </div>
            </section>
        </div>
    </main>
    <script src="./assets/js/script.js"></script>
</body>

</html>