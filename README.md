## 一个简单的控制台命令执行脚手架

### 下载

~~~
composer require yueheng0112/sapp
~~~


### 创建入口文件 `console`
~~~php
#!/usr/bin/env php
<?php
namespace sapp;
require __DIR__ . '/vendor/autoload.php';
(App::getInstance())->run();
~~~


### 示例
~~~php
<?php
namespace app\controller;
class Index
{
    /**
     * @param $a
     * @param $b
     * @example  php think index/index a=3 b=2
     */
    public function index($a, $b)
    {
        echo "this is index\n";
        dump($a, $b);
    }

}
~~~

### 运行
~~~
php console index/index a=3 b=2
~~~
