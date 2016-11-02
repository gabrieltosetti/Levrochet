<?php

class CadastroController extends \HXPHP\System\Controller
{
	public function __construct($configs)
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

	public function cadastrarAction()
	{
		$this->view->setFile('index');

		$this->request->setCustomFilters([
			'email' => FILTER_VALIDATE_EMAIL
			]);
		$post = $this->request->post();

		if(!empty($post)){
			$cadastrarUsuario = User::cadastrar($post);

			if($cadastrarUsuario->status == false){
				$this->load('Helpers\Alert', array(
					'danger',
					'Ops! Nâo foi possível efetuar seu cadastro. Verifique os erros abaixo:',
					$cadastrarUsuario->errors
				));
			}
			else
			{
				$this->auth->login($cadastrarUsuario->user->id, $cadastrarUsuario->user->username);
			}

		}

		//$username = $this->request->post('username');

		//echo $username;

		//Gerar Senha
		//Obter role_id

	}
}