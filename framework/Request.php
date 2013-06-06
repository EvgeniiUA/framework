<?php

/**
 * Обьявляем пространство имен Framework, к которому относитса класс Request
 */

namespace framework;

/**
 *
 * @category  Framework
 * @package   Framework\Request
 * @author    Sinevid Evgenii
 * @version   $Id$
 */
class Request {

    /**
     *
     */
    protected static $_params = array();

    /**
     * Method check post data is available 
     * return bool
     */
    public static function isPost() {
        if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
            return true;
        }
        return false;
    }

    /**
     * Method return value of POST by name 
     * 
     * @param $str string - name
     * @return mixed
     */
    public static function post($str) {
        if (array_key_exists($str, $_POST)) {
            $post = $_POST[$str];
            return $post;
        }
    }

    /**
     * Method return value of GET by name 
     * @return mixed
     */
    public static function get($str) {
        if (array_key_exists($str, $_GET)) {
            $get = $_GET[$str];
            return $get;
        }
    }


    /**
     * This method setup params
     * @param array $array 
     */
    public static function setParams(array $array) {
        self::$_params = $array;
    }


    /**
     *
     */
    public static function param($param) {
        if (array_key_exists($param, self::$_params)) {
            return self::$_params[$param];
        }
    }

}