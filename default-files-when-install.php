<?php
final class Setup {

    public static function createDirectories(array $directories) {
        foreach ($directories as $dir) {
            $path = getcwd() . DIRECTORY_SEPARATOR . $dir;
            if (!is_dir($path)) {
                if (mkdir($path, 0755, true)) {
                    echo "[*] Created directory: $path\n";
                } else {
                    echo "[!] Failed to create directory: $path\n";
                }
            }
        }
    }

    public static function createFiles(array $files) {
        foreach ($files as $file => $content) {
            $path = getcwd() . DIRECTORY_SEPARATOR . $file;
            if (!file_exists($path)) {
                if (file_put_contents($path, $content) !== false) {
                    echo "[*] Created file: $path\n";
                } else {
                    echo "[!] Failed to create file: $path\n";
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