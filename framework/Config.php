<?php
/**
 * Config class file
 * @author Sinevid Evgenii (sinevid-evgenii@mail.ru)
 */

/**
 * Define namespace framework to which relation the class Config 
 */
namespace framework;

/**
 * This class 
 */
class Config {

    /**
     *
     * @var array
     */
    static protected $_config;

    /**
     *  
     * @param  string $config
     * @throws Exception
     * @return void
     */
    static public function init($config) {
        if (!file_exists($config)) {
            throw new \Exception("Fatall error: config file doesn't find  on {$config}");
        }
        $arr = include $config;
        self::$_config = $arr;
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     * @return void 
     */
    static private function set($name, $value) {
        self::$_config[$name] = $value;
    }

    /**
     * 
     * @param string $name
     * @return mixed
     */
    static public function get($name) {
        return self::$_config[$name];
    }

}
