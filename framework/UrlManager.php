<?php
/**
 * UrlManager class file
 * @author Sinevid Evgenii (sinevid-evgenii@mail.ru)
 */

/**
 *  Define namespace framework to which relation the class UrlManager
 */
namespace framework;

/**
 * Class responsibility for:
 * - register url alias;
 * - get registered route by url alias
 * 
 * @category  Framework
 * @package   Framework\UrlManager
 * @author    Sinevid Evgenii (sinevid-evgenii@mail.ru)
 * @version   $Id$
 */
class UrlManager {

    /**
     * url aliases
     * @var array
     */
    protected static $_aliases;

    /**
     * registered routes for aliases
     * @var array
     */
    protected static $_route;

    /**
     * @var int count of routes
     */
    private static $_count = 0;

    /**
     * This method registers an alias for the url and save route, params for 
     * this url.
     *  
     * Notice: if send the parameters wrong the  method throw Exception.
     * 
     * Example:
     * 
     * // notice: action name should start with the word 'action'
     * UrlManager::registerAliasUrl('/some-url',
     *                                    array( 'module'     => 'someModule',
     *                                           'controller' => 'someController',
     *                                           'action'     => 'actionSomeAction'
     * 										   ),
     *                                    array(
     *                                           'id'   => 1,
     *                                           'name' => 'framework'
     *                                         )
     *                                 );
     *
     * @param string $url    - alias for url in format '/like-this/ok'  without get params
     * @param array  $route  - an array containing full route to the 
     *                         'module', 'controller', 'action' 
     * @param array  $params - its optional param the array containing params in format key => value
     * @return void
     */
    public static function registerAliasUrl($url, array $route, array $params = null) {
        // check input data
        if (!is_string($url)) {
            throw new \Exception('url must be string');
        } elseif (!isset($route['module'])) {
            throw new \Exception("error: Parameter route must contain the required key 'module'");
        } elseif (!isset($route['controller'])) {
            throw new \Exception("error: Parameter route must contain the required key 'controller'");
        } elseif (!isset($route['action'])) {
            throw new \Exception("error: Parameter route must contain the required key 'action'");
        }
        self::$_aliases[self::$_count] = $url;
        self::$_route[self::$_count] = array('module'     => $route['module'],
                                             'controller' => $route['controller'],
                                             'action'     => $route['action']
                                         );

        // set params
        if ($params) {
            self::$_route[self::$_count] = array_merge(self::$_route[self::$_count], array('params' => $params));
        }

        self::$_count++;
    }

    /**
     * This method return route if url registered  else return false.
     * Notice: if send the parameters wrong the  method throw Exception.
     * 
     * @param string $url - registered url in format '/like-this/ok' without get params
     * @return mixed
     */
    public static function getRegisteredRouteByUrl($url) {
        // cheack input data
        if(!is_string($url)){
             throw new \Exception('url must be string');
        }
        
        for ($i = 0; $i < self::$_count; $i++) {
            if (self::$_aliases[$i] == $url) {
                return self::$_route[$i];
            }
        }
        return false;
    }

}