<?php
session_start();

if (empty($_SESSION['Loggedin'])) {
    header("Location: ../auth/login_form.php");
    exit();
}

$posts = [
    ['title' => 'The Art of Slow Living', 'status' => 'Published', 'updated' => '2 hours ago', 'category' => 'Lifestyle'],
    ['title' => 'Morning Routines That Work', 'status' => 'Draft', 'updated' => '1 day ago', 'category' => 'Productivity'],
    ['title' => 'Finding Peace in Chaos', 'status' => 'Published', 'updated' => '3 days ago', 'category' => 'Mindfulness'],
    ['title' => 'The Writer\'s Block', 'status' => 'Draft', 'updated' => '5 days ago', 'category' => 'Writing'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts — Inkwave</title>
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
                    <div class="iw-dash-greeting">Library</div>
                    <h1 class="iw-dash-title">Your posts</h1>
                    <p class="iw-dash-subtitle">A cleaner view of every draft and published story.</p>
                </div>
                <div class="iw-dash-header-right">
                    <a href="./create-post.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Story</a>
                </div>
            </header>

            <section class="iw-dash-section">
                <div class="iw-table-toolbar">
                    <div class="iw-table-filter">
                        <i class="bi bi-search"></i>
                        <input type="text" class="iw-studio-input" placeholder="Search titles">
                    </div>
                    <span class="iw-dash-section-badge"><?= count($posts) ?> items</span>
                </div>

                <div class="table-responsive">
                    <table class="table iw-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Category</th>
                                <th>Updated</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td>
                                        <div class="iw-table-title"><?= htmlspecialchars($post['title']) ?></div>
                                    </td>
                                    <td><span class="iw-badge-soft <?= $post['status'] === 'Published' ? 'is-success' : 'is-warning' ?>"><?= htmlspecialchars($post['status']) ?></span></td>
                                    <td><?= htmlspecialchars($post['category']) ?></td>
                                    <td><?= htmlspecialchars($post['updated']) ?></td>
                                    <td class="text-end"><a href="./edit-post.php" class="iw-dash-section-link">Edit</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
