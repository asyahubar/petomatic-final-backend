<?php

namespace Petomatic\Core;


class Router
{
    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * loads routes
     * @param $file
     * @return Router
     */
    public static function load($file)
    {
        $router = new static;
        require $file;
        return $router;
    }

    /**
     * @param string $route
     * @param string $controller
     * @param bool $auth
     */
    public function get($route, $controller, $auth = false)
    {
        $this->routes['GET'][$route] = [$controller, $auth];
    }

    /**
     * @param string $route
     * @param string $controller
     * @param bool $auth
     */
    public function post($route, $controller, $auth = false)
    {
        $this->routes['POST'][$route] = [$controller, $auth];
    }

    /**
     * @param $uri
     * @param $requestMethod
     * @throws \Exception
     */
    public function direct($uri, $requestMethod) {
        $route = $this->matchRoute($this->routes[$requestMethod], $uri);
        if(!is_null($route)) {
            if ($route[1]) {
                if (isset($_SESSION['auth'])) {
                    $this->callAction(...explode('@', $route[0]));
                } else {
                    echo '<h1><center>You are not authorized, go to <a href="/login">login page</a></center></h1>';
                }
            } else {
                $exploded = explode('@', $route[0]);
                $route['controller'] = $exploded[0];
                $route['action'] = $exploded[1];
                if (isset($route['parameters'])){
                    $this->callAction($route['controller'], $route['action'], $route['parameters']);
                } else {
                    $this->callAction($route['controller'], $route['action']);
                }
            }
        }
    }

    /**
     * @param array $routes
     * @param string $uri
     * @return null|array
     */
    private function matchRoute($routes, $uri)
    {
        $uriParts = explode('/', $uri);
        foreach ($routes as $route => $routeData) {
            $routeParts = explode('/', $route);
            if (count($uriParts) !== count($routeParts)) {
                continue;
            }
            for ($i = 0; $i < count($uriParts); $i++) {
                if ($uriParts[$i] === $routeParts[$i]) {
                    continue;
                }
                if (false !== strpos($routeParts[$i], '{')) {
                    $routeData['parameters'][] = $uriParts[$i];
                    continue;
                }
                continue 2;
            }
            return $routeData;
        }
        return null;
    }

    /**
     * @param $controller
     * @param $method
     * @param null $params
     * @return mixed
     * @throws \Exception
     */
    public function callAction($controller, $method, $params = null) {
        $c = "\\Petomatic\\Controllers\\{$controller}";
        $c = new $c;
        if(!method_exists($c, $method)) {
            throw new \Exception('No method');
        }
        if (is_array($params) || $params instanceof \Traversable) {
            return $c->$method(...$params);
        } else {
            return $c->$method();
        }
    }
}
