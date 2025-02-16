<?php
final class Setup {
    private static string $rootPath;

    public static function init() {
        self::$rootPath = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR;
    }

    public static function createDirectories(array $directories) {
        foreach ($directories as $dir) {
            $path = self::$rootPath . $dir;
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
            $path = self::$rootPath . $file;
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

Setup::init();

$directories = [
    'template/caches',
    'config',
    'template/views'
];

$viewPath = self::$rootPath . 'template/views';
$cachePath = self::$rootPath . 'template/caches';

$files = [
    'config/cool-view.php' => "<?php\n\nreturn [   'ViewPath' => \"$viewPath\",\n    'CachePath' => \"$cachePath\",\n];",
];

Setup::createDirectories($directories);
Setup::createFiles($files);

$scriptPath = __FILE__;
if (file_exists($scriptPath)) {
    unlink($scriptPath);
    echo "[*] Setup script deleted: $scriptPath\n";
}