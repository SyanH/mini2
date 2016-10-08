<?php

namespace libs;

class App extends StdClass
{
	private static $instance;

    private $shortcuts = [];

    private $parent = '/';

    private $events = [];

    private $viewVars = [];

    public $found = false;

    public function __construct(array $configs = [])
    {
    	static::$instance = $this;
        $defaultConfig = [
        	'index' => '/',
        	'secure' => null,
        	'charset' => 'UTF-8',
        	'timezone' => 'Asia/Shanghai',
        	'gzip' => true,
        	'debug' => false,
        	'log' => true,
        	'version' => '0.1',
        	'name' => 'syan',
        	'key' => 'skJyj29Kh*ksjw-ajJUY'
        ];
        $this->configs = new StdClass(array_merge($defaultConfig, $configs));
    	$_SERVER["PATH_INFO"] = explode("?", $_SERVER["REQUEST_URI"])[0] ?? $_SERVER["REQUEST_URI"];
    	$strip = "/";
    	if (stripos($_SERVER["PATH_INFO"], $_SERVER["SCRIPT_NAME"]) === 0) {
    		$strip = $_SERVER["SCRIPT_NAME"];
    	} else if (stripos($_SERVER["PATH_INFO"], dirname($_SERVER["SCRIPT_NAME"])) === 0) {
    		$strip = dirname($_SERVER["SCRIPT_NAME"]);
    	}
    	$_SERVER["PATH_INFO"] = preg_replace("~/+~", "/", "/" . substr($_SERVER["PATH_INFO"], strlen($strip)) . "/");
    	$this->init();
    }

    public function init()
    {
    	$this->request = new Request;
    	$this->response = new Response;
    	$this->response->setCharset($this->configs->charset);
    	if ($this->configs->gzip && !ob_start("ob_gzhandler")) ob_start();

    	set_error_handler(function($errno, $errstr, $errfile, $errline) {
    		if ($errno & error_reporting()) {
	            throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
	        }
    	});
    	$self = $this;
    	set_exception_handler(function($e) use ($self)  {
    		if ($self->configs->log) {
	            error_log($e->getMessage());
	        }
	        $self->error($e);
    	});
        register_shutdown_function(function() {
            $last_error = error_get_last();
            if (null !== $last_error) {
                throw new \ErrorException($last_error['message'], $last_error['type'], 0, $last_error['file'], $last_error['line']);
            }
        });
    }

    public static function getInstance()
    {
        if (! static::$instance instanceof App) {
            return new App;
        }
    	return static::$instance;
    }

