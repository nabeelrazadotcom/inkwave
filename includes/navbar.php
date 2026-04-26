<!-- Navbar - Simple Bootstrap Navigation -->
<nav class="iw-nav navbar navbar-expand-lg" aria-label="Primary navigation">
    <div class="container-fluid px-0">
        <!-- Brand Logo -->
        <a href="./index.php" class="iw-nav-logo">Ink<em>wave</em></a>

        <!-- Nav Items -->
        <div class="iw-nav-right">
            <!-- Search -->
            <a href="./search.php" class="iw-nav-search text-decoration-none" aria-label="Open search">
                <i class="bi bi-search"></i>
                <span>Search</span>
            </a>

            <!-- Explore Link -->
            <a href="./index.php#stream" class="iw-nav-link">Explore</a>

            <!-- Login/Join (shown when not logged in) -->
            <a href="./auth/login_form.php" class="iw-nav-link d-none" data-auth="guest">Login</a>
            <a href="./category_form.php" class="iw-nav-link d-none" data-auth="guest">Add Category</a>
            <a href="./auth/register_form.php" class="iw-nav-cta d-none" data-auth="guest">Join Free</a>

            <!-- Dashboard/Write (shown when logged in) -->
            <a href="./dashboard/index.php" class="iw-nav-link d-none" data-auth="user">Dashboard</a>
            <a href="./dashboard/create-post.php" class="iw-nav-cta d-none" data-auth="user">Write</a>
        </div>
    </div>
</nav>

<script>
    (function() {
        // Get current page path
        const path = window.location.pathname;

        // Set active state based on current page
        const links = document.querySelectorAll('.iw-nav-link');
        links.forEach(link => {
            const href = link.getAttribute('href');
            if (path.includes(href.replace('./', '/'))) {
                link.classList.add('is-active');
            }
        });

        // Simple session check - in production, replace with actual session check
        // This shows/hides based on a data attribute (set from server-side if needed)
        const isLoggedIn = document.body.classList.contains('logged-in');

        document.querySelectorAll('[data-auth]').forEach(el => {
            const type = el.getAttribute('data-auth');
            if ((type === 'guest' && !isLoggedIn) || (type === 'user' && isLoggedIn)) {
                el.classList.remove('d-none');
            }
        });
    })();
</script>