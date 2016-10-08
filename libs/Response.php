<?php

namespace libs;

class Response
{
    private $_cookies = [];

    private $_statusCode = 200;

    private $_charset = 'UTF-8';

    private $_contentType = 'text/html';

    private $_headers = [];

    private $_body = '';

    public function send()
    {
        if (! headers_sent()) {
            http_response_code($this->_statusCode);
            header('Content-Type: ' . $this->_contentType . '; charset=' . $this->_charset);
            foreach ($this->_headers as $header) {
                header($header, true);
            }
        }

        foreach ($this->_cookies as $cookie) {
            list ($key, $value, $timeout, $path, $domain) = $cookie;
            if ($timeout > 0) {
                $timeout += time();
            } else if ($timeout < 0) {
                $timeout = 1;
            }
            setCookie($key, $value, $timeout, $path, $domain);
        }
        
        exit($this->_body);
    }

    public function setCookie($key, $value, $timeout = 0, $path = '/', $domain = null)
    {
        if (is_array($value)) {
            foreach ($value as $name => $val) {
                $this->_cookies[] = ["{$key}[{$name}]", $val, $timeout, $path, $domain];
            }
        } else {
            $this->_cookies[] = [$key, $value, $timeout, $path, $domain];
        }
        return $this;
    }

    public function deleteCookie($key, $path = '/', $domain = NULL)
    {
        if (!isset($_COOKIE[$key])) {
            return;
        }
        if (is_array($_COOKIE[$key])) {
            foreach ($_COOKIE[$key] as $name => $val) {
                $this->_cookies[] = ["{$key}[{$name}]", '', -1, $path, $domain];
            }
        } else {
            $this->_cookies[] = [$key, '', -1, $path, $domain];
        }
        return $this;
    }

    public function redirect($url, $code = 302)
    {
        $this->setStatusCode($code);
        $this->setHeader('Location', $url);
        return $this;
    }

    public function setContentType($contentType)
    {
        $this->_contentType = $contentType;
        return $this;
    }

    public function setCharset($charset)
    {
        $this->_charset = $charset;
        return $this;
    }

    public function setStatusCode($statusCode)
    {
        $this->_statusCode = $statusCode;
        return $this;
    }

    public function getStatusCode()
    {
        return $this->_statusCode;
    }

    public function setHeader($name, $value)
    {
        $name = str_replace(' ', '-', ucwords(str_replace('-', ' ', $name)));
        $this->_headers[] = $name . ': ' . $value;
        return $this;
    }

    public function reset()
    {
        $this->_cookies = [];
        $this->_statusCode = 200;
        $this->_charset = 'UTF-8';
        $this->_contentType = 'text/html';
        $this->_headers = [];
        $this->_body = '';
        return $this;
    }

    public function setBody($body)
    {
        $this->_body = $body;
        return $this;
    }

    public function appendBody($body)
    {
    	$this->_body .= $body;
        return $this;
    }

    public function prependBody($body)
    {
    	$this->_body = $body . $this->_body;
        return $this;
    }
    
    public function getBody()
    {
        return $this->_body;
    }
}
