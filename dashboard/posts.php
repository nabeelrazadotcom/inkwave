<?php
session_start();

if (empty($_SESSION['Loggedin'])) {
    header("Location: ../auth/login_form.php");
    exit();
}

require_once '../config/db.php';

try {
    $stmt = mysqli_prepare(
        $db_connect,
        "SELECT posts.*, categories.name AS category_name
         FROM posts
         LEFT JOIN categories ON posts.category_id = categories.id
         WHERE posts.user_id = ?
         ORDER BY COALESCE(posts.updated_at, posts.created_at) DESC"
    );
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    $_SESSION['PostErr'] = $e->getMessage();
    header("Location: ./index.php");
    exit();
}

function iwPostStatusLabel(string $status): string
{
    return $status === 'publish' ? 'Published' : 'Draft';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts — Inkwave</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">
    <link href="../assets/bs-css/bootstrap.min.css" rel="stylesheet">
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
                    <div class="iw-dash-greeting">Library</div>
                    <h1 class="iw-dash-title">Your posts</h1>
                    <p class="iw-dash-subtitle">Search faster, scan status more clearly, and jump into editing without friction.</p>
                </div>
                <div class="iw-dash-header-right">
                    <a href="./create-post.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Story</a>
                </div>
            </header>

            <?php if (!empty($_SESSION['PostErr'])): ?>
                <div class="alert alert-warning iw-inline-alert" role="alert">
                    <?= htmlspecialchars($_SESSION['PostErr']) ?>
                </div>
                <?php unset($_SESSION['PostErr']); ?>
            <?php endif; ?>

            <section class="iw-dash-section">
                <div class="iw-table-toolbar">
                    <label class="iw-table-filter" for="post-search">
                        <i class="bi bi-search"></i>
                        <input type="text" id="post-search" class="iw-studio-input" placeholder="Search by title, category, or status">
                    </label>
                    <span class="iw-dash-section-badge"><span id="post-count"><?= count($posts) ?></span> stories</span>
                </div>

                <?php if (!empty($posts)): ?>
                    <div class="table-responsive">
                        <table class="table iw-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Category</th>
                                    <th>Last updated</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody id="posts-table-body">
                                <?php foreach ($posts as $post): ?>
                                    <?php
                                    $statusLabel = iwPostStatusLabel((string) $post['status']);
                                    $dateValue = !empty($post['updated_at']) ? $post['updated_at'] : $post['created_at'];
                                    ?>
                                    <tr data-post-row data-search="<?= htmlspecialchars(strtolower(trim(($post['title'] ?? '') . ' ' . ($post['category_name'] ?? 'uncategorized') . ' ' . $statusLabel))) ?>">
                                        <td>
                                            <div class="iw-table-title"><?= htmlspecialchars($post['title']) ?></div>
                                        </td>
                                        <td>
                                            <span class="iw-badge-soft <?= $post['status'] === 'publish' ? 'is-success' : 'is-warning' ?>">
                                                <?= htmlspecialchars($statusLabel) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($post['category_name'] ?? 'Uncategorized') ?></td>
                                        <td><?= $dateValue ? htmlspecialchars(date('F j, Y', strtotime($dateValue))) : 'No date' ?></td>
                                        <td class="text-end">
                                            <a href="./edit-post.php?id=<?= (int) $post['id'] ?>" class="iw-dash-section-link">Edit</a>
                                            <a href="#" class="iw-dash-section-link delete-trigger" data-delete-url="./delete_post.php?id=<?= (int) $post['id'] ?>">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="iw-empty-state">
                        <div class="iw-empty-state-icon"><i class="bi bi-journal-text"></i></div>
                        <h2 class="iw-empty-state-title">No stories yet</h2>
                        <p class="iw-empty-state-text">Create your first post to start building the library.</p>
                    </div>
                <?php endif; ?>

                <div class="popup d-flex flex-column gap-3">
                    <div class="d-flex ">
                        <span class="iw-sidebar-logo-ink">Ink</span>
                        <span class="iw-sidebar-logo-wave">wave</span>
                    </div>
                    <h4>Do You want to delete this blog?</h4>
                    <div class="popup-buttons d-flex gap-1 justify-content-end">
                        <a id="delete" class="popup-btn popup-btn-delete" href="#">Delete</a>
                        <a id="cancel" class="popup-btn popup-btn-cancel" href="#">Cancel</a>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        const postSearch = document.getElementById('post-search');
        const postRows = Array.from(document.querySelectorAll('[data-post-row]'));
        const postCount = document.getElementById('post-count');

        if (postSearch && postRows.length) {
            postSearch.addEventListener('input', () => {
                const query = postSearch.value.trim().toLowerCase();
                let visible = 0;

                postRows.forEach((row) => {
                    const matches = row.dataset.search.includes(query);
                    row.style.display = matches ? '' : 'none';
                    if (matches) visible += 1;
                });

                if (postCount) {
                    postCount.textContent = visible;
                }
            });
        }
    </script>
    <script>
        // Delete popup logic
        const popup = document.querySelector('.popup');
        const deleteBtn = document.getElementById('delete');
        const cancelBtn = document.getElementById('cancel');
        const deleteTriggers = document.querySelectorAll('.delete-trigger');
        let deleteUrl = '';

        deleteTriggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                deleteUrl = trigger.dataset.deleteUrl;
                popup.classList.add('show');
            });
        });

        cancelBtn.addEventListener('click', (e) => {
            e.preventDefault();
            popup.classList.remove('show');
            deleteUrl = '';
        });

        deleteBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (deleteUrl) {
                window.location.href = deleteUrl;
            }
        });

        // Close popup when clicking outside
        popup.addEventListener('click', (e) => {
            if (e.target === popup) {
                popup.classList.remove('show');
            }
        });
    </script>
    <script>
        // Theme toggle logic
        const themeBtn = document.getElementById('theme-toggle');

        function applyTheme(theme) {
            if (theme === 'light') {
                document.body.classList.add('light-theme');
                themeBtn.innerHTML = '<i class="bi bi-moon"></i> Dark';
            } else {
                document.body.classList.remove('light-theme');
                themeBtn.innerHTML = '<i class="bi bi-sun"></i> Light';
            }
            localStorage.setItem('theme', theme);
        }
        themeBtn.addEventListener('click', () => {
            const isLight = document.body.classList.contains('light-theme');
            applyTheme(isLight ? 'dark' : 'light');
        });
        // Initialize theme from storage
        const savedTheme = localStorage.getItem('theme') || 'dark';
        applyTheme(savedTheme);
    </script>
</body>

</html>