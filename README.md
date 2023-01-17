## 一个简单的脚手架，用来执行控制台命令

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
