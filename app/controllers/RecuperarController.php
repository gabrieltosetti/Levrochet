<?php

class RecuperarController extends \HXPHP\System\Controller
{

	public function __construct($configs) //aula 7
	{
		parent::__construct($configs);

		$this->load(
			'Services\Auth',
			$configs->auth->after_login,
			$configs->auth->after_logout,
			true
		);

		$this->auth->redirectCheck(true);
		
	}

}