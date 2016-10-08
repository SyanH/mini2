<?php

namespace libs;

class Controller
{

	protected $app;

	public function __construct() {
		$this->app = App::getInstance();
	}
	
}