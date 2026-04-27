<?php
session_start();

if (empty($_SESSION['Loggedin'])) {
    header("Location: ../auth/login_form.php");
    exit();
}

// Connecting Database
require_once '../config/db.php';
if (isset($_SESSION['DatabaseErr'])) {
    $dbError = $_SESSION['DatabaseErr'];
    unset($_SESSION['DatabaseErr']);
}

// Fetch categories for dropdown
try {
    $stmt = mysqli_prepare($db_connect, "SELECT * FROM categories ORDER BY name ASC");
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    $dbError = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inkwave — Writing Studio</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">
    <link href="../assets/bs-css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
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

        <form action="add_post.php" method="post" class="iw-dashboard-main" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
            <header class="iw-studio-topbar" aria-label="Studio top bar">
                <div>
                    <div class="iw-dash-greeting">Studio</div>
                    <h1 class="iw-dash-title mb-0">Shape your next story</h1>
                </div>

                <div class="iw-studio-actions">
                    <?php if (!empty($_SESSION['PostErr'])): ?>

                        <div id="alert" class="alert alert-warning d-flex px-2 py-1 gap-1 my-2 align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div>
                                <?= $_SESSION['PostErr'];
                                unset($_SESSION['PostErr']); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['PostSucc'])): ?>
                        <div id="alert" class="alert alert-success d-flex gap-1 px-2 py-1 mt-2 align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill"></i>
                            <div>
                                <?= $_SESSION['PostSucc'];
                                unset($_SESSION['PostSucc']); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <button type="submit" value="draft" name="status" class="btn btn-outline-light">
                        <i class="bi bi-save"></i>
                        Save Draft
                    </button>
                    <button class="btn btn-primary" type="submit" value="publish" name="status">
                        <i class="bi bi-send-check"></i>
                        Publish
                    </button>
                </div>
            </header>

            <div class="iw-studio-layout">
                <section class="iw-studio-page-wrap">
                    <div class="iw-studio-page-head">
                        <input class="iw-studio-title-input" name="title" id="iw-title" type="text" placeholder="Untitled story..." autocomplete="off" aria-label="Story title">
                        <div class="iw-studio-meta-row">
                            <span class="iw-studio-meta-pill" id="iw-status">Draft</span>
                            <span>•</span>
                            <span id="iw-count">0 words • 0 min read</span>
                        </div>
                    </div>

                    <div class="iw-studio-page iw-studio-page-quill">
                        <div class="iw-studio-gutter" aria-hidden="true"></div>
                        <div id="iw-toolbar" class="iw-quill-toolbar">
                            <span class="ql-formats">
                                <select class="ql-header">
                                    <option selected></option>
                                    <option value="1"></option>
                                    <option value="2"></option>
                                    <option value="3"></option>
                                </select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-blockquote"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                                <button class="ql-link"></button>
                            </span>
                        </div>
                        <div id="iw-editor" class="iw-studio-editor"></div>
                        <input type="hidden" name="content" id="iw-content">
                    </div>

                    <div class="iw-studio-page-foot">
                        <div class="iw-studio-foot-left">
                            <button class="iw-studio-foot-action" type="button" data-soft-toast="Write the first version fast. Refine the second version carefully.">
                                Writing tip
                            </button>
                            <button class="iw-studio-foot-action" type="button" data-soft-toast="Strong titles are clear first, clever second.">
                                Title tip
                            </button>
                        </div>
                        <div class="iw-studio-foot-right">
                            <span class="iw-studio-foot-note">Quill editor enabled for cleaner formatting and previews.</span>
                        </div>
                    </div>
                </section>

                <aside class="iw-studio-right-rail">
                    <div class="iw-studio-rail-block">
                        <div class="iw-studio-rail-title">Image</div>
                        <div class="iw-studio-preview d-flex justify-content-center">
                            <div class="d-flex flex-column align-items-center">
                                <i id="upload-icon" class="bi bi-image fs-1"></i>
                                <label for="banner" role="button" id="banner-label">
                                    <span id="upload-text" class="d-block">Select Image</span>
                                </label>
                                <img id="bannerPreview">
                                <p id="bannerName" style="display: none; margin-bottom: 0.2rem; max-width: 20ch; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; align-self: flex-start;"></p>
                                <p id="bannerSize" style="display: none; margin-bottom: 0.2rem; align-self: flex-start;"></p>
                            </div>
                            <input hidden type="file" id="banner" accept="image/*" name="banner">
                        </div>
                    </div>

                    <div class="iw-studio-rail-block">
                        <div class="iw-studio-rail-title">Story settings</div>


                        <div class="iw-studio-field">
                            <label class="iw-studio-label" for="story-category">Category</label>
                            <select id="story-category" name="category" class="iw-studio-select">
                                <option style="background-color: #151d2f; color: #2f2f2f;" selected disabled>Select Category</option>
                                <?php foreach ($categories as $cat) { ?>
                                    <option style="background-color: #111827; color: #fff" value="<?= htmlspecialchars($cat['id']) ?>"><?= htmlspecialchars($cat['name']) ?>

                                    </option>

                                <?php } ?>
                            </select>
                        </div>


                        <div class="iw-studio-field">
                            <label class="iw-studio-label" for="story-tone">Tone</label>
                            <select id="story-tone" class="iw-studio-select">
                                <option>Reflective</option>
                                <option>Sharp</option>
                                <option>Warm</option>
                                <option>Bold</option>
                                <option>Professional</option>
                            </select>
                        </div>
                        <div class="iw-studio-field">
                            <label class="iw-studio-label" for="story-tags">Tags</label>
                            <input id="story-tags" type="text" class="iw-studio-input" placeholder="essays, process, design">
                        </div>
                    </div>

                    <div class="iw-studio-rail-block">
                        <div class="iw-studio-rail-title">Publishing checklist</div>
                        <div class="iw-status-list">
                            <div class="iw-status-row">
                                <span class="iw-status-label">Title</span>
                                <strong id="check-title">Waiting</strong>
                            </div>
                            <div class="iw-status-row">
                                <span class="iw-status-label">Content</span>
                                <strong id="check-content">Waiting</strong>
                            </div>
                            <div class="iw-status-row">
                                <span class="iw-status-label">Readiness</span>
                                <strong id="check-ready">Start drafting</strong>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </form>
    </div>

    <div class="iw-toast" role="status" aria-live="polite" aria-atomic="true"></div>

    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
    <script>
        const toast = document.querySelector('.iw-toast');
        let toastTimer = null;

        function softToast(message) {
            if (!toast) return;
            toast.textContent = message;
            toast.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => toast.classList.remove('show'), 2400);
        }

        document.querySelectorAll('[data-soft-toast]').forEach((button) => {
            button.addEventListener('click', () => softToast(button.dataset.softToast || ''));
        });

        const quill = new Quill('#iw-editor', {
            modules: {
                toolbar: '#iw-toolbar'
            },
            placeholder: 'Start writing your story...',
            theme: 'snow'
        });

        const titleInput = document.getElementById('iw-title');
        const contentInput = document.getElementById('iw-content');
        const count = document.getElementById('iw-count');
        const previewTitle = document.getElementById('preview-title');
        const previewBody = document.getElementById('preview-body');
        const status = document.getElementById('iw-status');
        const checkTitle = document.getElementById('check-title');
        const checkContent = document.getElementById('check-content');
        const checkReady = document.getElementById('check-ready');
        let saveTimer = null;

        function refreshStudio() {
            const text = quill.getText().trim();
            const html = quill.root.innerHTML;
            const words = text ? text.split(/\s+/).length : 0;
            const minutes = words ? Math.max(1, Math.ceil(words / 200)) : 0;
            const storyTitle = titleInput.value.trim() || 'Untitled story';

            contentInput.value = html === '<p><br></p>' ? '' : html;
            count.textContent = `${words} words • ${minutes} min read`;
            previewTitle.textContent = storyTitle;
            previewBody.textContent = text || 'Your preview updates as you write.';
            checkTitle.textContent = titleInput.value.trim() ? 'Ready' : 'Waiting';
            checkContent.textContent = words > 30 ? 'Ready' : 'Needs more';
            checkReady.textContent = titleInput.value.trim() && words > 30 ? 'Good to publish' : 'Keep drafting';

            status.textContent = 'Saving';
            clearTimeout(saveTimer);
            saveTimer = setTimeout(() => {
                status.textContent = 'Saved';
            }, 700);
        }

        quill.on('text-change', refreshStudio);
        titleInput.addEventListener('input', refreshStudio);
        document.querySelector('form').addEventListener('submit', () => {
            contentInput.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
        });

        refreshStudio();
    </script>
    <script>
        document.getElementById('banner').addEventListener('change', function() {
            let file = this.files[0];
            if (file && file.type.startsWith('image/')) {
                document.getElementById('bannerName').textContent = 'Selected: ' + file.name;
                document.getElementById('bannerSize').textContent = 'Size: ' + (file.size / 1000000).toFixed(2) + ' MB';
                document.getElementById('bannerSize').style.display = 'block';
                document.getElementById('bannerName').style.display = 'block';

                let reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('upload-icon').style.display = 'none';
                    document.getElementById('upload-text').innerText = 'Change Image';
                    document.getElementById('bannerPreview').src = e.target.result;
                    document.getElementById('bannerPreview').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>