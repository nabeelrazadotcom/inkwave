<?php $isLoggedIn = !empty($_SESSION['Loggedin']); ?>
<footer class="iw-footer">
    <div class="iw-footer-logo">Ink<span>wave</span></div>
    <div class="iw-footer-links">
        <a href="/inkwave/index.php#stream" class="iw-footer-link">Stories</a>
        <a href="/inkwave/search.php" class="iw-footer-link">Search</a>
        <a href="/inkwave/category.php" class="iw-footer-link">Categories</a>
        <?php if ($isLoggedIn): ?>
            <a href="/inkwave/dashboard/index.php" class="iw-footer-link">Dashboard</a>
            <a href="/inkwave/dashboard/create-post.php" class="iw-footer-link">Write</a>
        <?php else: ?>
            <a href="/inkwave/auth/register_form.php" class="iw-footer-link">Join</a>
            <a href="/inkwave/auth/login_form.php" class="iw-footer-link">Sign In</a>
        <?php endif; ?>
    </div>
    <span class="iw-footer-copy">© 2026 Inkwave. Built for clear, deliberate publishing.</span>
</footer>
