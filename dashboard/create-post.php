<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inkwave — Writing Studio</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="iw-studio">

    <!-- Background Effect -->
    <div class="iw-bg-flow"></div>

    <div class="iw-studio-shell">
        <!-- Studio Topbar -->
        <header class="iw-studio-topbar" aria-label="Studio top bar">
            <a class="iw-studio-brand" href="./index.php">
                <span class="iw-studio-brand-ink">Ink</span><span class="iw-studio-brand-wave">wave</span>
                <span class="iw-studio-brand-sub">Studio</span>
            </a>

            <div class="iw-studio-actions" aria-label="Primary actions">
                <button class="btn btn-outline-light btn-sm" type="button" data-soft-toast="Saved (UI demo).">
                    <i class="bi bi-save"></i> Save draft
                </button>
                <button class="btn btn-primary btn-sm" type="button" data-soft-toast="Published (UI demo).">
                    <i class="bi bi-check-lg"></i> Publish
                </button>
            </div>
        </header>

        <!-- Studio Layout -->
        <main class="iw-studio-layout" aria-label="Writing studio">
            <!-- Left Rail - Tools -->
            <aside class="iw-studio-left-rail" aria-label="Tools">
                <div class="iw-studio-rail-block">
                    <div class="iw-studio-rail-title">Tools</div>
                    <div class="iw-studio-tool-row">
                        <button class="iw-studio-chip" type="button" data-cmd="bold" title="Bold" aria-label="Bold">
                            <i class="bi bi-type-bold"></i>
                        </button>
                        <button class="iw-studio-chip" type="button" data-cmd="italic" title="Italic" aria-label="Italic">
                            <i class="bi bi-type-italic"></i>
                        </button>
                        <button class="iw-studio-chip" type="button" data-cmd="h1" title="Heading 1" aria-label="Heading 1">H1</button>
                        <button class="iw-studio-chip" type="button" data-cmd="h2" title="Heading 2" aria-label="Heading 2">H2</button>
                        <button class="iw-studio-chip" type="button" data-cmd="quote" title="Quote" aria-label="Quote">
                            <i class="bi bi-chat-quote"></i>
                        </button>
                    </div>
                </div>

                <div class="iw-studio-rail-block">
                    <div class="iw-studio-rail-title">Focus</div>
                    <button class="iw-studio-focus-toggle" type="button" data-focus-toggle="1">Enter focus mode</button>
                </div>

                <div class="iw-studio-rail-block">
                    <div class="iw-studio-rail-title">Ritual</div>
                    <button class="iw-studio-ritual" type="button" data-soft-toast="Write 8 lines. No edits. No backspace.">Eight lines</button>
                    <button class="iw-studio-ritual" type="button" data-soft-toast="Write the last sentence first. Then earn the beginning.">Backwards</button>
                </div>
            </aside>

            <!-- Page/Editor Area -->
            <section class="iw-studio-page-wrap" aria-label="Editor">
                <div class="iw-studio-page-head">
                    <input class="iw-studio-title-input" id="iw-title" type="text" placeholder="Untitled story…" autocomplete="off" />
                    <div class="iw-studio-meta-row">
                        <span class="iw-studio-meta-pill">Draft</span>
                        <span class="iw-studio-meta-sep">•</span>
                        <span class="iw-studio-meta-note" id="iw-count">0 words</span>
                    </div>
                </div>

                <div class="iw-studio-page">
                    <div class="iw-studio-gutter" aria-hidden="true"></div>
                    <div class="iw-studio-editor" id="iw-editor" contenteditable="true" role="textbox" aria-multiline="true" data-placeholder="Start writing your story…"></div>
                    <textarea class="iw-studio-canvas" id="iw-canvas" placeholder="Start writing your story..."></textarea>
                </div>

                <div class="iw-studio-page-foot">
                    <button class="iw-studio-foot-action" type="button" data-soft-toast="Tip: Use short paragraphs. Let the white space breathe.">
                        <i class="bi bi-lightbulb"></i> Writing tip
                    </button>
                    <button class="iw-studio-foot-action" type="button" data-soft-toast="Tip: Draft fast. Edit slow. Publish when calm.">
                        <i class="bi bi-send"></i> Publishing tip
                    </button>
                </div>
            </section>

            <!-- Right Rail - Preview and Settings -->
            <aside class="iw-studio-right-rail" aria-label="Preview and settings">
                <div class="iw-studio-rail-block">
                    <div class="iw-studio-rail-title">Preview</div>
                    <div class="iw-studio-preview" id="iw-preview">
                        <div class="iw-studio-preview-title">Preview</div>
                        <div class="iw-studio-preview-body">Your words will appear here as you write.</div>
                    </div>
                </div>

                <div class="iw-studio-rail-block">
                    <div class="iw-studio-rail-title">Story settings</div>
                    <div class="iw-studio-field">
                        <span class="iw-studio-label">Tone</span>
                        <select class="iw-studio-select" aria-label="Tone">
                            <option>Reflective</option>
                            <option>Sharp</option>
                            <option>Warm</option>
                            <option>Bold</option>
                        </select>
                    </div>
                    <div class="iw-studio-field">
                        <span class="iw-studio-label">Visibility</span>
                        <select class="iw-studio-select" aria-label="Visibility">
                            <option>Private draft</option>
                            <option>Public</option>
                        </select>
                    </div>
                </div>
            </aside>
        </main>
    </div>

    <div class="iw-toast" role="status" aria-live="polite" aria-atomic="true"></div>

    <script>
        const toast = document.querySelector('.iw-toast');
        let toastTimer = null;

        function softToast(msg) {
            if (!toast) return;
            toast.textContent = msg || '';
            toast.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => toast.classList.remove('show'), 2200);
        }

        document.querySelectorAll('[data-soft-toast]').forEach((el) => {
            el.addEventListener('click', () => softToast(el.getAttribute('data-soft-toast')));
        });

        const editor = document.getElementById('iw-editor');
        const canvas = document.getElementById('iw-canvas');
        const title = document.getElementById('iw-title');
        const count = document.getElementById('iw-count');
        const preview = document.getElementById('iw-preview');

        function getText() {
            return (editor?.innerText || '').replace(/\s+/g, ' ').trim();
        }

        function updateWordCount() {
            if (!count) return;
            const t = getText();
            const words = t ? t.split(' ').length : 0;
            count.textContent = `${words} word${words === 1 ? '' : 's'}`;
        }

        function updatePreview() {
            if (!preview) return;
            const pTitle = preview.querySelector('.iw-studio-preview-title');
            const pBody = preview.querySelector('.iw-studio-preview-body');
            if (pTitle) pTitle.textContent = title?.value?.trim() || 'Untitled story';
            if (pBody) pBody.textContent = getText() || 'Your words will appear here as you write.';
        }

        function syncHiddenTextarea() {
            if (!canvas) return;
            canvas.value = editor?.innerText || '';
        }

        function refresh() {
            syncHiddenTextarea();
            updateWordCount();
            updatePreview();
        }

        if (editor) editor.addEventListener('input', refresh);
        if (title) title.addEventListener('input', refresh);
        refresh();

        // Formatting chips (minimal + safe)
        function wrapSelection(prefix, suffix) {
            const sel = window.getSelection();
            if (!sel || sel.rangeCount === 0) return;
            const range = sel.getRangeAt(0);
            if (!editor || !editor.contains(range.commonAncestorContainer)) return;
            const text = sel.toString();
            if (!text) return;
            range.deleteContents();
            range.insertNode(document.createTextNode(`${prefix}${text}${suffix}`));
            refresh();
        }

        document.querySelectorAll('[data-cmd]').forEach((btn) => {
            btn.addEventListener('click', () => {
                const cmd = btn.getAttribute('data-cmd');
                if (cmd === 'bold') return wrapSelection('**', '**');
                if (cmd === 'italic') return wrapSelection('*', '*');
                if (cmd === 'h1') return wrapSelection('\\n# ', '');
                if (cmd === 'h2') return wrapSelection('\\n## ', '');
                if (cmd === 'quote') return wrapSelection('\\n> ', '');
            });
        });

        // Focus mode
        const focusBtn = document.querySelector('[data-focus-toggle]');
        if (focusBtn) {
            focusBtn.addEventListener('click', () => {
                document.body.classList.toggle('focus-mode');
                focusBtn.textContent = document.body.classList.contains('focus-mode') ? 'Exit focus mode' : 'Enter focus mode';
            });
        }
    </script>

</body>

</html>