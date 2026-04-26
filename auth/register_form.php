<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inkwave — Register</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="iw-auth-register">

    <div class="iw-bg-flow" id="bg" aria-hidden="true"></div>
    <div class="iw-bg-animated" aria-hidden="true"></div>

    <main class="container iw-auth-container py-5">
        <div class="row g-5 align-items-center min-vh-100 iw-auth-row">
            <section class="col-lg-5 iw-auth-welcome">
                <p class="iw-auth-kicker">Create your writing identity</p>
                <h1>Build a publishing space that feels intentional.</h1>
                <p class="iw-auth-brandline" data-rotate="1">Begin your flow of writing.</p>
                <p class="iw-auth-brand">Ink<em>wave</em></p>

                <div class="iw-auth-notes" aria-hidden="true">
                    <div class="iw-auth-note">
                        <span class="iw-auth-note-label">Presence</span>
                        <span class="iw-auth-note-value">A profile with voice, not just credentials.</span>
                    </div>
                    <div class="iw-auth-note">
                        <span class="iw-auth-note-label">Writing</span>
                        <span class="iw-auth-note-value">Essays, notes, fragments, and long-form reflections.</span>
                    </div>
                    <div class="iw-auth-note">
                        <span class="iw-auth-note-label">Output</span>
                        <span class="iw-auth-note-value">Draft calmly, publish cleanly, grow deliberately.</span>
                    </div>
                </div>
            </section>

            <section class="col-lg-6 ms-lg-auto">
                <div class="iw-auth-panel">
                    <div class="iw-auth-panel-header">
                        <span class="iw-auth-panel-label">Create account</span>
                        <h2 class="iw-auth-panel-title">Start your Inkwave profile</h2>
                    </div>

                    <?php if (!empty($_SESSION['register_Err'])): ?>
                        <div class="alert alert-danger iw-auth-alert" role="alert">
                            <?= $_SESSION['register_Err'];
                            unset($_SESSION['register_Err']); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="./register.php" enctype="multipart/form-data">
                        <section class="iw-auth-register-section">
                            <div class="iw-auth-register-section-header">
                                <span class="iw-auth-register-section-label">Identity</span>
                            </div>

                            <div class="iw-auth-register-grid">
                                <div class="iw-form-group iw-form-group-wide">
                                    <input class="iw-form-input" required name="name" type="text">
                                    <label class="iw-form-label">Full Name</label>
                                </div>

                                <div class="iw-form-group">
                                    <input class="iw-form-input" required name="username" type="text">
                                    <label class="iw-form-label">Username</label>
                                </div>

                                <div class="iw-form-group">
                                    <input class="iw-form-input" required name="email" type="email">
                                    <label class="iw-form-label">Email</label>
                                </div>

                                <div class="iw-form-group iw-form-group-wide">
                                    <input class="iw-form-input" required minlength="8" name="password" type="password">
                                    <label class="iw-form-label">Password</label>
                                </div>
                            </div>
                        </section>

                        <section class="iw-auth-register-section">
                            <div class="iw-auth-register-section-header">
                                <span class="iw-auth-register-section-label">Profile</span>
                                <span class="iw-auth-register-section-note">Optional</span>
                            </div>

                            <div class="iw-profile-upload">
                                <div class="iw-upload-panel">
                                    <input name="avatar" type="file" accept="image/png,image/jpeg,image/webp" id="avatar" class="iw-file-input">
                                    <label class="iw-upload-trigger" for="avatar">Choose image</label>
                                    <div class="iw-file-sub" id="avatarStatus">PNG, JPG, or WebP. Add a byline image now or later.</div>
                                </div>

                                <div class="iw-pfp-container" aria-label="Profile photo preview">
                                    <div class="iw-pfp-ring"></div>
                                    <img src="../uploads/profiles/default.svg" class="iw-pfp-img is-default" id="avatarPreview" alt="Profile preview">
                                    <span class="iw-pfp-caption">Preview</span>
                                </div>
                            </div>

                            <div class="iw-form-group">
                                <textarea class="iw-form-textarea" name="bio" id="bio" rows="4"></textarea>
                                <label class="iw-form-label" for="bio">Bio</label>
                            </div>
                        </section>

                        <div class="iw-form-actions">
                            <button type="submit" class="iw-btn-cta">Enter Inkwave</button>
                            <button type="reset" class="iw-btn-cta">Reset</button>
                        </div>

                        <p class="iw-auth-secondary">
                            Already have an account? <a href="./login_form.php">Sign in</a>
                        </p>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <script src="../assets/js/script.js"></script>
    <script>
        const input = document.getElementById('avatar');
        const img = document.getElementById('avatarPreview');
        const status = document.getElementById('avatarStatus');
        const defaultAvatar = '../uploads/profiles/default.svg';

        if (input && img && status) {
            function resetPreview(message) {
                img.src = defaultAvatar;
                img.classList.add('is-default');
                status.textContent = message || 'PNG, JPG, or WebP. Add a byline image now or later.';
            }

            resetPreview();

            input.addEventListener('change', () => {
                const file = input.files && input.files[0];
                if (!file) {
                    resetPreview();
                    return;
                }

                if (!file.type.startsWith('image/')) {
                    input.value = '';
                    resetPreview('That file is not a supported image.');
                    return;
                }

                const reader = new FileReader();
                reader.onload = (event) => {
                    img.src = event.target?.result || defaultAvatar;
                    img.classList.remove('is-default');
                    status.textContent = file.name;
                };
                reader.onerror = () => resetPreview('Could not load that image preview.');
                reader.readAsDataURL(file);
            });
        }
    </script>
</body>

</html>
