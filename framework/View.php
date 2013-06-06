<?php

namespace framework;

class View {

    protected $_fileView;

    /**
     *
     * @var array
     */
    protected $_data;

    /**
     * @param strng $pathToViewFile - 
     */
    public function render() {
        $data = $this->_data;
        include $this->_fileView;
    }

    public function set($name, $value) {
        $this->_data[$name] = $value;
    }

    public function get($name) {
        return $this->_data[$name];
    }

    public function setFileView($fileView) {
        $this->_fileView = (string)$fileView;
    }

}