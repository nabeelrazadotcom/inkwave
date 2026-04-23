<?php
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$segments = array_values(array_filter(explode('/', trim($scriptName, '/'))));
$projectRoot = isset($segments[0]) ? '/' . $segments[0] : '';
?>

<nav class="site-nav">
    <a href="<?= $projectRoot ?>/index.php" class="nav-logo">Ink<em>wave</em></a>
    <div class="nav-right">
        <button class="nav-search" type="button" aria-label="Search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35" />
            </svg>
            <span>Search</span>
        </button>
        <a href="<?= $projectRoot ?>/auth/login_form.php">Login</a>
        <a href="<?= $projectRoot ?>/dashboard/create-post.php" class="nav-write">Write</a>
    </div>
</nav>
