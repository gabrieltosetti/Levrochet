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
		$callbackObj = new \stdClass; //PODERIA TER FEITO COM ARRAY
		$callbackObj->user = null;
		$callbackObj->status = false;
		$callbackObj->errors = array();

		//vai ate a tabela Role e pega a linha do tipo de usuário "user"
		$role = Role::find_by_role('user');
		//coloca no post o ID do 'user' e o status 1
		if(is_null($role)){
			array_push($callbackObj->errors, 'A role user não existe. Contate o administrador.');
			return $callbackObj;
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
			$callbackObj->user = $cadastrar;
			$callbackObj->status = true;
			return $callbackObj;
		}

		$errors = $cadastrar->errors->get_raw_errors();

		foreach($errors as $field => $message)
		{
			array_push($callbackObj->errors, $message[0]);
		}

		return $callbackObj;
	}
}