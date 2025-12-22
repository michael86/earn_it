<?php

class Router
{
    private array $routes = [];


    private function registerRoute(string $method, string $uri, string $controller): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'uri' => $uri,
            'controller' => $controller
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
     * @url string $route
     * @controller string $controller
     * @return void
     * 
     */
    public function get(string $route, string $controller): void
    {
        $this->registerRoute('GET', $route, $controller);
    }

    /**
     * Register a POST route
     * 
     * @url string $route
     * @controller string $controller
     * @return void
     * 
     */
    public function post(string $route, string $controller): void
    {
        $this->registerRoute('POST', $route, $controller);
    }

    /**
     * Register a PUT route
     * 
     * @url string $route
     * @controller string $controller
     * @return void
     * 
     */
    public function put(string $route, string $controller): void
    {
        $this->registerRoute('PUT', $route, $controller);
    }

    /**
     * Register a DELETE route
     * 
     * @url string $route
     * @controller string $controller
     * @return void
     * 
     */
    public function DELETE(string $route, string $controller): void
    {
        $this->registerRoute('DELETE', $route, $controller);
    }

    /** This will route the request
     * @param string $uri
     * @param string $method 
     * @return void
     */

    public function route(string $uri, string $method): void
    {
        foreach ($this->routes as $route) {

            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {

                loadController($route['controller']);
                return;
            }
        }

        // if (DEBUG_MODE) {
        //     inspectAndDie($uri, $method, $route['controller']);
        // };

        $this->error();
        exit;
    }
}
