<?php

namespace app\controllers\admin;

class Index extends \libs\Controller
{
	public function init()
	{
		$view = [
			'/app/views/admin/layout/header.php',
			'/app/views/admin/index.php',
			'/app/views/admin/layout/footer.php'
		];
		$this->app->view($view);
	}

	public function modal()
	{
		sleep(2);
		$this->app->view('/app/views/admin/modal.php');
	}
}
