<?php

function firstElement($array) {
    return is_array($array) ? reset($array) : null;
}

function lastElement($array) {
    return is_array($array) ? end($array) : null;
}

function stringLength($string): ?int{
    return is_string($string) ? strlen($string) : null;
}

function trimString($string): ?string{
    return is_string($string) ? trim($string) : null;
}

function replaceString($string, $search, $replace): array|string|null{
    return is_string($string) ? str_replace($search, $replace, $string) : null;
}

function joinArray($array, $separator = ','): ?string{
    return is_array($array) ? implode($separator, $array) : null;
}

function splitString($string, $separator = ','): ?array{
    return is_string($string) ? explode($separator, $string) : null;
}

function generateSlug($string): ?string{
    if (is_string($string)) {
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
        return trim($string, '-');
    }
    return null;
}

function absValue($number): float|int|null {
    return is_numeric($number) ? abs($number) : null;
}

function capitalizeString($string) : string {
    if (is_string($string)) {
        return ucfirst(strtolower($string));
    }
    return $string;
}