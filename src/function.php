<?php

if (!function_exists("app")) {
    function app()
    {
        return \sapp\App::getInstance();
    }
}

if (!function_exists("config")) {
    function config($key = null)
    {
        if ($key === null) {
            return app()->config;
        } else {
            $arr   = explode('.', $key);
            $value = app()->config;
            if (!empty($arr)) {
                foreach ($arr as $item) {
                    $value = $value[$item] ?? null;
                    if ($value === null) {
                        return null;
                    }
                }
                return $value;
            }
            return null;
        }
    }
}

if (!function_exists("msg")) {
    function msg()
    {
        $args = func_get_args();
        $msg  = date('Y-m-d H:i:s') . ' -- ' . implode('--', $args);
        dump($msg);
    }
}