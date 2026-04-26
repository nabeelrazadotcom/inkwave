<?php
session_start();

if (empty($_SESSION['Loggedin'])) {
    header("Location: ../auth/login_form.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post — Inkwave</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="iw-dashboard">
    <div class="iw-dashboard-backdrop" aria-hidden="true">
        <div class="iw-dashboard-orb iw-dashboard-orb-a"></div>
        <div class="iw-dashboard-orb iw-dashboard-orb-b"></div>
        <div class="iw-dashboard-grid-glow"></div>
    </div>

    <div class="iw-dashboard-layout">
        <?php include '../includes/sidebar.php'; ?>
        <main class="iw-dashboard-main">
            <header class="iw-dash-header">
                <div class="iw-dash-header-left">
                    <div class="iw-dash-greeting">Editor</div>
                    <h1 class="iw-dash-title">Continue editing</h1>
                    <p class="iw-dash-subtitle">The full editing flow routes through the studio. This page now gives users a clean handoff instead of a broken blank state.</p>
                </div>
                <div class="iw-dash-header-right">
                    <a href="./create-post.php" class="btn btn-primary">Open Studio</a>
                </div>
            </header>

            <section class="iw-dash-section">
                <div class="iw-empty-state">
                    <div class="iw-empty-state-icon"><i class="bi bi-pencil-square"></i></div>
                    <h2 class="iw-empty-state-title">Use the writing studio</h2>
                    <p class="iw-empty-state-text">We replaced the incomplete editor view with a cleaner studio experience powered by Quill and a more consistent dashboard layout.</p>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
