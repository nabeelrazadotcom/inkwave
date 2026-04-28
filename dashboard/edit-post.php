<?php
session_start();

if (empty($_SESSION['Loggedin'])) {
    header("Location: ../auth/login_form.php");
    exit();
}

require_once '../config/db.php';

$postId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($postId <= 0) {
    $_SESSION['PostErr'] = "Choose a post to edit first.";
    header("Location: ./posts.php");
    exit();
}

$categories = [];
$post = null;
$dbError = null;

try {
    $categoryStmt = mysqli_prepare($db_connect, "SELECT id, name FROM categories ORDER BY name ASC");
    $categoryStmt->execute();
    $categories = $categoryStmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $postStmt = mysqli_prepare($db_connect, "SELECT * FROM posts WHERE id = ? AND user_id = ? LIMIT 1");
    $postStmt->bind_param("ii", $postId, $_SESSION['user_id']);
    $postStmt->execute();
    $post = $postStmt->get_result()->fetch_assoc();
} catch (Exception $e) {
    $dbError = $e->getMessage();
}

if (!$post && !$dbError) {
    $_SESSION['PostErr'] = "That post could not be found.";
    header("Location: ./posts.php");
    exit();
}

$formData = $_SESSION['edit_post_form_data'] ?? [];
$useFormData = !empty($formData) && (int) ($formData['id'] ?? 0) === $postId;

$titleValue = $useFormData ? trim((string) ($formData['title'] ?? '')) : (string) ($post['title'] ?? '');
$contentValue = $useFormData ? (string) ($formData['content'] ?? '') : (string) ($post['content'] ?? '');
$categoryValue = $useFormData ? (int) ($formData['category_id'] ?? 0) : (int) ($post['category_id'] ?? 0);
$statusValue = (string) ($post['status'] ?? 'draft');
$imageValue = (string) ($post['image'] ?? '');
$lastUpdated = !empty($post['updated_at']) ? $post['updated_at'] : ($post['created_at'] ?? null);

