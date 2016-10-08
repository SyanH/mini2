<?php

error_reporting(E_ALL | E_STRICT);

ini_set('display_errors', true);

ini_set('error_log', __DIR__ . '/storage/logs/error_' . gmdate('Y_m_d') . '.log');

function autoLoad($path, $namespace = NULL)
{
    spl_autoload_register(function ($class) use ($path, $namespace) {
        if (!empty($namespace)) {
            if (0 == strpos(ltrim($class, '\\'), $namespace . '\\')) {
                $class = substr(ltrim($class, '\\'), strlen($namespace) + 1);
            } else {
                return;
            }
        }
        $file = $path . '/' . str_replace(array('_', '\\'), '/', $class) . '.php';
        if (file_exists($file)) {
            include_once $file;
        }
    });
}

autoLoad('./libs', 'libs');

autoLoad('./app', 'app');

$configs = require './config.php';

$app = new \libs\App($configs);

require './app/bootstrap.php';

require './app/route.php';

$app->run();