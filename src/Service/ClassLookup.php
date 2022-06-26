<?php

namespace App\Service;

class ClassLookup
{
    public static function findClassesInFolder(string $folder): array
    {
        $classes = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folder, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $class = str_replace('.php', '', $file->getFilename());
                $namespace = self::getNamespaceFromFileWithRegex($file->getPathname());
                $classes[] = $namespace . '\\' . $class;
            }
        }
        return $classes;
    }

    public static function getNamespaceFromFileWithRegex(string $file): string
    {
        $content = file_get_contents($file);
        $pattern = '/namespace\s+(.*);/';
        preg_match($pattern, $content, $matches);
        return $matches[1];
    }

}