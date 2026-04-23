<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inkwave - Welcome Back</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="auth-login">

    <div class="background"></div>

    <main class="container auth-shell py-5">
        <div class="row g-5 align-items-center min-vh-100 auth-row">
            <section class="col-lg-6 welcome">
                <p class="auth-kicker">Return to the page</p>
                <h1>Welcome back.</h1>
                <p class="brandline">A quieter desk, cleaner rhythm, and your unfinished sentences waiting exactly where you left them.</p>
                <p class="brand">Ink<em>wave</em></p>

                <div class="auth-notes" aria-hidden="true">
                    <div class="auth-note">
                        <span class="auth-note-label">Desk</span>
                        <span class="auth-note-value">Focused writing</span>
                    </div>
                    <div class="auth-note">
                        <span class="auth-note-label">Flow</span>
                        <span class="auth-note-value">Draft, refine, publish</span>
                    </div>
                </div>
            </section>

            <section class="col-lg-5 ms-lg-auto">
                <div class="auth-panel">
                    <div class="auth-panel-top">
                        <span class="auth-panel-label">Sign in</span>
                    </div>

                    <?php if (!empty($_SESSION['Login_Err'])): ?>
                        <div class="alert alert-danger auth-alert" role="alert">
                            <?= $_SESSION['Login_Err']; unset($_SESSION['Login_Err']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['register_suc'])): ?>
                        <div class="alert alert-success auth-alert" role="alert">
                            <?= $_SESSION['register_suc']; unset($_SESSION['register_suc']); ?>
                        </div>
                    <?php endif; ?>

                    <form class="login-flow" method="post" action="./login.php" novalidate>
                        <div class="input-group">
                            <input name="username" type="text" required>
                            <label>Username</label>
                        </div>

                        <div class="input-group">
                            <input name="password" type="password" required>
                            <label>Password</label>
                        </div>

                        <button class="primary-btn" type="submit">Continue Writing</button>

                        <p class="secondary">
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
