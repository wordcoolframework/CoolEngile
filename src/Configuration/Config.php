<?php

namespace Configuration;

final class Config {

    protected static array $config = [];

    public static function get(string $key, string|int|null $default = null){

        $parts = self::separationFileAndKey($key, ".");

//        example : app.platform  => app is file | platform in key config
        if (self::countSeparationPartsIsTwo($parts)) {

            $file = self::getPart(partName: 'file', part: $parts);
            $key  = self::getPart(partName: 'key', part: $parts);

            if (!isset(self::$config[$file])) {

                $path = self::getConfigPath($file);

                if (file_exists($path)) {
                    self::$config[$file] = include $path;
                } else {
                    return $default;
                }
            }

            return self::$config[$file][$key] ?? $default;
        }
        return $default;
    }


    private static function separationFileAndKey(
        string $key, string $character = "."
    ) : ?array {
        return explode($character, $key);
    }

    private static function countSeparationPartsIsTwo(?array $parts) : bool{
        return count($parts) === 2;
    }

    private static function getPart(
        string $partName, $part
    ) : ? string{
        if($partName === 'file'){
            $part = $part[0];
        }
        if($partName === 'key'){
            $part = $part[1];
        }

        return $part;
    }

    private static function getConfigPath(string $file) : ? string {
        return getcwd() . "/config/$file.php";
    }

}