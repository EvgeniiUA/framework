<?php
/**
 * Router class file
 * @author Sinevid Evgenii (sinevid-evgenii@mail.ru)
 */
 
/**
 * Обьявляем пространство имен Framework, к которому относитса класс Router
 */
namespace framework;

use framework\UrlManager as UrlManager;
use framework\Request    as Request;
use framework\Config     as Config;


/**
 *
 * @category  Framework
 * @package   Framework\Router
 * @author    Sinevid Evgenii
 * @version   $Id$
 */
class Router {

    /**
     * active route
     * @var array
     */
    protected static $_route;

    /**
     *
     * @var array
     */
    protected static $_modules;


    /**
     * 
     * @param string $url
     * @return mixed
     */
    private static function _isAliaseRegister($url) {
        // check for this $request create alias ?
        if ($route = UrlManager::getRegisteredRouteByUrl($url)) {
            return $route;
        }
        return false;
    }

    /**
     * 
     * @param string $moduleName
     * @return true
     */
    private static function _isModuleRegister($moduleName) {
        if (in_array($moduleName, self::$_modules)) {
            return true;
        }
        return false;
    }

    /**
     * Example:
     * $str = 'some-string';
     * self::_toCamelCase($str);
     * // method return 'someString'
     * 
     * @param string $str       -  
     * @param string $seperator - optional
     * @param bool   $ucfirst   - optional
     * @return string 
     */
    private static function _toCamelCase($str, $separator = '-', $ucfirst = false) {
        $str    = strtolower($str);
        $splits = explode($separator, $str);
        $result = $splits[0];
        $count  = count($splits);

        // need case up first word?
        if ($ucfirst) {
            $result = ucfirst($splits[0]);
        }
        if ($count > 0) {
            for ($i = 1; $i < $count; $i++) {
                $result .= ucfirst($splits[$i]);
            }
        }

        return $result;
    }
    
    /**
     * 
     * @param array $arr
     */
    private static function _setParams(array $array){
        $keys = $values = array();
		$count = count($array);
		for($i=0; $i<$count; $i++){
			if($i%2==0){
				$keys[] = $array[$i];
			}
			else {
				$values[] = $array[$i];
			}
		}
		$countKeys = count($keys);
		$countVals = count($values);
		
		if($countKeys > $countVals){
			$countVals++;
			$values[$countVals] = ''; 
		}
		Request:: setParams(array_combine($keys,$values));
    }


     /**
     * This method initialization the route for this session
     * @return void
     */
    public static function init() {
        // setup default module
        
        self::$_modules[] = Config::get('defaultModule');
        // get request
        $request = $_SERVER['REQUEST_URI'];

        // cut get data
        if ($pos = strpos($request, '?')) {
            $request = substr($request, 0, $pos);
        }

        // check this request register as alias
        // return array if alies registered else return false
        if ($route = self::_isAliaseRegister($request)) {
            // setup route
            self::$_route = array('controller' => $route['controller'],
                                  'action'     => $route['action'],
                                  'module'     => $route['module']
                            );

            // check params returned?
            if (isset($route['params'])) {
                // setup params
                Request::setParams($route['params']);
            }
            return;
        }
        //----------------------------------------------------------------------
        $splits = explode('/', trim($request, '/'));
        $step = 0;

        // get first split and check 
        if (isset($splits[$step])) {
            //its resrved module name ?
            if (self::_isModuleRegister($splits[$step])) {
                self::$_route = array('module' => $splits[$step]);
                $step++;
            }
            // use default module
            else {
                self::$_route = array('module' => Config::get('defaultModule'));
            }
            // setup controller
            if (isset($splits[$step]) and !empty($splits[$step])) {
                self::$_route = array_merge(self::$_route, array('controller' => self::_toCamelCase($splits[$step])));
                $step++;
            }
            // setup default controller 
            else{
                self::$_route = array_merge(self::$_route, array('controller' => Config::get('defaultController')));
                $step++;
            }
            // setup action
            if (isset($splits[$step])) {
                self::$_route = array_merge(self::$_route, array('action' => 'action' . self::_toCamelCase($splits[$step],'-',true)));
                $step++;
            }
            // setup default action 
            else{
                self::$_route = array_merge(self::$_route, array('action' => Config::get('defaultAction')));
                $step++;
            }
            
            // setup params
            if(isset($splits[$step])){
                self::_setParams(array_slice($splits, $step));
            }
        }
    }

    /**
     * 
     * @param string $moduleName - 
     * @return void 
     */
    public static function registerModule($moduleName) {
        self::$_modules[] = $moduleName;
    }

    /**
     * 
     * @return array
     */
    public static function getRoute() {
        return self::$_route;
    }

}