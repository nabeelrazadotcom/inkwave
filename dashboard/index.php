<?php
session_start();

if (empty($_SESSION['Loggedin'])) {
    header("Location: ../auth/login_form.php");
    exit();
}

$userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;
$username = $_SESSION['username'] ?? 'Writer';
$firstName = trim(explode(' ', $username)[0]);

$stats = [
    'total_posts' => 12,
    'draft_posts' => 5,
    'published_posts' => 7,
    'categories_used' => 4,
    'latest_activity' => '2 hours ago',
    'total_views' => 1240,
];

$recentPosts = [
    ['id' => 1, 'title' => 'The Art of Slow Living', 'status' => 'published', 'category_name' => 'Lifestyle', 'updated_at' => '2 hours ago', 'view_count' => 234],
    ['id' => 2, 'title' => 'Morning Routines That Work', 'status' => 'draft', 'category_name' => 'Productivity', 'updated_at' => '1 day ago', 'view_count' => 0],
    ['id' => 3, 'title' => 'Finding Peace in Chaos', 'status' => 'published', 'category_name' => 'Mindfulness', 'updated_at' => '3 days ago', 'view_count' => 456],
    ['id' => 4, 'title' => 'The Writer\'s Block', 'status' => 'draft', 'category_name' => 'Writing', 'updated_at' => '5 days ago', 'view_count' => 0],
];

$publishRate = 58;
$weeklyTarget = 6;
$weeklyProgress = 4;

function iwMetricLabel(int $value, string $singular, string $plural): string
{
    return $value === 1 ? $singular : $plural;
}

function iwRelativeTime(?string $timestamp): string
{
    return $timestamp ?: 'No activity yet';
}

function iwFormatNumber(int $num): string
{
    if ($num >= 1000000) {
        return round($num / 1000000, 1) . 'M';
    }
    if ($num >= 1000) {
        return round($num / 1000, 1) . 'K';
    }
    return (string) $num;
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
                    <p class="iw-dash-subtitle">A cleaner view of drafts, activity, and what deserves your attention next.</p>
                </div>
                <div class="iw-dash-header-right">
                    <a href="./create-post.php" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        New Story
                    </a>
                </div>
            </header>

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
                        <i class="bi bi-eye"></i>
                    </div>
                    <div class="iw-stat-content">
                        <div class="iw-stat-value"><?= iwFormatNumber($stats['total_views']) ?></div>
                        <div class="iw-stat-label">Total Views</div>
                        <div class="iw-stat-meta">Across your published work</div>
                    </div>
                </article>
            </section>

            <div class="row g-4">
                <div class="col-xl-8">
                    <section class="iw-dash-section h-100">
                        <div class="iw-dash-section-header">
                            <h2 class="iw-dash-section-title">Recent writing</h2>
                            <a href="./posts.php?id=<?= $userId ?>" class="iw-dash-section-link">View all</a>
                        </div>

                        <div class="iw-posts-list">
                            <?php foreach ($recentPosts as $post): ?>
                                <a class="iw-post-item" href="./edit-post.php?id=<?= $post['id'] ?>">
                                    <div class="iw-post-item-status <?= $post['status'] === 'published' ? 'is-published' : 'is-draft' ?>"></div>
                                    <div class="iw-post-item-content">
                                        <div class="iw-post-item-title"><?= htmlspecialchars($post['title']) ?></div>
                                        <div class="iw-post-item-meta">
                                            <span><?= htmlspecialchars($post['category_name']) ?></span>
                                            <span class="iw-post-item-dot">•</span>
                                            <span><?= iwRelativeTime($post['updated_at']) ?></span>
                                            <?php if (!empty($post['view_count'])): ?>
                                                <span class="iw-post-item-dot">•</span>
                                                <span><?= iwFormatNumber((int) $post['view_count']) ?> views</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="iw-post-item-arrow">
                                        <i class="bi bi-chevron-right"></i>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </section>
                </div>

                <div class="col-xl-4">
                    <div class="d-grid gap-4">
                        <section class="iw-dash-section">
                            <div class="iw-dash-section-header mb-3">
                                <h2 class="iw-dash-section-title">Weekly goal</h2>
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
                                <p class="iw-goal-text"><?= $weeklyTarget - $weeklyProgress ?> more pieces to hit your weekly target.</p>
                            </div>
                        </section>

                        <section class="iw-dash-section">
                            <div class="iw-dash-section-header">
                                <h2 class="iw-dash-section-title">Writing focus</h2>
                            </div>
                            <div class="iw-status-list">
                                <div class="iw-status-row">
                                    <span class="iw-status-label">Last activity</span>
                                    <strong><?= htmlspecialchars($stats['latest_activity']) ?></strong>
                                </div>
                                <div class="iw-status-row">
                                    <span class="iw-status-label">Categories used</span>
                                    <strong><?= (int) $stats['categories_used'] ?></strong>
                                </div>
                                <div class="iw-status-row">
                                    <span class="iw-status-label">Recommended next step</span>
                                    <strong>Finish a draft and schedule a revision pass</strong>
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
