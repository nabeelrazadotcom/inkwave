<?php
session_start();

if (empty($_SESSION['Loggedin'])) {
    header("Location: ../auth/login_form.php");
    exit();
}

$userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;
$username = $_SESSION['username'] ?? 'Writer';
$firstName = trim(explode(' ', $username)[0]);

// Dummy data for frontend display
$stats = [
    'total_posts' => 12,
    'draft_posts' => 5,
    'published_posts' => 7,
    'categories_used' => 4,
    'latest_activity' => '2 hours ago',
    'total_views' => 1240,
    'total_likes' => 89,
];

$recentPosts = [
    ['id' => 1, 'title' => 'The Art of Slow Living', 'status' => 'published', 'category_name' => 'Lifestyle', 'updated_at' => '2 hours ago', 'view_count' => 234],
    ['id' => 2, 'title' => 'Morning Routines That Work', 'status' => 'draft', 'category_name' => 'Productivity', 'updated_at' => '1 day ago', 'view_count' => 0],
    ['id' => 3, 'title' => 'Finding Peace in Chaos', 'status' => 'published', 'category_name' => 'Mindfulness', 'updated_at' => '3 days ago', 'view_count' => 456],
    ['id' => 4, 'title' => 'The Writer\'s Block', 'status' => 'draft', 'category_name' => 'Writing', 'updated_at' => '5 days ago', 'view_count' => 0],
    ['id' => 5, 'title' => 'Digital Minimalism', 'status' => 'published', 'category_name' => 'Technology', 'updated_at' => '1 week ago', 'view_count' => 189],
];

$publishRate = 58;
$weeklyTarget = 6;
$weeklyProgress = 4;

// Helper functions
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
    if ($num >= 1000000) return round($num / 1000000, 1) . 'M';
    if ($num >= 1000) return round($num / 1000, 1) . 'K';
    return (string) $num;
}

