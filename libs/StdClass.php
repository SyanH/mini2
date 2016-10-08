<?php

namespace libs;

class StdClass extends \StdClass
{
	public function __construct(array $data = [])
	{
        $this->add($data);
    }

    public function add(array $data)
    {
        foreach ($data as $k => $v) {
            $this->{$k} = $v;
        }
        return $this;
    }

    public function __call($name, $args)
    {
        if (isset($this->{$name})) {
            if ($this->{$name} instanceof \Closure) {
                return call_user_func_array($this->{$name}->bindTo($this), $args);
            }
            return call_user_func_array($this->{$name}, $args);
        }
        throw new \Exception("Undefined method {$name}");
    }

    public function __set($name, $val)
    {
        if ($val instanceof \Closure) {
            $this->{$name} = $val->bindTo($val);
        } else {
            $this->{$name} = $val;
        }
    }
}
