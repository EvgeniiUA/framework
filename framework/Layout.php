<?php

namespace framework;

/**
 * 
 */
class Layout {

    /**
     *
     * @var \framework\View
     */
    protected $_view;
    protected $_layout;

    /**
     *
     * @var bool
     */
    protected $_status = true;

    /**
     * 
     * @param string $pathToView
     */
    public function render($pathToView) {
        $this->_view->setFileView($pathToView);
        if ($this->_status) {
            // include file layout
            include $this->_layout;
        }
        else {
            $this->printContent();
        }
    }

    /**
     * 
     * @param type $view
     */
    public function __construct(&$view) {
        $this->_view   = $view;
        $front         = FrontController::getInstance();
        $module        = $front->getModule();
        $this->_layout = $_SERVER['DOCUMENT_ROOT'] . "/{$module}/layout/index.php";
    }

    /**
     * 
     */
    public function printContent() {
        $this->_view->render();
    }

    public function disable() {
        $this->_status = false;
    }

    public function enable() {
        $this->_status = true;
    }

}