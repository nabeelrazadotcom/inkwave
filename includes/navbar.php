<?php
$isLoggedIn = !empty($_SESSION['Loggedin']);
$currentPage = basename(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '');

function iwNavActive(array $pages, string $currentPage): string
{
    return in_array($currentPage, $pages, true) ? ' is-active' : '';
}
?>

<nav class="iw-nav navbar navbar-expand-lg" aria-label="Primary navigation">
    <div class="container-fluid px-0">
        <a href="./index.php" class="iw-nav-logo">Ink<em>wave</em></a>

        <div class="iw-nav-right">
            <a href="./search.php" class="iw-nav-search text-decoration-none" aria-label="Open search">
                <i class="bi bi-search"></i>
                <span>Search</span>
            </a>

            <a href="./index.php#stream" class="iw-nav-link<?= iwNavActive(['index.php'], $currentPage) ?>">Explore</a>
            <a href="./category.php" class="iw-nav-link<?= iwNavActive(['category.php', 'category_form.php'], $currentPage) ?>">Categories</a>

            <?php if ($isLoggedIn): ?>
                <a href="./dashboard/index.php" class="iw-nav-link">Dashboard</a>
                <a href="./dashboard/create-post.php" class="iw-nav-cta">Write</a>
            <?php else: ?>
                <a href="./auth/login_form.php" class="iw-nav-link<?= iwNavActive(['login_form.php'], $currentPage) ?>">Login</a>
                <a href="./auth/register_form.php" class="iw-nav-cta<?= iwNavActive(['register_form.php'], $currentPage) ?>">Join Free</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
