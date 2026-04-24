<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inkwave - Welcome Back</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="iw-auth-login">

    <div class="background"></div>

    <main class="container iw-auth-container py-5">
        <div class="row g-5 align-items-center min-vh-100 iw-auth-row">
            <!-- Welcome Section -->
            <section class="col-lg-6 iw-auth-welcome">
                <p class="iw-auth-kicker">Return to the page</p>
                <h1>Welcome back.</h1>
                <p class="iw-auth-brandline">A quieter desk, cleaner rhythm, and your unfinished sentences waiting exactly where you left them.</p>
                <p class="iw-auth-brand">Ink<em>wave</em></p>

                <div class="iw-auth-notes" aria-hidden="true">
                    <div class="iw-auth-note">
                        <span class="iw-auth-note-label">Desk</span>
                        <span class="iw-auth-note-value">Focused writing</span>
                    </div>
                    <div class="iw-auth-note">
                        <span class="iw-auth-note-label">Flow</span>
                        <span class="iw-auth-note-value">Draft, refine, publish</span>
                    </div>
                </div>
            </section>

            <!-- Login Form -->
            <section class="col-lg-5 ms-lg-auto">
                <div class="iw-auth-panel">
                    <div class="iw-auth-panel-header">
                        <span class="iw-auth-panel-label">Sign in</span>
                    </div>

                    <?php if (!empty($_SESSION['Login_Err'])): ?>
                        <div class="alert alert-danger iw-auth-alert" role="alert">
                            <?= $_SESSION['Login_Err'];
                            unset($_SESSION['Login_Err']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['register_suc'])): ?>
                        <div class="alert alert-success iw-auth-alert" role="alert">
                            <?= $_SESSION['register_suc'];
                            unset($_SESSION['register_suc']); ?>
                        </div>
                    <?php endif; ?>

                    <form class="iw-login-form" method="post" action="./login.php" novalidate>
                        <div class="iw-form-group">
                            <input class="iw-form-input" name="username" type="text" required>
                            <label class="iw-form-label">Username</label>
                        </div>

                        <div class="iw-form-group">
                            <input class="iw-form-input" name="password" type="password" required>
                            <label class="iw-form-label">Password</label>
                        </div>

                        <button class="iw-btn-primary" type="submit">Continue Writing</button>

                        <p class="iw-auth-secondary">
                            New to Inkwave? <a href="./register_form.php">Begin here</a>
                        </p>
                    </form>
                </div>
            </section>
        </div>
    </main>

</body>
<script src="../assets/js/script.js"></script>

</html>