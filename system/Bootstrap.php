<?php

namespace System;

final class Bootstrap
{
    private const NAMESPACE_CONTROLLER = '\Application\Controllers\\';
    private const DEFAULT_CONTROLLER   = 'Home';
    private const DEFAULT_ACTION       = 'index';
    
    private $controller = self::DEFAULT_CONTROLLER;
    private $action     = self::DEFAULT_ACTION;
    private $params     = [];
    private $appName    = 'devlab';

    private $path;

    public function __construct(array $options = []) 
    {
        $this->path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if (strpos($this->path, $this->appName) === 0) {
            $this->path = trim(substr($this->path, strlen($this->appName)), '/');
        }
        
        if (!empty($options)) {
            $this->setController($options['controller']);
            $this->setAction($options['action']);
            $this->setParams($options['params']);
        }
        else if (!empty($this->path)) {
            $this->parseUri($this->path);
        }
        else {
            $this->setController($this->controller);
            $this->setAction($this->action);
            $this->setParams($this->params);
        }
    }
    
    private function parseUri(string $path) : void
    {
        $path = preg_replace('/[^a-zA-Z0-9\/\%-\+]/', '', $path);

        @list($controller, $action, $params) = explode('/', $path, 3);
        if (isset($controller)) {
            $this->setController($controller);
        }
        if (isset($action)) {
            $this->setAction($action);
        }
        if (isset($params)) {
            $this->setParams(explode('/', $params));
        }
    }
    
    private function setController(string $controller) : Bootstrap
    {
        $controller = ucfirst(strtolower($controller)) . 'Controller';

        if (!class_exists(self::NAMESPACE_CONTROLLER . $controller)) {
            throw new \InvalidArgumentException('Não encontrado, o caminho "'.$this->path.'" não exite.');
        }

        $this->controller = self::NAMESPACE_CONTROLLER . $controller;

        return $this;
    }
    
    private function setAction(string $action) : Bootstrap
    {
        $reflector = new \ReflectionClass($this->controller);

        if (!$reflector->hasMethod($action)) {
            throw new \InvalidArgumentException('Não encontrado, o caminho "'.$this->path.'" não exite.');
        }
        $this->action = $action;

        return $this;
    }
    
    private function setParams(array $params) : Bootstrap
    {
        $this->params = $params;

        return $this;
    }
    
    public function run() : void
    {
        call_user_func_array([new $this->controller, $this->action], $this->params);
    }
}
