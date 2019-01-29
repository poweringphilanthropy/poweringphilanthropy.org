<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4086d73bc23d7584ad92a6beec8f2092
{
    public static $files = array (
        'da253f61703e9c22a5a34f228526f05a' => __DIR__ . '/..' . '/wixel/gump/gump.class.php',
    );

    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'Jaybizzle\\CrawlerDetect\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Jaybizzle\\CrawlerDetect\\' => 
        array (
            0 => __DIR__ . '/..' . '/jaybizzle/crawler-detect/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4086d73bc23d7584ad92a6beec8f2092::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4086d73bc23d7584ad92a6beec8f2092::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
