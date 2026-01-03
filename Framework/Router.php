<?php

namespace Framework;

class Router
{
    private array $routes = [];


    /**
     * @param string $type
     * @param string $uri
     * @param string $action
     */
    private function registerRoute(string $type, string $uri, string $action): void
    {

        list($controller, $method) = explode('@', $action);

        $this->routes[] = [
            'type' => strtoupper($type),
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method
        ];
    }

    private function error(int $errorCode = 404): void
    {
        http_response_code($errorCode);
        loadController("errors/{$errorCode}");
        exit;
    }

    /**
     * Register a GET route
     * 
     * @param string $route
     * @param string $action
     * @return void
     * 
     */
    public function get(string $route, string $action): void
    {
        $this->registerRoute('GET', $route, $action);
    }

    /**
     * Register a POST route
     * 
     * @param string $route
     * @param string $action
     * @return void
     * 
     */
    public function post(string $route, string $action): void
    {
        $this->registerRoute('POST', $route, $action);
    }

    /**
     * Register a PUT route
     * 
     * @param string $route
     * @param string $action
     * @return void
     * 
     */
    public function put(string $route, string $action): void
    {
        $this->registerRoute('PUT', $route, $action);
    }

    /**
     * Register a DELETE route
     * 
     * @param string $route
     * @param string $action
     * @return void
     * 
     */
    public function DELETE(string $route, string $action): void
    {
        $this->registerRoute('DELETE', $route, $action);
    }

    /** This will route the request
     * @param string $uri
     * @param string $type
     * @return void
     */

    public function route(string $uri, string $type): void
    {


        foreach ($this->routes as $route) {

            if ($route['uri'] === $uri && $route['type'] === strtoupper($type)) {
                $controller = 'App\\Controllers\\' . $route['controller'];
                $method = $route['method'];
                
                $ins = new $controller();
                $ins->$method();

                return;
            }
        }
        
        if(DEBUG_MODE) {
            inspectAndDie('uri: ' . $uri, 'method: ' . $type);
        }
        
        $this->error();
        exit;
    }
}
