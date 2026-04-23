<?php
session_start();

if (empty($_SESSION['Loggedin'])) {
    header("Location: ../auth/login_form.php");
    exit();
} 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inkwave — Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="dashboard">

    <!-- BACKGROUND -->
    <div class="background-flow"></div>


    <div class="dash">
        <!-- SIDEBAR -->
        <aside class="rail" aria-label="Dashboard navigation">
            <a class="rail-brand" href="../index.php">
                <span class="rail-mark">Ink</span><span class="rail-wave">wave</span>
            </a>

            <nav class="rail-nav">
                <a class="rail-link active" href="./index.php">
                    <span class="rail-dot"></span>
                    <span>Desk</span>
                </a>
                <a class="rail-link" href="./create-post.php">
                    <span class="rail-dot"></span>
                    <span>Studio</span>
                </a>
                <a class="rail-link" href="./posts.php?id=<?=$_SESSION['user_id'] ?>" data-soft-toast="Posts view is coming next.">
                    <span class="rail-dot"></span>
                    <span>Posts</span>
                </a>
                <a class="rail-link" href="#" data-soft-toast="Profile settings are coming next.">
                    <span class="rail-dot"></span>
                    <span>Profile</span>
                </a>
            </nav>

            <div class="rail-foot">
                <div class="rail-user">
                    <div class="avatar" aria-hidden="true"></div>
                    <div class="rail-user-meta">
                        <div class="rail-user-name"><?= $_SESSION['username'] ?></div>
                        <div class="rail-user-sub">Writer</div>
                    </div>
                </div>
                <a class="rail-logout" href="../auth/logout.php" data-soft-toast="Logout endpoint not wired yet.">Logout</a>
            </div>
        </aside>

        <!-- TOPBAR -->
        <header class="topbar" aria-label="Top actions">
            <div class="topbar-left">
                <div class="topbar-title">Your desk</div>
                <div class="topbar-sub">A quiet place to shape drafts into stories.</div>
            </div>

            <div class="topbar-right">
                <div class="dash-search" role="search">
                    <span class="dash-search-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="m20 20-3.5-3.5"></path>
                        </svg>
                    </span>
                    <input class="dash-search-input" type="search" placeholder="Search drafts, ideas, people…" />
                </div>

                <a class="btn btn-outline-light btn-sm" href="./create-post.php">New story</a>
            </div>
        </header>

        <!-- MAIN -->
        <main class="dash-main">
            <section class="hero">
                <div class="hero-card">
                    <div class="hero-kicker">Today</div>
                    <h1 class="hero-title">What wants to be written?</h1>
                    <p class="hero-copy">Inkwave is built for deliberate writing — soft focus, sharp intent, and just enough structure to keep you moving.</p>
                    <div class="hero-actions">
                        <a class="btn btn-primary btn-sm" href="./create-post.php">Open Studio</a>
                        <button class="btn btn-outline-light btn-sm" type="button" data-soft-toast="Drafts autosave when you start writing.">How it works</button>
                    </div>
                </div>

                <div class="hero-side">
                    <div class="metric">
                        <div class="metric-label">Drafts</div>
                        <div class="metric-value">—</div>
                        <div class="metric-sub">Your first shelf begins here.</div>
                    </div>
                    <div class="metric">
                        <div class="metric-label">Published</div>
                        <div class="metric-value">—</div>
                        <div class="metric-sub">Waiting for the first release.</div>
                    </div>
                    <div class="metric">
                        <div class="metric-label">Streak</div>
                        <div class="metric-value">—</div>
                        <div class="metric-sub">Built from returning to the page.</div>
                    </div>
                </div>
            </section>

            <section class="grid">
                <article class="panel panel-wide">
                    <div class="panel-head">
                        <h2 class="panel-title">Recent threads</h2>
                        <div class="panel-meta">A living shelf of unfinished thoughts.</div>
                    </div>

                    <div class="thread-list">
                        <a class="thread" href="./create-post.php">
                            <div class="thread-title">Untitled story</div>
                            <div class="thread-sub">Continue in Studio →</div>
                        </a>
                        <a class="thread" href="./create-post.php">
                            <div class="thread-title">A small essay on attention</div>
                            <div class="thread-sub">Last touched: just now</div>
                        </a>
                        <a class="thread" href="./create-post.php">
                            <div class="thread-title">Notes: the sound of rain</div>
                            <div class="thread-sub">A paragraph away from clarity</div>
                        </a>
                    </div>
                </article>

                <article class="panel">
                    <div class="panel-head">
                        <h2 class="panel-title">Ink tools</h2>
                        <div class="panel-meta">Small rituals for better writing.</div>
                    </div>

                    <div class="tool-list">
                        <button class="tool" type="button" data-soft-toast="Try writing the next 7 lines without stopping.">
                            <div class="tool-name">Seven lines</div>
                            <div class="tool-sub">Momentum warm-up</div>
                        </button>
                        <button class="tool" type="button" data-soft-toast="Write one honest sentence. Then another.">
                            <div class="tool-name">One true thing</div>
                            <div class="tool-sub">Clarity prompt</div>
                        </button>
                        <button class="tool" type="button" data-soft-toast="Describe the scene using only senses.">
                            <div class="tool-name">Senses</div>
                            <div class="tool-sub">Detail amplifier</div>
                        </button>
                    </div>
                </article>

                <article class="panel">
                    <div class="panel-head">
                        <h2 class="panel-title">Quick actions</h2>
                        <div class="panel-meta">Keep your flow uninterrupted.</div>
                    </div>

                    <div class="action-list">
                        <a class="action" href="./create-post.php">
                            <div class="action-title">Start a new draft</div>
                            <div class="action-sub">Open the Studio canvas</div>
                        </a>
                        <a class="action" href="../index.php">
                            <div class="action-title">Go to homepage</div>
                            <div class="action-sub">See what readers see</div>
                        </a>
                        <a class="action" href="#" data-soft-toast="Profile settings are coming next.">
                            <div class="action-title">Edit your profile</div>
                            <div class="action-sub">Bio, links, identity</div>
                        </a>
                    </div>
                </article>
            </section>
        </main>
    </div>

    <div class="iw-toast" role="status" aria-live="polite" aria-atomic="true"></div>

    <script>
        // tiny "soft toast" helper, purely UI (no backend impact)
        const toast = document.querySelector('.iw-toast');
        let toastTimer = null;
        document.querySelectorAll('[data-soft-toast]').forEach((el) => {
            el.addEventListener('click', () => {
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
