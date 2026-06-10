<?php

$dir = __DIR__ . '/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

$css_injection = <<<EOD

        /* =========================================================
           RESPONSIVE FIXES INJECTED BY AUTOMATION SCRIPT
           ========================================================= */
        .table-responsive { overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch; margin-bottom: 1rem; }
        .btn-menu-mobile { display: none; background: transparent; border: none; color: #fff; font-size: 24px; cursor: pointer; padding: 0 10px; }
        .overlay-mobile { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 250; }
        .overlay-mobile.show { display: block; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); z-index: 300; transition: transform 0.3s ease; height: 100vh; top: 0; padding-top: 56px; }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; width: 100%; padding-left: 0; padding-right: 0; }
            .topbar-brand { display: none; }
            .btn-menu-mobile { display: block; }
            .conteos { grid-template-columns: 1fr 1fr !important; }
            .filtros { flex-direction: column; align-items: stretch !important; }
            .filtros > div { width: 100%; }
            .filtros input, .filtros select { width: 100% !important; }
            .page { padding: 16px; }
            .topbar-user { display: none; }
        }
        @media (max-width: 480px) {
            .conteos { grid-template-columns: 1fr !important; }
        }
EOD;

$overlay_html = <<<EOD

<!-- Mobile Overlay -->
<div id="sidebar-overlay-mobile" class="overlay-mobile" onclick="document.querySelector('.sidebar').classList.remove('open'); this.classList.remove('show');"></div>
EOD;

$btn_html = <<<EOD
<button type="button" class="btn-menu-mobile" onclick="document.querySelector('.sidebar').classList.toggle('open'); document.getElementById('sidebar-overlay-mobile').classList.toggle('show');">&#9776;</button>
EOD;

$modified_count = 0;

foreach ($iterator as $file) {
    if ($file->isDir()) continue;
    if (pathinfo($file->getFilename(), PATHINFO_EXTENSION) !== 'php') continue;

    $path = $file->getPathname();
    $content = file_get_contents($path);

    // Only process standalone HTML files
    if (stripos($content, '<!DOCTYPE html>') === false) {
        continue;
    }

    // Skip if already processed
    if (strpos($content, 'RESPONSIVE FIXES INJECTED BY AUTOMATION SCRIPT') !== false) {
        continue;
    }

    $modified = false;

    // 1. Inject CSS
    if (strpos($content, '</style>') !== false) {
        $content = str_replace('</style>', $css_injection . "\n    </style>", $content);
        $modified = true;
    }

    // 2. Wrap tables in .table-responsive
    // Regex matches <table> ... </table> and handles nested attributes
    $content = preg_replace('/(<table\b[^>]*>.*?<\/table>)/is', '<div class="table-responsive">$1</div>', $content);

    // 3. Inject Overlay after <body>
    if (preg_match('/<body[^>]*>/i', $content, $matches)) {
        $body_tag = $matches[0];
        $content = str_replace($body_tag, $body_tag . $overlay_html, $content);
        $modified = true;
    }

    // 4. Inject Hamburger Button into .topbar
    // Search for <div class="topbar">
    if (preg_match('/<div\s+class="[^"]*topbar[^"]*"[^>]*>/i', $content, $matches)) {
        $topbar_tag = $matches[0];
        $content = str_replace($topbar_tag, $topbar_tag . "\n    " . $btn_html, $content);
        $modified = true;
    }

    if ($modified) {
        file_put_contents($path, $content);
        echo "Modified: " . $path . "\n";
        $modified_count++;
    }
}

echo "Total files modified: $modified_count\n";

?>
