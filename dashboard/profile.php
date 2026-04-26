<?php
session_start();

if (empty($_SESSION['Loggedin'])) {
    header("Location: ../auth/login_form.php");
    exit();
}

$username = $_SESSION['username'] ?? 'Writer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile — Inkwave</title>
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
                    <div class="iw-dash-greeting">Profile</div>
                    <h1 class="iw-dash-title">Public identity</h1>
                    <p class="iw-dash-subtitle">A clean profile card, your bio, and the metadata that supports your byline.</p>
                </div>
            </header>

            <div class="row g-4">
                <div class="col-lg-4">
                    <section class="iw-dash-section text-center">
                        <div class="iw-profile-avatar mx-auto mb-3"><?= htmlspecialchars(strtoupper(substr($username, 0, 1))) ?></div>
                        <h2 class="iw-dash-section-title mb-2"><?= htmlspecialchars($username) ?></h2>
                        <p class="iw-dash-subtitle mb-0">Essayist, observer, and steady publisher.</p>
                    </section>
                </div>
                <div class="col-lg-8">
                    <section class="iw-dash-section">
                        <div class="iw-dash-section-header">
                            <h2 class="iw-dash-section-title">Profile details</h2>
                        </div>
                        <div class="iw-status-list">
                            <div class="iw-status-row"><span class="iw-status-label">Display name</span><strong><?= htmlspecialchars($username) ?></strong></div>
                            <div class="iw-status-row"><span class="iw-status-label">Primary focus</span><strong>Long-form writing and thoughtful publishing</strong></div>
                            <div class="iw-status-row"><span class="iw-status-label">Bio</span><strong>Use this space to introduce your voice, expertise, and what readers can expect.</strong></div>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
