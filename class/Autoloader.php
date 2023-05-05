<?php
/**
 * Autoloader class
 * permet de charger les class directement lorsqu'elles sont appelées
 */
class Autoloader {
    /**
     * register function
     *
     * @return void
     */
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoloadClass'));
    }
    /**
     * autoloadClass function
     *
     * @param [STRING] $class_name
     * @return void
     */
    static function autoloadClass($class){
        $paths = array(
            join(DIRECTORY_SEPARATOR, [__DIR__]),
            join(DIRECTORY_SEPARATOR, [__DIR__, "interfaces"])
        );
        foreach($paths as $path){
            $file = join(DIRECTORY_SEPARATOR, [$path, $class.".php"]);
            if(file_exists($file)){
                return require_once $file;
            }
        }
    }
}