<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1e50ada1235e793979432e6c02a9923e
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Sentiment\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Sentiment\\' => 
        array (
            0 => __DIR__ . '/..' . '/davmixcool/php-sentiment-analyzer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1e50ada1235e793979432e6c02a9923e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1e50ada1235e793979432e6c02a9923e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1e50ada1235e793979432e6c02a9923e::$classMap;

        }, null, ClassLoader::class);
    }
}
