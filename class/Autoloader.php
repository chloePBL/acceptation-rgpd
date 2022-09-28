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
        if(file_exists(__DIR__ . '/' . $class . '.php')){
            require __DIR__ . '/' . $class . '.php'; 
        }
    }
}