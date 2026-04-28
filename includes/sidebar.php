<?php
$sidebarUser = $_SESSION['username'] ?? 'Writer';
$sidebarInitial = strtoupper(substr(trim($sidebarUser), 0, 1)) ?: 'W';
$sidebarPage = basename(str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? ''));

function iwSidebarActive(string $page, array $matches): string
{
    return in_array($page, $matches, true) ? 'active' : '';
}
?>

<aside class="iw-sidebar" aria-label="Dashboard navigation">
    <div class="iw-sidebar-brand">
        <a href="index.php" class="iw-sidebar-logo">
            <span class="iw-sidebar-logo-ink">Ink</span>
            <span class="iw-sidebar-logo-wave">wave</span>
        </a>
    </div>

    <nav class="iw-sidebar-nav">
        <div>
            <span class="iw-nav-group-label">Workspace</span>
            <a class="iw-nav-item <?= iwSidebarActive($sidebarPage, ['index.php']) ?>" href="index.php">
                <i class="bi bi-grid-1x2"></i>
                <span class="iw-nav-item-text">Desk</span>
            </a>
            <a class="iw-nav-item <?= iwSidebarActive($sidebarPage, ['create-post.php', 'add_post.php', 'edit-post.php']) ?>" href="create-post.php">
                <i class="bi bi-pen"></i>
                <span class="iw-nav-item-text">Studio</span>
            </a>
            <a class="iw-nav-item <?= iwSidebarActive($sidebarPage, ['posts.php']) ?>" href="posts.php">
                <i class="bi bi-journal-richtext"></i>
                <span class="iw-nav-item-text">Posts</span>
            </a>
        </div>

        <div>
            <span class="iw-nav-group-label">Account</span>
            <a class="iw-nav-item <?= iwSidebarActive($sidebarPage, ['profile.php']) ?>" href="profile.php">
                <i class="bi bi-person-circle"></i>
                <span class="iw-nav-item-text">Profile</span>
            </a>
            <a class="iw-nav-item" href="../index.php">
                <i class="bi bi-compass"></i>
                <span class="iw-nav-item-text">Visit site</span>
            </a>
        </div>
    </nav>

    <div class="iw-user-card">
        <div class="iw-user-avatar">
            <span id="user-initial"><?= htmlspecialchars($sidebarInitial) ?></span>
        </div>
        <div class="iw-user-info">
            <div class="iw-user-name" id="username-display"><?= htmlspecialchars($sidebarUser) ?></div>
            <div class="iw-user-role">Writer account</div>
        </div>
    </div>

    <a href="../auth/logout.php" class="iw-logout-btn">
        <i class="bi bi-box-arrow-left"></i>
        <span>Logout</span>
    </a>
</aside>