unset($_SESSION['edit_post_form_data']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inkwave — Edit Story</title>
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

        <form action="update_post.php" method="post" class="iw-dashboard-main" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?= $postId ?>">
            <input type="hidden" name="content" id="iw-content">

            <header class="iw-studio-topbar iw-dash-header" aria-label="Studio top bar">
                <div class="iw-dash-header-left">
                    <div class="iw-dash-greeting">Studio</div>
                    <h1 class="iw-dash-title mb-0">Edit your story</h1>
                    <p class="iw-dash-subtitle">Refine the same writing surface you used to create the post, with only the page title changed for clarity.</p>
                </div>

                <div class="iw-dash-header-right iw-studio-actions">
                    <a href="./posts.php" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left"></i>
                        Back to Posts
                    </a>
                    <button class="btn btn-outline-light" type="submit" value="draft" name="status">
                        <i class="bi bi-save"></i>
                        Save Draft
                    </button>
                    <button class="btn btn-primary" type="submit" value="publish" name="status">
                        <i class="bi bi-send-check"></i>
                        Update & Publish
                    </button>
                </div>
            </header>

            <?php if (!empty($dbError)): ?>
                <div class="alert alert-warning iw-inline-alert" role="alert">
                    <?= htmlspecialchars($dbError) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['PostErr'])): ?>
                <div class="alert alert-warning iw-inline-alert" role="alert">
                    <?= htmlspecialchars($_SESSION['PostErr']) ?>
                </div>
                <?php unset($_SESSION['PostErr']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['PostSucc'])): ?>
                <div class="alert alert-success iw-inline-alert" role="alert">
                    <?= htmlspecialchars($_SESSION['PostSucc']) ?>
                </div>
                <?php unset($_SESSION['PostSucc']); ?>
            <?php endif; ?>

            <div class="iw-studio-layout">
                <section class="iw-studio-page-wrap">
                    <div class="iw-studio-page-head">
                        <input
                            class="iw-studio-title-input"
                            name="title"
                            id="iw-title"
                            type="text"
                            placeholder="Refine your title"
                            autocomplete="off"
                            aria-label="Story title"
                            value="<?= htmlspecialchars($titleValue) ?>">

                        <div class="iw-studio-meta-row">
                            <span class="iw-studio-meta-pill" id="iw-status"><?= $statusValue === 'publish' ? 'Published' : 'Draft' ?></span>
                            <span>•</span>
                            <span id="iw-count">0 words • 0 min read</span>
                            <span>•</span>
                            <span id="iw-completion"><?= $lastUpdated ? 'Last updated ' . date('F j, Y', strtotime($lastUpdated)) : 'Keep improving the draft' ?></span>
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
                                </select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-bold" aria-label="Bold"></button>
                                <button class="ql-italic" aria-label="Italic"></button>
                                <button class="ql-underline" aria-label="Underline"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-list" value="ordered" aria-label="Numbered list"></button>
                                <button class="ql-list" value="bullet" aria-label="Bulleted list"></button>
                                <button class="ql-blockquote" aria-label="Block quote"></button>
                                <button class="ql-link" aria-label="Add link"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-clean" aria-label="Clear formatting"></button>
                            </span>
                        </div>
                        <div id="iw-editor" class="iw-studio-editor"></div>
                    </div>

                    <div class="iw-studio-page-foot">
                        <div class="iw-studio-foot-left">
                            <button class="iw-studio-foot-action" type="button" data-soft-toast="Use each revision pass for one goal only: structure, clarity, or polish.">
                                Revision tip
                            </button>
                            <button class="iw-studio-foot-action" type="button" data-soft-toast="Read the first paragraph again before publishing. It sets the tone for everything after it.">
                                Opening tip
                            </button>
                            <button class="iw-studio-foot-action" type="button" data-soft-toast="Strong editing usually removes confusion before it adds style.">
                                Clarity tip
                            </button>
                        </div>
                        <div class="iw-studio-foot-right">
                            <span class="iw-studio-foot-note">The editor matches create mode so the transition from drafting to editing stays effortless.</span>
                        </div>
                    </div>
                </section>

                <aside class="iw-studio-right-rail">
                    <div class="iw-studio-rail-block">
                        <div class="iw-studio-rail-title">Story settings</div>

                        <div class="iw-studio-field">
                            <label class="iw-studio-label" for="story-category">Category</label>
                            <select id="story-category" name="category_id" class="iw-studio-select" required>
                                <option value="">Select a category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= (int) $cat['id'] ?>" <?= $categoryValue === (int) $cat['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="iw-studio-field">
                            <label class="iw-studio-label" for="story-status-note">Publishing flow</label>
                            <div id="story-status-note" class="iw-studio-note-list">
                                <div class="iw-studio-note-item">Saving as draft keeps the piece private while you revise.</div>
                                <div class="iw-studio-note-item">Publishing updates the live version for readers.</div>
                            </div>
                        </div>
                    </div>

                    <div class="iw-studio-rail-block">
                        <div class="iw-studio-rail-title">Cover image</div>
                        <label for="banner" class="iw-studio-upload-card<?= $imageValue !== '' ? ' has-image' : '' ?>">
                            <span class="iw-studio-upload-icon"><i class="bi bi-image"></i></span>
                            <span class="iw-studio-upload-title" id="upload-text"><?= $imageValue !== '' ? 'Replace cover image' : 'Choose a cover image' ?></span>
                            <span class="iw-studio-upload-copy">PNG, JPG, or GIF up to 5 MB</span>
                            <img id="bannerPreview" alt="Cover image preview"<?= $imageValue !== '' ? ' src="../uploads/posts/' . rawurlencode($imageValue) . '"' : '' ?>>
                        </label>
                        <input hidden type="file" id="banner" accept="image/png,image/jpeg,image/gif" name="banner">
                        <div class="iw-studio-file-meta" id="bannerMeta">
                            <?= $imageValue !== '' ? htmlspecialchars($imageValue) : 'No image selected yet.' ?>
                        </div>
                    </div>

                    <div class="iw-studio-rail-block">
                        <div class="iw-studio-rail-title">Live preview</div>
                        <div class="iw-studio-preview-card">
                            <span class="iw-badge-soft <?= $statusValue === 'publish' ? 'is-success' : 'is-warning' ?>" id="preview-badge">
                                <?= $statusValue === 'publish' ? 'Published' : 'Draft' ?>
                            </span>
                            <h2 class="iw-studio-preview-title" id="preview-title">Untitled story</h2>
                            <p class="iw-studio-preview-body" id="preview-body">Your story summary will appear here as you write.</p>
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
                                <span class="iw-status-label">Category</span>
                                <strong id="check-category">Waiting</strong>
                            </div>
                            <div class="iw-status-row">
                                <span class="iw-status-label">Readiness</span>
                                <strong id="check-ready">Keep revising</strong>
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
        const initialHtml = <?= json_encode($contentValue, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
        const toast = document.querySelector('.iw-toast');
        const titleInput = document.getElementById('iw-title');
        const contentInput = document.getElementById('iw-content');
        const wordCount = document.getElementById('iw-count');
        const completion = document.getElementById('iw-completion');
        const previewTitle = document.getElementById('preview-title');
        const previewBody = document.getElementById('preview-body');
        const previewBadge = document.getElementById('preview-badge');
        const statusPill = document.getElementById('iw-status');
        const categorySelect = document.getElementById('story-category');
        const checkTitle = document.getElementById('check-title');
        const checkContent = document.getElementById('check-content');
        const checkCategory = document.getElementById('check-category');
        const checkReady = document.getElementById('check-ready');
        const bannerInput = document.getElementById('banner');
        const bannerPreview = document.getElementById('bannerPreview');
        const bannerMeta = document.getElementById('bannerMeta');
        const uploadText = document.getElementById('upload-text');
        let toastTimer = null;
        let saveTimer = null;

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
            placeholder: 'Continue shaping your story...',
            theme: 'snow'
        });

        if (initialHtml) {
            quill.clipboard.dangerouslyPasteHTML(initialHtml);
        }

        function refreshStudio() {
            const text = quill.getText().replace(/\s+/g, ' ').trim();
            const html = quill.root.innerHTML;
            const words = text ? text.split(' ').length : 0;
            const minutes = words ? Math.max(1, Math.ceil(words / 200)) : 0;
            const storyTitle = titleInput.value.trim() || 'Untitled story';
            const storyPreview = text ? `${text.slice(0, 180)}${text.length > 180 ? '…' : ''}` : 'Your story summary will appear here as you write.';
            const categoryReady = categorySelect.value !== '';

            contentInput.value = html === '<p><br></p>' ? '' : html;
            wordCount.textContent = `${words} words • ${minutes} min read`;
            previewTitle.textContent = storyTitle;
            previewBody.textContent = storyPreview;
            checkTitle.textContent = titleInput.value.trim() ? 'Ready' : 'Waiting';
            checkContent.textContent = words > 30 ? 'Ready' : 'Needs more';
            checkCategory.textContent = categoryReady ? 'Ready' : 'Waiting';

            if (titleInput.value.trim() && words > 30 && categoryReady) {
                checkReady.textContent = 'Ready to update';
                completion.textContent = 'Your update is ready for the next save or publish';
            } else if (words > 0) {
                checkReady.textContent = 'Keep refining';
                completion.textContent = 'Tighten the draft and confirm its category';
            } else {
                checkReady.textContent = 'Needs content';
                completion.textContent = 'Add writing before updating the post';
            }

            statusPill.textContent = 'Editing';
            previewBadge.textContent = words > 30 ? 'Updated Draft' : 'Draft';
            clearTimeout(saveTimer);
            saveTimer = setTimeout(() => {
                statusPill.textContent = 'Draft';
            }, 650);
        }

        function refreshBanner() {
            const file = bannerInput.files && bannerInput.files[0];
            if (!file) {
                if (!bannerPreview.getAttribute('src')) {
                    bannerPreview.style.display = 'none';
                    bannerMeta.textContent = 'No image selected yet.';
                    uploadText.textContent = 'Choose a cover image';
                }
                return;
            }

            if (!file.type.startsWith('image/')) {
                bannerInput.value = '';
                softToast('Please choose a valid image file.');
                return;
            }

            bannerMeta.textContent = `${file.name} • ${(file.size / 1000000).toFixed(2)} MB`;
            uploadText.textContent = 'Replace cover image';

            const reader = new FileReader();
            reader.onload = (event) => {
                bannerPreview.src = event.target?.result || '';
                bannerPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        quill.on('text-change', refreshStudio);
        titleInput.addEventListener('input', refreshStudio);
        categorySelect.addEventListener('change', refreshStudio);
        bannerInput.addEventListener('change', refreshBanner);
        document.querySelector('form').addEventListener('submit', () => {
            contentInput.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
        });

        if (bannerPreview.getAttribute('src')) {
            bannerPreview.style.display = 'block';
        }

        refreshStudio();
        refreshBanner();
    </script>
</body>

</html>
