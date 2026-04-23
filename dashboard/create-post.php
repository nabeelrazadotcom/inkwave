<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inkwave — Writing Studio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="studio">

    <!-- BACKGROUND -->
    <div class="background-flow"></div>

    <div class="studio-shell">
        <!-- TOPBAR -->
        <header class="topbar" aria-label="Studio top bar">
            <a class="brand" href="./index.php">
                <span class="brand-ink">Ink</span><span class="brand-wave">wave</span>
                <span class="brand-sub">Studio</span>
            </a>

            <div class="actions" aria-label="Primary actions">
                <button class="btn btn-outline-light btn-sm" type="button" data-soft-toast="Saved (UI demo).">Save draft</button>
                <button class="btn btn-primary btn-sm" type="button" data-soft-toast="Published (UI demo).">Publish</button>
            </div>
        </header>

        <main class="studio" aria-label="Writing studio">
            <!-- LEFT RAIL -->
            <aside class="left-rail" aria-label="Tools">
                <div class="rail-block">
                    <div class="rail-title">Tools</div>
                    <div class="tool-row">
                        <button class="chip" type="button" data-cmd="bold" title="Bold" aria-label="Bold"><span>B</span></button>
                        <button class="chip" type="button" data-cmd="italic" title="Italic" aria-label="Italic"><span><i>I</i></span></button>
                        <button class="chip" type="button" data-cmd="h1" title="Heading 1" aria-label="Heading 1"><span>H1</span></button>
                        <button class="chip" type="button" data-cmd="h2" title="Heading 2" aria-label="Heading 2"><span>H2</span></button>
                        <button class="chip" type="button" data-cmd="quote" title="Quote" aria-label="Quote"><span>Q</span></button>
                    </div>
                </div>

                <div class="rail-block">
                    <div class="rail-title">Focus</div>
                    <button class="focus-toggle" type="button" data-focus-toggle="1">Enter focus mode</button>
                </div>

                <div class="rail-block">
                    <div class="rail-title">Ritual</div>
                    <button class="ritual" type="button" data-soft-toast="Write 8 lines. No edits. No backspace.">Eight lines</button>
                    <button class="ritual" type="button" data-soft-toast="Write the last sentence first. Then earn the beginning.">Backwards</button>
                </div>
            </aside>

            <!-- PAGE -->
            <section class="page-wrap" aria-label="Editor">
                <div class="page-head">
                    <input class="title" id="iw-title" type="text" placeholder="Untitled story…" autocomplete="off" />
                    <div class="meta-row">
                        <span class="meta-pill">Draft</span>
                        <span class="meta-sep">•</span>
                        <span class="meta-note" id="iw-count">0 words</span>
                    </div>
                </div>

                <div class="page">
                    <div class="gutter" aria-hidden="true"></div>
                    <div class="editor" id="iw-editor" contenteditable="true" role="textbox" aria-multiline="true" data-placeholder="Start writing your story…"></div>
                    <textarea class="canvas" id="iw-canvas" placeholder="Start writing your story..."></textarea>
                </div>

                <div class="page-foot">
                    <button class="foot-action" type="button" data-soft-toast="Tip: Use short paragraphs. Let the white space breathe.">Writing tip</button>
                    <button class="foot-action" type="button" data-soft-toast="Tip: Draft fast. Edit slow. Publish when calm.">Publishing tip</button>
                </div>
            </section>

            <!-- RIGHT PANEL -->
            <aside class="right-rail" aria-label="Preview and settings">
                <div class="rail-block">
                    <div class="rail-title">Preview</div>
                    <div class="preview" id="iw-preview">
                        <div class="preview-title">Preview</div>
                        <div class="preview-body">Your words will appear here as you write.</div>
                    </div>
                </div>

                <div class="rail-block">
                    <div class="rail-title">Story settings</div>
                    <label class="field">
                        <span class="label">Tone</span>
                        <select class="select" aria-label="Tone">
                            <option>Reflective</option>
                            <option>Sharp</option>
                            <option>Warm</option>
                            <option>Bold</option>
                        </select>
                    </label>
                    <label class="field">
                        <span class="label">Visibility</span>
                        <select class="select" aria-label="Visibility">
                            <option>Private draft</option>
                            <option>Public</option>
                        </select>
                    </label>
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
            const pTitle = preview.querySelector('.preview-title');
            const pBody = preview.querySelector('.preview-body');
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
