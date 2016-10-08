<?php

namespace libs;

class Model
{
	protected $app;

    protected $db;

    public function __construct()
    {
     	$this->app = App::getInstance();
        $this->db = $this->app->db;
    }
    
}

