<?php

final class Setup {
    public static function createDirectories(array $directories) : ? string{
        foreach ($directories as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
                echo "[*] Created directory: $dir\n";
            }
        }
    }

    public static function createFiles(array $files) : ? string{
        foreach ($files as $file => $content) {
            if (!file_exists($file)) {
                file_put_contents($file, $content);
                echo "[*] Created file: $file\n";
            }
        }
    }
}

$directories = [
    'template/caches',
    'config',
    'template/views'
];

$files = [
    'config/cool-view.php' =>
        "<?php\n\nreturn [\n    // Defines the prefix used for template directives (#if, #foreach)\n    'PrefixCharCoolEngine' => \"#\",\n\n    'ViewPath' => \"/template/views\",\n\n    'CachePath' => \"/template/caches\",\n];",
];

Setup::createDirectories($directories);
Setup::createFiles($files);

unlink(__FILE__); // delete after setup;