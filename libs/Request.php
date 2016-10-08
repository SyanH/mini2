<?php

namespace libs;

class Request
{
    private $_ip;

    private $_acceptLangs = false;

    private $_referer = false;

    private $_jsonParams = [];

    private $_params = [];

    public function __construct()
    {
        if (preg_match("/^application\/json/i", $_SERVER['HTTP_ACCEPT'])) {
            $this->_jsonParams = json_decode(file_get_contents('php://input'), true, 16);
        }
    }

    public function setParams(array $params)
    {
        $this->_params = array_merge($this->_params, $params);
    }

    public function getAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'PHP ' . PHP_VERSION;
    }

    public function getArg($name)
    {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        } else if (isset($_GET[$name])) {
            return $_GET[$name];
        } else if (isset($this->_jsonParams[$name])) {
            return $this->_jsonParams[$name];
        }
        return false;
    }

    public function get($key, $default = null)
    {
        if (isset($this->_params[$key])) {
            return $this->_params[$key];
        }
        $arg = $this->getArg($key);
        if (false === $arg) {
            return $default;
        }
        return $arg;
    }

    public function getArray($key)
    {
        if (is_array($key)) {
            $result = [];
            foreach ($key as $k) {
                $val = $this->get($k, NULL);
                $result[$k] = $val;
            }
            return $result;
        } else {
            $result = $this->get($key, []);
            return is_array($result) ? $result : [$result];
        }
    }

    public function getCookie($key, $default = NULL)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $default;
    }

    public function getIp()
    {
        if (empty($this->_ip)) {
            switch (true) {
                case !empty($_SERVER['HTTP_X_FORWARDED_FOR']):
                    list($this->_ip) = array_map('trim', explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
                    break;
                case !empty($_SERVER['HTTP_CLIENT_IP']):
                    $this->_ip = $_SERVER['HTTP_CLIENT_IP'];
                    break;
                case !empty($_SERVER['REMOTE_ADDR']):
                    $this->_ip = $_SERVER['REMOTE_ADDR'];
                    break;
                default:
                    $this->_ip = '-';
                    break;
            }
        }
        return $this->_ip;
    }

    public function getAcceptLangs()
    {
        if (false == $this->_acceptLangs) {
            $lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : 'en';
            if (preg_match_all("/[a-z-]+/i", $lang, $matches)) {
                $this->_acceptLangs = array_map('strtolower', $matches[0]);
            } else {
                $this->_acceptLangs = ['en'];
            }
        }
        return $this->_acceptLangs;
    }

    public function getReferer()
    {
        if (false === $this->_referer) {
            $this->_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : NULL;
        }
        return $this->_referer;
    }

    public function isPost()
    {
        return 'POST' == $this->getMethod();
    }

    public function isGet()
    {
        return 'GET' == $this->getMethod();
    }

    public function isUpload()
    {
        return !empty($_FILES);
    }

    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'XMLHttpRequest' == $_SERVER['HTTP_X_REQUESTED_WITH'];
    }

    public function isFlash()
    {
        return 'Shockwave Flash' == $this->getAgent();
    }
}