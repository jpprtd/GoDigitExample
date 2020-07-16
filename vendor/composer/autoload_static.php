<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita87867e698b694331dd798e83d00a40c
{
    public static $prefixLengthsPsr4 = array (
        'm' => 
        array (
            'myDatabaseUtils\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'myDatabaseUtils\\' => 
        array (
            0 => __DIR__ . '/..' . '/jpprt/myfunc/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita87867e698b694331dd798e83d00a40c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita87867e698b694331dd798e83d00a40c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
