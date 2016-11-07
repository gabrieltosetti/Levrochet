<?php

class LoginController extends \HXPHP\System\Controller
{
	public function logarAction()
	{
		$this->view->setFile('index'); //quando chamada esta ação, ela aproveita a view Index.
	}
}