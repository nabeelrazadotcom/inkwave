<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inkwave — Ideas Flow Here</title>
    <link rel="icon" type="image/x-icon" href="./assets/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>

    <?php include 'includes/navbar.php'; ?>

    <section class="iw-entry">
        <div class="iw-entry-ambient" aria-hidden="true"></div>
        <p class="iw-home-kicker reveal">Independent publishing for thoughtful writing</p>
        <h1 class="iw-entry-tagline">Ideas do not need noise.<br><em>They need shape.</em></h1>
        <p class="iw-entry-sub">Inkwave turns drafts, essays, journals, and reflections into a calm, readable publishing experience.</p>
        <div class="iw-home-cta-row reveal">
            <a href="<?= !empty($_SESSION['Loggedin']) ? './dashboard/create-post.php' : './auth/register_form.php' ?>" class="iw-nav-cta">Start Writing</a>
            <a href="#stream" class="iw-entry-cta">
                Explore the stream
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="iw-scroll-hint">
            <span>Scroll</span>
            <div class="iw-scroll-line"></div>
        </div>
    </section>

    <section class="iw-featured reveal">
        <div class="iw-featured-bg" aria-hidden="true"></div>
        <div class="iw-featured-label">Featured story</div>
        <h2 class="iw-featured-title">The language we lose when we stop writing by hand</h2>
        <p class="iw-featured-excerpt">A slower interface changes the weight of every sentence. When the hand resists, attention sharpens, and meaning arrives with more care.</p>
        <div class="iw-featured-meta">
            <div class="iw-featured-author">
                <div class="iw-avatar">ES</div>
                <span class="iw-author-name">Elena Sorova</span>
            </div>
            <a href="./post.php" class="iw-read-link">
                Read essay
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </section>

    <main class="iw-stream" id="stream">
        <div class="iw-stream-header">
            <span class="iw-stream-header-text">Fresh from the stream</span>
        </div>

        <article class="iw-story reveal">
            <div class="iw-story-category">Culture</div>
            <h3 class="iw-story-title">On forgetting as a form of survival</h3>
            <p class="iw-story-excerpt">Memory is less archive than current. What slips away is not always failure. Sometimes it is the mind deciding what we can still carry.</p>
            <div class="iw-story-footer">
                <div class="iw-story-author">
                    <div class="iw-avatar-sm">RK</div>
                    <span class="iw-story-author-name">Rania Khalil</span>
                </div>
                <span class="iw-story-time">7 min read</span>
            </div>
        </article>

        <article class="iw-story reveal">
            <div class="iw-story-category">Technology</div>
            <h3 class="iw-story-title">The quiet grief of every deleted draft</h3>
            <p class="iw-story-excerpt">Every erased paragraph once held a version of our thinking. The work is not only what survives. It is also the discipline of what gets cut.</p>
            <div class="iw-story-footer">
                <div class="iw-story-author">
                    <div class="iw-avatar-sm">JM</div>
                    <span class="iw-story-author-name">James Moreau</span>
                </div>
                <span class="iw-story-time">5 min read</span>
            </div>
        </article>

        <div class="iw-flow-break reveal">
            <p class="iw-flow-break-text">Slow down. Read deeper.</p>
            <div class="iw-flow-break-dot"></div>
        </div>

        <article class="iw-story reveal">
            <div class="iw-story-category">Philosophy</div>
            <h3 class="iw-story-title">What silence teaches that words cannot</h3>
            <p class="iw-story-excerpt">Not every insight arrives as language. Some of it is rhythm, pause, and the confidence to let the blank space do part of the work.</p>
            <div class="iw-story-footer">
                <div class="iw-story-author">
                    <div class="iw-avatar-sm">AT</div>
                    <span class="iw-story-author-name">Amara Tunde</span>
                </div>
                <span class="iw-story-time">9 min read</span>
            </div>
        </article>

        <div class="iw-pull-quote reveal">
            <p>"Good writing is not louder writing. It is truer writing."</p>
        </div>

        <section class="iw-long-reads reveal">
            <div class="iw-long-reads-label">Long reads</div>

            <a href="./post.php" class="iw-long-read-item text-decoration-none">
                <div class="iw-long-read-num">01</div>
                <div class="iw-long-read-content">
                    <div class="iw-long-read-title">The architecture of attention in a feed-driven world</div>
                    <div class="iw-long-read-meta">Marcus Chen · 28 min read · Media</div>
                </div>
            </a>

            <a href="./post.php" class="iw-long-read-item text-decoration-none">
                <div class="iw-long-read-num">02</div>
                <div class="iw-long-read-content">
                    <div class="iw-long-read-title">Writing in the dark: literature born from grief</div>
                    <div class="iw-long-read-meta">Farah Al-Amin · 22 min read · Essays</div>
                </div>
            </a>

            <a href="./post.php" class="iw-long-read-item text-decoration-none">
                <div class="iw-long-read-num">03</div>
                <div class="iw-long-read-content">
                    <div class="iw-long-read-title">Why quiet interfaces produce better drafts</div>
                    <div class="iw-long-read-meta">Tobias Reinhardt · 18 min read · Product thinking</div>
                </div>
            </a>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="./assets/js/script.js"></script>
</body>

</html>
