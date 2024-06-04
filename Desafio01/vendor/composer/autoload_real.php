<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInita115900eca8f408f7d6a4177e4b91739
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInita115900eca8f408f7d6a4177e4b91739', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInita115900eca8f408f7d6a4177e4b91739', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInita115900eca8f408f7d6a4177e4b91739::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
