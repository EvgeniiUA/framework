<?php
/**
 * Application class file
 * @author Sinevid Evgenii (sinevid-evgenii@mail.ru)
 */
 
/**
 * Define namespace framework to which relation the class Application 
 */
namespace framework;

/**
 * This constant defines whether the application should be in debug mode or not. Defaults to false.
 */
defined('DEBUG') or define('DEBUG', false);

// include Autoload
require_once './framework/Autoload.php';
\framework\Autoload::register();

use framework\Config          as Config;
use framework\FrontController as FrontController;

/**
 * This is the main class of application  his responsibility run application 
 * and transfer control to the front controller
 * 
 * @category  Framework
 * @package   Framework\Application
 * @author    Sinevid Evgenii (sinevid-evgenii@mail.ru)
 * @version   $Id$
 */
class Application {

    /**
     * Link on object of this class
     * @var Application
     */
    private static $_instance;
 
    /**
     * Link on object of FrontController
     * @var framework\FrontController
     */
    protected $_front;

    /**
     * construct private because we implements pattern singleton 
     * @return void
     */
    private function __construct($config) {

        try {
            Config::init($config);
            Router::init();
            $this->_front = FrontController::getInstance();
        } catch (Exception $e) {
            if (DEBUG) {
                echo $e->getMessage();
            }
        }
    }

    /**
     * cloning private because we implements pattern singleton 
     * @return void
     */
    private function __clone(){}

    /**
     * Method return link to object on class Application
     * @return Application
     */
    public static function getInstance($config = './framework/defaultConfig.php') {
        if (self::$_instance === null) {
            self::$_instance = new self($config);
        }
        return self::$_instance;
    }

    /**
     * Method run application
     * @return void
     */
    public function run() {
        try {
            $this->_front->route();
        } catch (Exception $e) {
            if (DEBUG) {
                echo $e->getMessage();
            }
        }
    }

}