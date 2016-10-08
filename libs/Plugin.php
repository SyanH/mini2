<?php

namespace libs;

class Plugin
{
	protected $app;

    public function __construct()
    {
     	$this->app = App::getInstance();
     	$this->init();
    }

    public function init()
    {

    }

    public function enable()
    {

    }

    public function disable()
    {
    	
    }
    
}

