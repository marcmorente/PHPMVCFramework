<?php

namespace app\core;

class Router 
{

    protected $routes = [];
    public $request;
 
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
     
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path     = $this->request->getPath();
        $method   = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            return "Not found";
        }

        if (is_string($callback)) {
            $this->renderView($callback);
        }
        
        return call_user_func($callback);
    }

    public function renderView($view)
    {
        $layoutContent = $this->layoutContent();
        include_once Application::$ROOT_DIR."/views/$view.php";
    }

    protected function layoutContent()
    {
        //include_once Application::$ROOT_DIR."/views/$view.php";
    }
}