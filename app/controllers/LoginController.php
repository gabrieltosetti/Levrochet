<?php

class LoginController extends \HXPHP\System\Controller
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

		//IMPORTANTE:se a pagina é privada, apenas usuarios logados pode acessar, entao deixe em FALSE
		//se a pagina é PUBLICA, apenas usuario NAO LOGADOS podem acessar, entao deixe em TRUE
		$this->auth->redirectCheck(true);
	}

	public function logarAction()
	{
		$this->view->setFile('index'); //quando chamada esta ação, ela aproveita a view Index.

		$post = $this->request->post();

		if(!empty($post))
		{
			User::login($post);
		}
	}
}