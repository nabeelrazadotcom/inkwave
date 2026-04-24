<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Inkwave — Register</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">

    <!-- Bootstrap (only grid/utilities, not form styling dependency) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body class="auth-register">

    <!-- BACKGROUND -->
    <div class="background-flow" id="bg"></div>

    <!-- MAIN -->
    <main class="main container auth-shell py-5">
        <div class="row g-5 align-items-center w-100 auth-row">
            <section class="col-lg-5">
                <div class="brand register-brand text-lg-start text-center">
                    <p class="auth-kicker">Create your writing identity</p>
                    <h1>Inkwave</h1>
                    <p class="brand-rotate" data-rotate="1">Begin your flow of writing.</p>
                    <div class="register-sidecopy">
                        <div class="register-sidecopy-item">
                            <span class="register-sidecopy-label">Presence</span>
                            <span class="register-sidecopy-value">A profile with voice, not just credentials.</span>
                        </div>
                        <div class="register-sidecopy-item">
                            <span class="register-sidecopy-label">Writing</span>
                            <span class="register-sidecopy-value">Built for essays, notes, fragments, and long reflections.</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="col-lg-6 ms-lg-auto">
                <div class="auth-panel register-panel">
                    <div class="auth-panel-top">
                        <span class="auth-panel-label">Create account</span>
                    </div>

                    <?php if (!empty($_SESSION['register_Err'])): ?>
                        <div class="alert alert-danger auth-alert" role="alert">
                            <?= $_SESSION['register_Err'];
                            unset($_SESSION['register_Err']); ?>
                        </div>
                    <?php endif; ?>

                    <form class="form-wrap register-form" method="post" action="./register.php" enctype="multipart/form-data">
                        <div class="register-section">
                            <div class="register-section-head">
                                <span class="register-section-label">Identity</span>
                            </div>

                            <div class="register-grid">
                                <div class="field field-wide">
                                    <input required name="name" type="text" placeholder=" " id="name">
                                    <label>Full Name</label>
                                </div>

                                <div class="field">
                                    <input required name="username" type="text" placeholder=" " id="username">
                                    <label>Username</label>
                                </div>

                                <div class="field">
                                    <input required name="email" type="email" placeholder=" " id="email">
                                    <label>Email</label>
                                </div>

                                <div class="field field-wide">
                                    <input required minlength="8" name="password" type="password" placeholder=" " id="password">
                                    <label>Password</label>
                                </div>
                            </div>
                        </div>

                        <div class="register-section register-section-optional">
                            <div class="register-section-head">
                                <span class="register-section-label">Profile</span>
                                <span class="register-section-note">Optional</span>
                            </div>

                            <div class="profile-card">
                                <div class="split">
                                    <div class="upload-panel">

                                        <input name="avatar" type="file" accept="image/png,image/jpeg,image/webp" id="avatar" class="file-input" />
                                        <label class="upload-trigger" for="avatar">Choose image</label>
                                        <div class="file-sub" id="avatarStatus">PNG, JPG, or WebP. Add a face to the byline, or leave it for later.</div>
                                    </div>

                                    <div class="pfp-wrap">
                                        <div class="pfp" aria-label="Profile photo preview">
                                            <div class="pfp-ring"></div>
                                            <img src="../uploads/profiles/default.svg" style="width: 100%;" class="p-0 pfp-img is-default" id="avatarPreview" alt="Profile preview" />
                                        </div>
                                        <span class="pfp-caption">Preview</span>
                                    </div>
                                </div>

                                <div class="field field-bio">
                                    <textarea name="bio" id="bio" rows="3" placeholder=" "></textarea>
                                    <label>Bio</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-btn d-flex gap-1">
                            <button type="submit" class="cta w-50">Enter Inkwave</button>
                            <button type="reset" class="cta w-50">Reset</button>
                        </div>
                        <p class="alt">
                            Already have an account? <a href="./login_form.php">Sign in</a>
                        </p>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <!-- Custom JS -->
    <script src="../assets/js/script.js"></script>
    <script>
        const input = document.getElementById('avatar');
        const img = document.getElementById('avatarPreview');
        const status = document.getElementById('avatarStatus');
        const defaultAvatar = '../uploads/profiles/default.svg';
        if (input && img && status) {
            img.src = defaultAvatar;

            function resetPreview(message) {
                img.src = defaultAvatar;
                img.classList.add('is-default');
                status.textContent = message || 'PNG, JPG, or WebP. Add a face to the byline, or leave it for later.';
            }

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
                reader.onerror = () => {
                    resetPreview('Could not load that image preview.');
                };
                reader.readAsDataURL(file);
            });

            img.addEventListener('error', () => {
                resetPreview('Default profile image loaded.');
            });
        }
    </script>

</body>

</html>