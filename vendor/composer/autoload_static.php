<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit392259f6b265132f6d1aef65eb09f169
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit392259f6b265132f6d1aef65eb09f169::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit392259f6b265132f6d1aef65eb09f169::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
