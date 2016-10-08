<?php

$app->map('/', function() {
	echo 'Hello World!';
});

$app->map('/login', function() {
	(new \app\controllers\Auth)->login();
});

$app->map('/reg', function() {
	(new \app\controllers\Auth)->reg();
});

$app->map('/logout', function() {
	(new \app\controllers\Auth)->logout();
});

// $app->map('/admin/*', function() {
// 	$auth = new \app\models\Auth;
// 	$auth->pass('admin', true);
// 	$this->found = false;
// });

$app->map('GET|POST /admin/?([a-zA-Z0-9]+)?/?([a-zA-Z0-9]+)?', function($c = 'Index', $a = 'init') use ($app) {
	$auth = new \app\models\Auth;
	$auth->pass('admin', true);
	$controller = '\\app\\controllers\\admin\\' . ucfirst($c);
	(new $controller)->$a($c, $a);
});
