<?php
/**
 * Controller class file
 * @author Sinevid Evgenii (sinevid-evgenii@mail.ru)
 */

namespace framework;

use framework\FrontController as FrontController;
use framework\View            as View;
use framework\Layout          as Layout;

/**
 * This class are base controller and other controllers 
 * must extends this class
 * 
 * @category  Framework
 * @package   Framework\Controller
 * @author    Sinevid Evgenii
 * @version   $Id$
 */
class Controller {

    /**
     * @var \framework\View
     */
    protected $_view;

    /**
     * @var \framework\Layout
     */
    protected $_layout;

    /**
     *
     */
    public function __construct() {
        $this->_view   = new View();
        $this->_layout = new Layout($this->_view);
        $this->init();
    }

    /**
     *
     */
    public function init() {
        
    }

    /**
     * This method redirect user on other url
     * 
     * @param string $url -  
     * @return void
     */
    public function redirect($url) {
        header("Location: $url");
    }

    /**
     * This method render file view
     * 
     * @param string $view - name of file view
     * @return void
     */
    public function render($view = 'index') {
        $front      = FrontController::getInstance();
        $module     = $front->getModule();
        $pathToView = $_SERVER['DOCUMENT_ROOT'] . "/{$module}/views/" . $view . '.php';
        $this->_layout->render($pathToView);
    }

}
