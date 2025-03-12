<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbd137fbdb6c1041897c823453dcd5c7a
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbd137fbdb6c1041897c823453dcd5c7a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbd137fbdb6c1041897c823453dcd5c7a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbd137fbdb6c1041897c823453dcd5c7a::$classMap;

        }, null, ClassLoader::class);
    }
}
