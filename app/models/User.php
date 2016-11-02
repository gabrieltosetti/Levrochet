<?php 

class User extends \HXPHP\System\Model
{
	static $validates_presence_of = array(
		array(
			'name',
			'message' => 'O nome é um campo obrigatório'
		),
		array(
			'email',
			'message' => 'O e-mail é um campo obrigatório'
		),
		array(
			'username',
			'message' => 'O nome de Usuário é um campo obrigatório'
		),
		array(
			'password',
			'message' => 'A Senha é um campo obrigatório'
		)
	);

	static $validates_uniqueness_of = array(
		array(
			array('username', 'email'),
			'message' => 'Já existe um usuário com este e-mail e/ou nome de usuário cadastrado.'
		)
	);

	public static function cadastrar(array $post)
	{
		//'stdClass' cria uma classe vazia
		$userObj = new \stdClass; //PODERIA TER FEITO COM ARRAY
		$userObj->user = null;
		$userObj->status = false;
		$userObj->errors = array();

		//vai ate a tabela Role e pega a linha do tipo de usuário "user"
		$role = Role::find_by_role('user');
		//coloca no post o ID do 'user' e o status 1
		if(is_null($role)){
			array_push($userObj->errors, 'A role user não existe. Contate o administrador.');
			return $userObj;
		}

		$post = array_merge($post, array(
			'role_id' => $role->id,
			'status' => 1 
			));
		//pega a senha do form e criptografa ela
		$password = \HXPHP\System\Tools::hashHX($post['password']);
		//troca a senha 'string' para a senha 'criptografada'
		$post = array_merge($post, $password);
		//usa o POST como array para criação de um novo iten na tabela users
		$cadastrar = self::create($post);

		if ($cadastrar->is_valid())
		{
			$userObj->user = $cadastrar;
			$userObj->status = true;
			return $userObj;
		}

		$errors = $cadastrar->errors->get_raw_errors();

		foreach($errors as $field => $message)
		{
			array_push($userObj->errors, $message[0]);
		}

		return $userObj;
	}
}