<?php

namespace libs;

class Cache
{
	protected $prefix = null;
    protected $cachePath = null;

    public function setPrefix($prefix)
    {
        $this->prefix    = $prefix;
    }

	public function setCachePath($path)
	{
        if ($path) {
            $this->cachePath = rtrim($path, "/\\")."/";
        }
    }

    public function getCachePath()
    {
        return $this->cachePath;
    }

    public function set($key, $value, $duration = -1)
    {
        $expire = ($duration==-1) ? -1:(time() + (is_string($duration) ? strtotime($duration):$duration));
        $safe_var = [
            'expire' => $expire,
            'value' => serialize($value)
        ];
        file_put_contents($this->cachePath.md5($this->prefix.'-'.$key).".cache" , serialize($safe_var));
    }

    public function get($key, $default = null)
    {
        $file = $this->cachePath . md5($this->prefix . '-' . $key) . ".cache";
        if (! file_exists($file)) {
            return $default;
        }
        $var = @file_get_contents($file);
        if ($var) {
            $time = time();
            $var  = unserialize($var);
            if (($var['expire'] < $time) && $var['expire']!=-1) {
                $this->delete($key);
                return $default;
            }
            return unserialize($var['value']);
        }
        return $default;
    }

    public function delete($key)
    {
        $file = $this->cachePath . md5($this->prefix . '-' . $key) . ".cache";
        if (file_exists($file)) {
            @unlink($file);
        }
    }
    
    public function clear()
    {
        $iterator = new \RecursiveDirectoryIterator($this->cachePath);
        foreach($iterator as $file) {
            if ($file->isFile() && substr($file, -6)==".cache") {
                @unlink($this->cachePath.$file->getFilename());
            }
        }
    }
}