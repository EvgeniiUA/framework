<?php
/**
 * Autoload class file
 * @author Sinevid Evgenii (sinevid-evgenii@mail.ru)
 */
 

/**
 * define namespace Framework to this file which is class Autoload 
 */
namespace framework;

/**
 * This constant defines whether the application should be in debug mode or not. Defaults to false.
 */
defined('DEBUG') or define('DEBUG', false);


/**
 * This class responsibility for autoload classes
 * based on namespace  and the name of class
 *
 * @category  Framework
 * @package   Framework/Autoload
 * @author    Sinevid Evgenii
 * @copyright 2013  
 */
class Autoload
{
    /**
     * @var string name of default method for autoloader class
     */
    const DEFAULT_AUTOLOAD_FUNCTION = 'self::load';

    /**
     * The Method build full path to file implemetns  autoloader class 
     * using namespace and the name of class 
     * 
     * @param  string $className - class name 
     * @return string - path to file
     */
    public static function getFileNameByClass($className) {
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
        return $className;
    }

    /**
     * The method  automatically load the class
     * @param string $className - class name
     * @return void
     */
    public static function load($className) {
        $fileName = self::getFileNameByClass($className);
        $path =  $_SERVER['DOCUMENT_ROOT'].'/'. $fileName;
        if (file_exists($path)) {
            include_once $path;
        } else {
            if (DEBUG) {
                throw new \Exception("File doesn't exists on path: '$path' \n");
            }
        }
    }

    /**
     * Method registers of function autoload
     * @param string $autoLoadFunction - name of function autoload
     * @return void
     */
    public static function register($autoLoadFunction = null) {
        if ($autoLoadFunction === null) {
            spl_autoload_register(self::DEFAULT_AUTOLOAD_FUNCTION);
        } else {
            spl_autoload_register($autoLoadFunction);
        }
    }

    /**
     * Method remove of function from registry
     * @param string $autoLoadFunction - name of function autoload
     * @return void
     */
    public static function unregister($autoLoadFunction = null) {
        if ($autoLoadFunction === null) {
            spl_autoload_unregister(self::DEFAULT_AUTOLOAD_FUNCTION);
        } else {
            spl_autoload_unregister($autoLoadFunction);
        }
    }
}
