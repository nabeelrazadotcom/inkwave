<?php
session_start();

if (empty($_SESSION['Loggedin'])) {
    header("Location: ../auth/login_form.php");
    exit();
}

require_once '../config/db.php';

$userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;
$username = $_SESSION['username'] ?? 'Writer';
$firstName = trim(explode(' ', $username)[0]);

$stats = [
    'total_posts' => 0,
    'draft_posts' => 0,
    'published_posts' => 0,
    'categories_used' => 0,
];
$recentPosts = [];
$dbWarning = null;

function iwMetricLabel(int $value, string $singular, string $plural): string
{
    return $value === 1 ? $singular : $plural;
}

function iwRelativeTime(?string $timestamp): string
{
    if (!$timestamp) {
        return 'No activity yet';
    }

    $seconds = time() - strtotime($timestamp);
    if ($seconds < 60) {
        return 'Just now';
    }
    if ($seconds < 3600) {
        return floor($seconds / 60) . ' min ago';
    }
    if ($seconds < 86400) {
        return floor($seconds / 3600) . ' hours ago';
    }
    if ($seconds < 604800) {
        return floor($seconds / 86400) . ' days ago';
    }
    return date('M j, Y', strtotime($timestamp));
}

function iwGetGreeting(): string
{
    $hour = (int) date('H');
    if ($hour < 12) {
        return 'Good morning';
    }
    if ($hour < 17) {
        return 'Good afternoon';
    }
    return 'Good evening';
}

try {
    $statsStmt = mysqli_prepare(
        $db_connect,
        "SELECT
            COUNT(*) AS total_posts,
            SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) AS draft_posts,
            SUM(CASE WHEN status = 'publish' THEN 1 ELSE 0 END) AS published_posts,
            COUNT(DISTINCT category_id) AS categories_used
         FROM posts
         WHERE user_id = ?"
    );
    $statsStmt->bind_param("i", $userId);
    $statsStmt->execute();
    $statsResult = $statsStmt->get_result()->fetch_assoc();

    if ($statsResult) {
        $stats = [
            'total_posts' => (int) ($statsResult['total_posts'] ?? 0),
            'draft_posts' => (int) ($statsResult['draft_posts'] ?? 0),
            'published_posts' => (int) ($statsResult['published_posts'] ?? 0),
            'categories_used' => (int) ($statsResult['categories_used'] ?? 0),
        ];
    }

    $recentStmt = mysqli_prepare(
        $db_connect,
        "SELECT posts.id, posts.title, posts.status, categories.name AS category_name, posts.created_at, posts.updated_at
         FROM posts
         LEFT JOIN categories ON posts.category_id = categories.id
         WHERE posts.user_id = ?
         ORDER BY COALESCE(posts.updated_at, posts.created_at) DESC
         LIMIT 5"
    );
    $recentStmt->bind_param("i", $userId);
    $recentStmt->execute();
    $recentPosts = $recentStmt->get_result()->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    $dbWarning = $e->getMessage();
}

