<?php 

class homeController extends \HXPHP\System\Controller
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

		$this->auth->redirectCheck();

		$this->load(
			'Helpers\Menu',
			$this->request,
			$this->configs,
			$this->auth->getUserRole() 
		);

		$user_id = $this->auth->getUserId();

		$this->view->setTitle('Levrochet - Home Page');
		$this->view->setVar('user', User::find($user_id));
		
	}

	public function bloqueadaAction()
	{
		$this->auth->roleCheck(array(
			'administrator',
			'user'
		));
	}
}