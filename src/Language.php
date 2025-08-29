<?php

namespace Asylum\Validation;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Language
{
    private static $languages;

    private static $instance = null;

    private function __construct()
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR;

        foreach ( new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $path, RecursiveDirectoryIterator::SKIP_DOTS ) ) as $file ) {
            $language = preg_replace('/(\.php)/', '', $file->getFileName());
            $file = $file->getPathname();

            self::$languages[$language] = include $file;

        }
    }

    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new Language;
        }

        return self::$instance;
    }

    /**
     * Return array of language codes
     *
     * @return array
     */
    public function getLanguages()
    {
        return array_keys(self::$languages);
    }

    /**
     * Return array of messages
     *
     * @param string $language
     * @return array
     */
    public function getMessages(string $language)
    {
        return self::$languages[$language];
    }
}