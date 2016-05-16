<?php
namespace Gsdw\Permission\Helpers;

use Route;
use Illuminate\Support\Facades\Input;
use Session;
use Illuminate\Support\Arr;

Class RouteAs
{
    /**
     *  array store
     * 
     * @var array
     */
    protected static $attributes = [];
    
    /**
     * get all route format group
     * 
     * @return array
     */
    public static function getRouterAsGroup()
    {
        $routeAs = config('routeas');
        $routeCollection = Route::getRoutes();
        foreach($routeCollection as $route) {
            if(!preg_match('/^auth\./', $route->getName())) {
                continue;
            }
            $routeName = $route->getName();
            if (isset($routeAs[$route->getName()])) {
                $routeValueShow = $routeAs[$route->getName()];
            } else {
                $routeValueShow = $route->getName();
            }
            self::push($routeName, $routeValueShow);
        }
        if(isset(self::$attributes['auth'])) {
            self::$attributes = self::$attributes['auth'];
        }
        return self::all();
    }
    
    //copy from core Session: Illuminate\Session\Store.php
    
    /**
     * push a value to array store
     * 
     * @param type $key
     * @param type $value
     */
    public static function push($key, $value)
    {
        $array = self::get($key, []);
        self::put($key, $value);
    }
    
    /**
     * put a value to array store
     * 
     * @param type $key
     * @param type $value
     */
    public static function put($key, $value = null)
    {
        if (! is_array($key)) {
            $key = [$key => $value];
        }
        foreach ($key as $arrayKey => $arrayValue) {
            self::set($arrayKey, $arrayValue);
        }
    }
    
    /**
     * set a value to array store
     * 
     * @param type $key
     * @param type $value
     */
    public static function set($key, $value)
    {
        self::setArr(self::$attributes, $key, $value);
    }
    
    /**
     * set array value to array store
     * 
     * @param type $array
     * @param type $key
     * @param type $value
     * @return type
     */
    public static function setArr(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }
        $keys = explode('.', $key);
        $keyLastFull = '';
        while (count($keys) > 1) {
            $key = array_shift($keys);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (! isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
            $keyLastFull .= $key.'.';
        }
        $keyLastFull .= array_shift($keys);
        $array[$keyLastFull] = $value;
        return $array;
    }

    /**
     * get value of array store
     * 
     * @param type $name
     * @param type $default
     * @return type
     */
    public static function get($name, $default = null)
    {
        return Arr::get(self::$attributes, $name, $default);
    }
    
    /**
     * get all value of array store
     * 
     * @return type
     */
    public static function all()
    {
        return self::$attributes;
    }
    
    public static function toHtml()
    {
        if(!count(self::$attributes)) {
            self::getRouterAsGroup();
        }
        $html = '';
        
        return $html;
    }
}

