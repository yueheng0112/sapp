<?php

namespace sapp;

class App
{
    public $act;
    public $controller;
    public $args     = [];
    public $config   = [];
    public $sappPath = '';
    public $rootPath = '';

    public static $instance;

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function __construct(string $rootPath = '')
    {
        $this->sappPath = __DIR__ . DIRECTORY_SEPARATOR;
        $this->rootPath = $rootPath ? rtrim($rootPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR : $this->getDefaultRootPath();
    }

    public function run()
    {
        $argv = $_SERVER['argv'];
        array_shift($argv);
        $this->act = array_shift($argv);
        list($c_name, $a_name) = explode('/', $this->act);

        foreach ($argv as $item) {
            if (stripos($item, '=') === false) {
                $this->args[] = $item;
            } else {
                list($key, $value) = explode('=', $item);
                $this->args[$key] = $value;
            }
        }

        $this->load();

        $controller_namespace = $this->config['controllerNamespace'];
        $c_name               = ucfirst($c_name);
        $controller           = "{$controller_namespace}\\{$c_name}";
        $object               = new $controller();
        $this->controller     = $object;

        call_user_func_array([$object, $a_name], $this->args);
    }

    public function load()
    {
        //配置文件
        $this->config     = require __DIR__ . '/config.php';
        $user_config_file = $this->rootPath . "config/config.php";
        if (file_exists($user_config_file)) {
            $user_config  = require $user_config_file;
            $this->config = array_merge($this->config, $user_config);
        }

        //自定义函数
        require_once __DIR__ . '/function.php';
    }

    /**
     * 获取应用根目录
     * @access protected
     * @return string
     */
    protected function getDefaultRootPath(): string
    {
        $path = dirname(dirname(dirname($this->sappPath)));
        return $path . DIRECTORY_SEPARATOR;
    }
}