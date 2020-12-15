<?php

namespace app\core;

class Application 
{

    public static $ROOT_DIR;
    public static $app;
    public $router;
    public $request;
    public $response;
    public $controller;
    public $db;

    public function __construct($rootPath, $config)
    {
        self::$ROOT_DIR   = $rootPath;
        self::$app        = $this;
        $this->request    = new Request();
        $this->response   = new Response();
        $this->router     = new Router($this->request, $this->response);
        $this->db         = new Database($config['db']);
    }

    public function run() 
    {
        echo $this->router->resolve();
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setController(Controller $controller)
    {
        $this->controller = $controller;
    }
}