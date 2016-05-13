<?php
namespace Gsdw\Permission\Helpers;

use Route;

Class General
{
    /**
     * get router alias custom
     * 
     * @return array
     */
    public static function getRouterAs()
    {
        $routeAs = config('routeas');
        $routeCollection = Route::getRoutes();
        $result = [];
        foreach($routeCollection as $route) {
            if(!preg_match('/^auth\./', $route->getName())) {
                continue;
            }
            if (isset($routeAs[$route->getName()])) {
                $result[$route->getName()] = $routeAs[$route->getName()];
            } else {
                $result[$route->getName()] = $route->getName();
            }
        }
        return $result;
    }
}
