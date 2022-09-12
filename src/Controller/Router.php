<?php


namespace App\Controller;

use AltoRouter;

/**
 * class Router controller for router
 */
class Router extends AltoRouter
{
    public function routerRequest($target, $params)
    {
        if (stripos($target, '#') !== false) {
            list($controller, $method) = explode('#', $target, 2);
            $cname = "\App\Controller\\" . $controller;
            $controllerName = new $cname;
            if ($params) {
                return call_user_func_array(array($controllerName, $method), array($params['id']));
            }
            return call_user_func(array($controllerName, $method));
        }
        print_r("404");
    }
}
