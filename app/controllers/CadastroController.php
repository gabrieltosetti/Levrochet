<?php

class CadastroController extends \HXPHP\System\Controller
{
	public function cadastrarAction()
	{
		$this->view->setFile('index');

		$cadastrarUsuario = User::cadastrar($this->request->post());

		//$username = $this->request->post('username');

		//echo $username;

		//Gerar Senha
		//Obter role_id

	}
}