function iwGetGreeting(): string
{
    $hour = date('H');
    if ($hour < 12) return 'Good morning';
    if ($hour < 17) return 'Good afternoon';
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
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="iw-dashboard">

    <!-- Dashboard Background Effects -->
    <div class="iw-dashboard-backdrop" aria-hidden="true">
        <div class="iw-dashboard-orb iw-dashboard-orb-a"></div>
        <div class="iw-dashboard-orb iw-dashboard-orb-b"></div>
        <div class="iw-dashboard-grid-glow"></div>
    </div>

    <div class="iw-dashboard-layout">
        <!-- Sidebar Navigation -->
        <aside class="iw-sidebar" aria-label="Dashboard navigation">
            <div class="iw-sidebar-brand">
                <a href="./index.php" class="iw-sidebar-logo">
                    <span class="iw-sidebar-logo-ink">Ink</span>
                    <span class="iw-sidebar-logo-wave">wave</span>
                </a>
            </div>
            
            <nav class="iw-sidebar-nav">
                <!-- Writing Section -->
                <div class="iw-nav-group-label">Writing</div>
                
                <a class="iw-nav-item active" href="./index.php">
                    <i class="bi bi-grid-1x2"></i>
                    <span class="iw-nav-item-text">Desk</span>
                </a>
                
                <a class="iw-nav-item" href="./create-post.php">
                    <i class="bi bi-plus-lg"></i>
                    <span class="iw-nav-item-text">Studio</span>
                </a>
                
                <a class="iw-nav-item" href="./posts.php?id=<?= $_SESSION['user_id'] ?>">
                    <i class="bi bi-file-text"></i>
                    <span class="iw-nav-item-text">Posts</span>
                </a>

                <!-- Personal Section -->
                <div class="iw-nav-group-label">Personal</div>
                
                <a class="iw-nav-item" href="#">
                    <i class="bi bi-person"></i>
                    <span class="iw-nav-item-text">Profile</span>
                </a>
                
                <a class="iw-nav-item" href="#">
                    <i class="bi bi-gear"></i>
                    <span class="iw-nav-item-text">Settings</span>
                </a>
            </nav>

            <!-- User Card -->
            <div class="iw-user-card">
                <div class="iw-user-avatar">
                    <span><?= strtoupper(substr($username, 0, 1)) ?></span>
                </div>
                <div class="iw-user-info">
                    <div class="iw-user-name"><?= htmlspecialchars($username) ?></div>
                    <div class="iw-user-role">Writer</div>
                </div>
            </div>
            
            <!-- Logout Button -->
            <a href="../auth/logout.php" class="iw-logout-btn">
                <i class="bi bi-box-arrow-left"></i>
                <span>Logout</span>
            </a>
        </aside>

        <!-- Main Content Area -->
        <main class="iw-dashboard-main flex-grow-1">
            <!-- Dashboard Header -->
            <header class="iw-dash-header">
                <div class="iw-dash-header-left">
                    <div class="iw-dash-greeting"><?= iwGetGreeting() ?>, <?= htmlspecialchars($firstName) ?></div>
                    <h1 class="iw-dash-title">Your writing desk</h1>
                    <p class="iw-dash-subtitle"><?= $stats['total_posts'] > 0 ? 'Here\'s what\'s happening with your writing.' : 'Ready to start your first piece?' ?></p>
                </div>
                <div class="iw-dash-header-right">
                    <a href="./create-post.php" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        New Story
                    </a>
                </div>
            </header>

            <!-- Stats Grid -->
            <section class="iw-stats-grid mb-4">
                <article class="iw-stat-card iw-stat-card-primary">
                    <div class="iw-stat-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="iw-stat-content">
                        <div class="iw-stat-value"><?= $stats['total_posts'] ?></div>
                        <div class="iw-stat-label">Total Posts</div>
                        <div class="iw-stat-meta"><?= $stats['total_posts'] === 0 ? 'Start writing!' : iwMetricLabel($stats['total_posts'], 'piece created', 'pieces created') ?></div>
                    </div>
                </article>

                <article class="iw-stat-card">
                    <div class="iw-stat-icon iw-stat-icon-draft">
                        <i class="bi bi-pencil"></i>
                    </div>
                    <div class="iw-stat-content">
                        <div class="iw-stat-value"><?= $stats['draft_posts'] ?></div>
                        <div class="iw-stat-label">Drafts</div>
                        <div class="iw-stat-meta"><?= $stats['draft_posts'] === 0 ? 'All published!' : iwMetricLabel($stats['draft_posts'], 'in progress', 'in progress') ?></div>
                    </div>
                </article>

                <article class="iw-stat-card">
                    <div class="iw-stat-icon iw-stat-icon-published">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="iw-stat-content">
                        <div class="iw-stat-value"><?= $stats['published_posts'] ?></div>
                        <div class="iw-stat-label">Published</div>
                        <div class="iw-stat-meta"><?= $publishRate ?>% of total</div>
                    </div>
                </article>

                <article class="iw-stat-card">
                    <div class="iw-stat-icon iw-stat-icon-views">
                        <i class="bi bi-eye"></i>
                    </div>
                    <div class="iw-stat-content">
                        <div class="iw-stat-value"><?= iwFormatNumber($stats['total_views']) ?></div>
                        <div class="iw-stat-label">Total Views</div>
                        <div class="iw-stat-meta"><?= $stats['total_views'] === 0 ? 'Share to get views!' : 'across all posts' ?></div>
                    </div>
                </article>
            </section>

            <!-- Main Grid -->
            <div class="row g-4">
                <!-- Recent Posts (Left Column) -->
                <div class="col-lg-8">
                    <section class="iw-dash-section">
                        <div class="iw-dash-section-header">
                            <h2 class="iw-dash-section-title">Recent Writing</h2>
                            <a href="./posts.php?id=<?= $userId ?>" class="iw-dash-section-link">View all</a>
                        </div>

                        <?php if (!empty($recentPosts)): ?>
                            <div class="iw-posts-list">
                                <?php foreach ($recentPosts as $post): ?>
                                    <a class="iw-post-item" href="./edit-post.php?id=<?= $post['id'] ?>">
                                        <div class="iw-post-item-status <?= $post['status'] === 'published' ? 'is-published' : 'is-draft' ?>"></div>
                                        <div class="iw-post-item-content">
                                            <div class="iw-post-item-title"><?= htmlspecialchars($post['title'] ?: 'Untitled') ?></div>
                                            <div class="iw-post-item-meta">
                                                <span class="iw-post-item-category"><?= htmlspecialchars($post['category_name'] ?? 'Uncategorized') ?></span>
                                                <span class="iw-post-item-dot">•</span>
                                                <span><?= iwRelativeTime($post['updated_at'] ?: $post['created_at']) ?></span>
                                                <?php if (isset($post['view_count']) && $post['view_count'] > 0): ?>
                                                    <span class="iw-post-item-dot">•</span>
                                                    <span><?= iwFormatNumber($post['view_count']) ?> views</span>
                                                <?php endif; ?>
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
                                <div class="iw-empty-state-icon">
                                    <i class="bi bi-file-earmark"></i>
                                </div>
                                <h3 class="iw-empty-state-title">No posts yet</h3>
                                <p class="iw-empty-state-text">Start your writing journey by creating your first story.</p>
                                <a href="./create-post.php" class="btn btn-outline-light btn-sm">Create First Post</a>
                            </div>
                        <?php endif; ?>
                    </section>
                </div>

                <!-- Weekly Goal (Right Column) -->
                <div class="col-lg-4">
                    <section class="iw-dash-section">
                        <div class="iw-dash-section-header mb-3">
                            <h2 class="iw-dash-section-title">Weekly Goal</h2>
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
                                <?php if ($weeklyProgress >= $weeklyTarget): ?>
                                    🎉 Goal achieved! Keep the momentum going.
                                <?php elseif ($weeklyProgress > 0): ?>
                                    <?= $weeklyTarget - $weeklyProgress ?> more to reach your weekly target.
                                <?php else: ?>
                                    Write <?= $weeklyTarget ?> posts this week to build your habit.
                                <?php endif; ?>
                            </p>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>

    <div class="iw-toast" role="status" aria-live="polite" aria-atomic="true"></div>

    <script>
        const toast = document.querySelector('.iw-toast');
        let toastTimer = null;
        document.querySelectorAll('[data-soft-toast]').forEach((el) => {
            el.addEventListener('click', (e) => {
                e.preventDefault();
                if (!toast) return;
                toast.textContent = el.getAttribute('data-soft-toast') || '';
                toast.classList.add('show');
                clearTimeout(toastTimer);
                toastTimer = setTimeout(() => toast.classList.remove('show'), 2600);
            });
        });
    </script>

</body>

</html>