    public function secure()
    {
        if (null !== $this->configs->secure && $this->configs->secure) {
            $_SERVER["HTTPS"] = "on";
        }
        if (isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] !== "off")) {
            return true;
        }
        return isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && (strtolower($_SERVER["HTTP_X_FORWARDED_PROTO"]) == "https");
    }

    public function url($path = "")
    {
        return (
            $this->secure() ? "https://" : "http://" .
            $_SERVER["SERVER_NAME"] .
            preg_replace("~/+~", "/", "/" . str_replace(DIRECTORY_SEPARATOR, '/', dirname($_SERVER["SCRIPT_NAME"])) . "/" . implode('/', array_map('rawurlencode', explode('/', $path))))
        );
    }

    public function route($path = '')
    {
        return $this->url($this->configs->index . "/" . $path);
    }

    public function assets($path = '')
    {
        $version = $this->configs->debug ? time() : $this->configs->version;
        $pathUrl = $this->url($path);
        return $pathUrl . '?v=' . $version;
    }

    public function root($path = '')
    {
        return preg_replace("~/+~", "/", str_replace(DIRECTORY_SEPARATOR, '/', isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : dirname($_SERVER['SCRIPT_FILENAME'])) . '/' . $path);
    }

    public function on($event, $callback, $priority = 0)
    {
        if (!isset($this->events[$event])) $this->events[$event] = [];
        if (is_object($callback) && $callback instanceof \Closure) {
            $callback = $callback->bindTo($this);
        }
        $this->events[$event][] = ["fn" => $callback, "prio" => $priority];
    }

    public function trigger($event,$params=[])
    {
        if (!isset($this->events[$event])){
            return $this;
        }
        if (!count($this->events[$event])){
            return $this;
        }
        $queue = new \SplPriorityQueue();
        foreach($this->events[$event] as $index => $action){
            $queue->insert($index, $action["prio"]);
        }
        $queue->top();
        while($queue->valid()){
            $index = $queue->current();
            if (is_callable($this->events[$event][$index]["fn"])){
                if (call_user_func_array($this->events[$event][$index]["fn"], $params) === false) {
                    break;
                }
            }
            $queue->next();
        }
        return $this;
    }

    public function hasEvent($name)
    {
        if (isset($this->events[$name]) and count($this->events[$name])){
            return true;
        }
        return false;
    }

    public function shortcut(array $shortcuts)
    {
        foreach ($shortcuts as $k => $v) {
            $this->shortcuts[sprintf("{{%s}}", $k)] = $v;
        }
        return $this;
    }

    public function map(string $pattern, $cb)
    {
        if ($this->found) {
            return $this;
        }
    	list($method, $pattern) = array_pad(explode(" ", $pattern, 2), -2, $_SERVER["REQUEST_METHOD"]);
        $pattern = preg_replace("~/+~", "/",  "/" . str_ireplace(array_keys($this->shortcuts), array_values($this->shortcuts), "/" . $this->parent . "/" . $pattern) . "/");
    	if (! preg_match("~^{$method}$~i", $_SERVER["REQUEST_METHOD"]) || ! preg_match("~^{$pattern}$~", $_SERVER["PATH_INFO"], $m)) {
    		return $this;
    	}
    	$this->found = true;
    	array_shift($m);
        $call = function($obj, $callback, $args){
            if ($callback instanceof \Closure) {
                return call_user_func_array($callback->bindTo($obj), $args);
            } else {
                return call_user_func_array($callback, $args);
            }
        };
        $lastReturn = null;
    	if (is_callable($cb)) {
            $call($this, $cb, $m);
        } else if (is_array($cb)) {
            foreach ($cb as $fn) {
                if (false === ($lastReturn = $call($this, $fn, array_merge($m, [$lastReturn])))) {
                    break;
                }
            }
        }
    	return $this;
    }

    public function group($pattern, callable $cb)
    {
        $old = $this->parent;
        $this->parent = preg_replace("~/+~", "/", "/" . $this->parent . "/" . $pattern . "/");
        if (preg_match("~^" . $this->parent . "~", $_SERVER["PATH_INFO"], $m)) {
            call_user_func_array($cb->bindTo($this), $m);
        }
        $this->parent = $old;
        return $this;
    }

    public function e($string, $charset = null)
    {
        if (is_null($charset)) {
            $charset = $this->configs->charset;
        }
        return htmlspecialchars($string, ENT_QUOTES, $charset);
    }

    public function globalViewVars($name, $value)
    {
        if (is_array($name)) {
            foreach ($name as $n => $v) {
                $this->viewVars[$n] = $v;
            }
        } else {
            $this->viewVars[$name] = $value;
        }
        return $this;
    }

    public function view($tpl, array $vars = [], $return = false)
    {
        if ( $return ) {
            ob_start();
        }
        extract(array_merge($this->viewVars, $vars), EXTR_OVERWRITE);
        foreach ((array) $tpl as $f) {
            $file = $this->root($f);
            if (is_file($file)) {
                require $file;
            } else {
                throw new \Exception("{$file} does not exist");
            }
        }
        if ( $return ) {
            return ob_get_clean();
        }
        return $this;
    }

    public function json($data, $cb = false)
    {
    	if ( $cb ) {
            $this->response->setContentType('application/javascript');
            echo sprintf('%s(%s)', $cb, json_encode($data));
        } else {
            $this->response->setContentType('application/json');
            echo json_encode($data);
        }
    }

    public function notFound()
    {
    	ob_end_clean();
    	if ($this->hasEvent('404')) {
    		$this->trigger("404");
    	} else {
            $body = $this->view('/libs/views/404.php', [], true);
            $this->response
	    	->reset()
	    	->setStatusCode(404)
	    	->setBody($body)
	    	->send();
    	}
    	return $this;
    }

    public function stop($code = 200)
    {
    	$body = ob_get_clean();
		$this->trigger('end', [&$body]);
		$this->response
		->setStatusCode($code)
		->appendBody($body)
		->send();
    }

    public function halt($code = 200, $body = '')
    {
    	ob_end_clean();
    	$this->response
		->setStatusCode($code)
		->setBody($body)
		->send();
    }

    public function error($e) {
    	if ($this->configs->debug) {
            $body = $this->view('/libs/views/debug.php', ['e'=>$e], true);
	        try {
	        	ob_end_clean();
	            $this->response
	            ->setStatusCode(500)
	            ->setBody($body)
	            ->send();
	        }
	        catch (\Throwable $t) {
	            exit($body);
	        }
	        catch (\Exception $e) {
	            exit($body);
	        }
    	} else {
    		ob_end_clean();
            $body = $this->view('/libs/views/500.php', [], true);
            $this->response
            ->setStatusCode(500)
            ->setBody($body)
            ->send();
    	}
    }

    public function run()
    {
    	if ($this->found) {
    		$this->stop();
    	} else {
    		$this->notFound();
    	}
    }
}