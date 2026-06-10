<?php

$dir = __DIR__ . '/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

$css_new = <<<EOD
        /* =========================================================
           RESPONSIVE FIXES INJECTED BY AUTOMATION SCRIPT
           ========================================================= */
        .table-responsive { overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch; margin-bottom: 1rem; }
        .btn-menu-mobile { display: none; background: transparent; border: none; color: #fff; font-size: 24px; cursor: pointer; padding: 0 10px; }
        .overlay-mobile { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 250; }
        .overlay-mobile.show { display: block; }
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); z-index: 300; transition: transform 0.3s ease; height: 100vh; top: 0; padding-top: 56px; }
            .sidebar.open { transform: translateX(0); }
            .main, .layout, .main-content { margin-left: 0 !important; width: 100% !important; padding-left: 0 !important; padding-right: 0 !important; }
            .topbar-brand { display: none; }
            .btn-menu-mobile { display: block; }
            .conteos { grid-template-columns: 1fr 1fr !important; }
            .filtros { flex-direction: column; align-items: stretch !important; }
            .filtros > div { width: 100%; }
            .filtros input, .filtros select { width: 100% !important; }
            .page { padding: 16px !important; }
            .topbar-user { display: none; }
        }
        @media (max-width: 480px) {
            .conteos { grid-template-columns: 1fr !important; }
        }
EOD;

$modified_count = 0;

foreach ($iterator as $file) {
    if ($file->isDir()) continue;
    if (pathinfo($file->getFilename(), PATHINFO_EXTENSION) !== 'php') continue;

    $path = $file->getPathname();
    $content = file_get_contents($path);

    if (strpos($content, 'RESPONSIVE FIXES INJECTED BY AUTOMATION SCRIPT') !== false) {
        // Regex to match the old injected CSS block and replace it
        $content = preg_replace(
            '/\/\* =========================================================\s*RESPONSIVE FIXES INJECTED BY AUTOMATION SCRIPT\s*========================================================= \*\/(.*?)\@media \(max-width: 480px\) \{\s*\.conteos \{ grid-template-columns: 1fr !important; \}\s*\}/is',
            $css_new,
            $content
        );
        file_put_contents($path, $content);
        echo "Updated: " . $path . "\n";
        $modified_count++;
    }
}

echo "Total files updated: $modified_count\n";

?>
