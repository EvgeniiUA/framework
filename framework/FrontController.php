<?php

/**
 *  Define namespace framework to which relation the class FrontController
 */

namespace framework;

use framework\Router as Router;

/**
 * This class is main controller and manage other controllers,
 * class implements pattern singleton.
 * 
 * @category  Framework
 * @package   Framework\FrontController
 * @author    Sinevid Evgenii
 * @version   $Id$
 */
class FrontController {

    /**
     * Link on object of this class
     * @var framework\FrontController
     */
    private static $_instance;
    private $_module = 'site';

    /**
     * Name of the controller
     * @var string	
     */
    private $_controller = 'index';

    /**
     * Name of the method of controller
     * @var string
     */
    private $_action = 'actionIndex';

    /**
     * cloning private because we implements pattern singleton 
     * @return void
     */
    private function __clone() {}

    /**
     * 
     */
    private function __construct() {
        // get route
        $route = Router::getRoute();
        $this->setController($route['controller']);
        $this->setAction($route['action']);
        $this->setModule($route['module']);

        // clear
        unset($route);

        // check current route
        $this->checkRoute();
    }

    private function setControllerError() {
        $this->_controller = 'error';
        $this->_action     = 'actionIndex';
    }

    /**
     * Метод возвращает ссылку на объект класса FrontController
     * @return FrontController
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Метод устанавливает имя контроллера
     * 
     * @param string $controller - имя контроллера 
     * @return void
     */
    public function setController($controller) {
        $this->_controller = (string) $controller;
    }

    public function getController() {
        return $this->_controller;
    }

    /**
     * Метод устанавливает дейсвтия для контроллера
     * 
     * @param string $action - имя метода контроллера
     * @return void
     */
    public function setAction($action) {
        $this->_action = (string) $action;
    }

    public function getAction() {
        return $this->_action;
    }

    public function setModule($module) {
        $this->_module = (string) $module;
    }

    public function getModule() {
        return $this->_module;
    }

    public function checkRoute() {
        $pathToController = $_SERVER['DOCUMENT_ROOT'] . '/' .
                $this->_module . '/controllers/' .
                Autoload::getFileNameByClass($this->_controller);

        if (!file_exists($pathToController)) {
            $this->setControllerError();
            return;
        }

        $module     = $this->_module;
        $controller = $this->_controller;
        $class      = "{$module}\controllers\\" . $controller;

        // check class must extends \framework\Controller
        if ($class instanceof \framework\Controller) {
            $this->setControllerError();
            return;
        }

        if (!method_exists($class, $this->_action)) {
            $this->setControllerError();
        }
    }

    /**
     * 
     */
    public function route() {
        $module     = $this->_module;
        $controller = $this->_controller;

        $class  = "{$module}\controllers\\" . $controller;
        $action = $this->_action;
        try {
            $obj = new $class();
            $obj->$action();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}