$publishRate = $stats['total_posts'] > 0 ? (int) round(($stats['published_posts'] / $stats['total_posts']) * 100) : 0;
$weeklyTarget = 4;
$weeklyProgress = min($weeklyTarget, $stats['published_posts'] + ($stats['draft_posts'] > 0 ? 1 : 0));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Inkwave</title>
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
                    <div class="iw-dash-greeting"><?= iwGetGreeting() ?>, <?= htmlspecialchars($firstName) ?></div>
                    <h1 class="iw-dash-title">Your writing desk</h1>
                    <p class="iw-dash-subtitle">A clearer home for your drafts, published work, and the next action that deserves your attention.</p>
                </div>
                <div class="iw-dash-header-right">
                    <a href="./create-post.php" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        New Story
                    </a>
                </div>
            </header>

            <?php if (!empty($dbWarning)): ?>
                <div class="alert alert-warning iw-inline-alert" role="alert">
                    <?= htmlspecialchars($dbWarning) ?>
                </div>
            <?php endif; ?>

            <section class="iw-stats-grid mb-4">
                <article class="iw-stat-card iw-stat-card-primary">
                    <div class="iw-stat-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="iw-stat-content">
                        <div class="iw-stat-value"><?= $stats['total_posts'] ?></div>
                        <div class="iw-stat-label">Total Posts</div>
                        <div class="iw-stat-meta"><?= iwMetricLabel($stats['total_posts'], 'piece created', 'pieces created') ?></div>
                    </div>
                </article>

                <article class="iw-stat-card">
                    <div class="iw-stat-icon iw-stat-icon-draft">
                        <i class="bi bi-pencil"></i>
                    </div>
                    <div class="iw-stat-content">
                        <div class="iw-stat-value"><?= $stats['draft_posts'] ?></div>
                        <div class="iw-stat-label">Drafts</div>
                        <div class="iw-stat-meta"><?= iwMetricLabel($stats['draft_posts'], 'draft in progress', 'drafts in progress') ?></div>
                    </div>
                </article>

                <article class="iw-stat-card">
                    <div class="iw-stat-icon iw-stat-icon-published">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="iw-stat-content">
                        <div class="iw-stat-value"><?= $stats['published_posts'] ?></div>
                        <div class="iw-stat-label">Published</div>
                        <div class="iw-stat-meta"><?= $publishRate ?>% publish rate</div>
                    </div>
                </article>

                <article class="iw-stat-card">
                    <div class="iw-stat-icon iw-stat-icon-views">
                        <i class="bi bi-grid"></i>
                    </div>
                    <div class="iw-stat-content">
                        <div class="iw-stat-value"><?= $stats['categories_used'] ?></div>
                        <div class="iw-stat-label">Categories Used</div>
                        <div class="iw-stat-meta"><?= iwMetricLabel($stats['categories_used'], 'active category', 'active categories') ?></div>
                    </div>
                </article>
            </section>

            <div class="row g-4">
                <div class="col-xl-8">
                    <section class="iw-dash-section h-100">
                        <div class="iw-dash-section-header">
                            <h2 class="iw-dash-section-title">Recent writing</h2>
                            <a href="./posts.php" class="iw-dash-section-link">View all</a>
                        </div>

                        <?php if (!empty($recentPosts)): ?>
                            <div class="iw-posts-list">
                                <?php foreach ($recentPosts as $post): ?>
                                    <?php $activityDate = !empty($post['updated_at']) ? $post['updated_at'] : $post['created_at']; ?>
                                    <a class="iw-post-item" href="./edit-post.php?id=<?= (int) $post['id'] ?>">
                                        <div class="iw-post-item-status <?= $post['status'] === 'publish' ? 'is-published' : 'is-draft' ?>"></div>
                                        <div class="iw-post-item-content">
                                            <div class="iw-post-item-title"><?= htmlspecialchars($post['title']) ?></div>
                                            <div class="iw-post-item-meta">
                                                <span><?= htmlspecialchars($post['category_name'] ?? 'Uncategorized') ?></span>
                                                <span class="iw-post-item-dot">•</span>
                                                <span><?= iwRelativeTime($activityDate) ?></span>
                                            </div>
                                        </div>
                                        <div class="iw-post-item-arrow">
                                            <i class="bi bi-chevron-right"></i>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="iw-empty-state">
                                <div class="iw-empty-state-icon"><i class="bi bi-feather"></i></div>
                                <h2 class="iw-empty-state-title">No writing yet</h2>
                                <p class="iw-empty-state-text">Open the studio and create your first story. It will appear here as soon as you save it.</p>
                            </div>
                        <?php endif; ?>
                    </section>
                </div>

                <div class="col-xl-4">
                    <div class="d-grid gap-4">
                        <section class="iw-dash-section">
                            <div class="iw-dash-section-header mb-3">
                                <h2 class="iw-dash-section-title">Weekly rhythm</h2>
                                <span class="iw-dash-section-badge"><?= $weeklyProgress ?>/<?= $weeklyTarget ?></span>
                            </div>
                            <div class="iw-goal-card">
                                <div class="iw-goal-progress">
                                    <?php for ($i = 1; $i <= $weeklyTarget; $i++): ?>
                                        <div class="iw-goal-day <?= $i <= $weeklyProgress ? 'is-complete' : '' ?>">
                                            <span class="iw-goal-day-number"><?= $i ?></span>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                                <p class="iw-goal-text">
                                    <?= max(0, $weeklyTarget - $weeklyProgress) ?> more sessions to hit this week’s writing target.
                                </p>
                            </div>
                        </section>

                        <section class="iw-dash-section">
                            <div class="iw-dash-section-header">
                                <h2 class="iw-dash-section-title">Writing focus</h2>
                            </div>
                            <div class="iw-status-list">
                                <div class="iw-status-row">
                                    <span class="iw-status-label">Published stories</span>
                                    <strong><?= $stats['published_posts'] ?></strong>
                                </div>
                                <div class="iw-status-row">
                                    <span class="iw-status-label">Drafts waiting</span>
                                    <strong><?= $stats['draft_posts'] ?></strong>
                                </div>
                                <div class="iw-status-row">
                                    <span class="iw-status-label">Recommended next step</span>
                                    <strong><?= $stats['draft_posts'] > 0 ? 'Pick one draft and finish the next revision pass' : 'Start a fresh draft in the studio' ?></strong>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>

</html>
