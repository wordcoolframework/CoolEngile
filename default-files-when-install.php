<?php
final class Setup {
    public static function createDirectories(array $directories) {
        foreach ($directories as $dir) {
            if (!is_dir($dir)) {
                if (mkdir($dir, 0755, true)) {
                    echo "[*] Created directory: $dir\n";
                } else {
                    echo "[!] Failed to create directory: $dir\n";
                }
            }
        }
    }

    public static function createFiles(array $files) {
        foreach ($files as $file => $content) {
            if (!file_exists($file)) {
                if (file_put_contents($file, $content) !== false) {
                    echo "[*] Created file: $file\n";
                } else {
                    echo "[!] Failed to create file: $file\n";
                }
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
    'config/cool-view.php' => "<?php\n\nreturn [\n    'PrefixCharCoolEngine' => \"#\",\n    'ViewPath' => \"/template/views\",\n    'CachePath' => \"/template/caches\",\n];",
];

Setup::createDirectories($directories);
Setup::createFiles($files);

if (file_exists(__FILE__)) {
    unlink(__FILE__);
    echo "[*] Setup script deleted.\n";
}