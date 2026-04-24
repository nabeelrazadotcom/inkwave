<?php
/**
 * Navbar Component
 * Fixed top navigation with logo, search, and auth links
 */
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$segments = array_values(array_filter(explode('/', trim($scriptName, '/'))));
$projectRoot = isset($segments[0]) ? '/' . $segments[0] : '';
?>

<nav class="site-nav">
    <!-- Brand Logo -->
    <a href="<?= $projectRoot ?>/index.php" class="iw-nav-logo">Ink<em>wave</em></a>
    
    <div class="iw-nav-right">
        <!-- Search Button -->
        <button class="iw-nav-search" type="button" aria-label="Search">
            <i class="bi bi-search"></i>
            <span>Search</span>
        </button>
        
        <!-- Login Link -->
        <a href="<?= $projectRoot ?>/auth/login_form.php" class="iw-nav-link">Login</a>
        
        <!-- Write CTA -->
        <a href="<?= $projectRoot ?>/dashboard/create-post.php" class="iw-nav-cta">Write</a>
    </div>
</nav>
