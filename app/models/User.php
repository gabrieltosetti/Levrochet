<?php 

class User extends \HXPHP\System\Model
{
	static $belongs_to = array(
		array('role')
	);
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
		array('username', 'message' => 'Já existe um usuário com este nome de usuário cadastrado.'),
		array('email', 'message' => 'Já existe um usuário com este e-mail cadastrado.')
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

		$user_data = array(
			'role_id' => $role->id,
			'status' => 1 
		);
		//pega a senha do form e criptografa ela
		$password = \HXPHP\System\Tools::hashHX($post['password']);
		//troca a senha 'string' para a senha 'criptografada'
		$post = array_merge($post, $user_data, $password);
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

	public static function atualizar($user_id, array $post)
	{
		//'stdClass' cria uma classe vazia
		$callbackObj = new \stdClass; //PODERIA TER FEITO COM ARRAY
		$callbackObj->user = null;
		$callbackObj->status = false;
		$callbackObj->errors = array();

		if (isset($post['password']) && !empty($post['password']))
		{
			//pega a senha do form e criptografa ela
			$password = \HXPHP\System\Tools::hashHX($post['password']);
			//troca a senha 'string' para a senha 'criptografada'
			$post = array_merge($post, $password);
		}
		
		$user = self::find($user_id);

		$user->name = $post['name'];
		$user->email = $post['email'];
		$user->username = $post['username'];

		if(isset($post['salt']))
		{
			$user->password = $post['password'];
			$user->salt = $post['salt'];
		}

		$exist_email = self::find_by_email($post['email']);

		if(!is_null($exist_email) && intval($user_id) !== intval($exist_email->id))
		{
			array_push($callbackObj->errors, 'Oops! Já existe um usuário com este e-mail cadastrado. Por favor, escolha outro e tente novamente.');
			return $callbackObj;
		}

		$exist_username = self::find_by_username($post['username']);

		if(!is_null($exist_username) && intval($user_id) !== intval($exist_username->id))
		{
			array_push($callbackObj->errors, 'Oops! Já existe um usuário com o Login <strong>' . $post['username'] . '</strong> cadastrado. Por favor, escolha outro e tente novamente.');
			return $callbackObj;
		}

		$atualizar = $user->save(false);

		if ($atualizar)
		{
			$callbackObj->user = $user;
			$callbackObj->status = true;
			return $callbackObj;
		}

		$errors = $atualizar->errors->get_raw_errors();

		foreach($errors as $field => $message)
		{
			array_push($callbackObj->errors, $message[0]);
		}

		return $callbackObj;
	}

	public static function login(array $post)
	{
		$callbackObj = new \stdClass; //PODERIA TER FEITO COM ARRAY
		$callbackObj->user = null;
		$callbackObj->status = false;
		$callbackObj->code = null;
		$callbackObj->tentativas_restantes = null;

		$user = self::find_by_username($post['username']);

		if(!is_null($user))
		{
			$password = \HXPHP\System\Tools::hashHX($post['password'], $user->salt); //o segundo parametro e usado para gerar uma senha aleatório com o SALT que temos no banco de dados, assim sao gerados 2 senhas HASH IGUAIS.

			if($user->status == 1)
			{

				if(LoginAttempt::ExistemTentativas($user->id))
				{
					if($password['password'] === $user->password)
					{
						$callbackObj->user = $user;
						$callbackObj->status = true;

						LoginAttempt::LimparTentativas($user->id);
					}
					else
					{
						if (LoginAttempt::TentativasRestantes($user->id) <= 3 && LoginAttempt::TentativasRestantes($user->id) > 0)
						{
							$callbackObj->code = "tentativas-esgotando";
							$callbackObj->tentativas_restantes = LoginAttempt::TentativasRestantes($user->id);
						}
						else
						{
							$callbackObj->code = "dados-incorretos";
						}
						

						LoginAttempt::RegistrarTentativa($user->id);
					}
				}
				else
				{
					$callbackObj->code = "usuario-bloqueado";

					$user->status = 0;
					$user->save(false); //o parametro false serve pára pular as validações se nao vai dar erro de EXCLUSIVIDADE
				}
			}
			else //usuario bloqueado
			{
				$callbackObj->code = "usuario-bloqueado";
			}
		}
		else //usuario nao existe
		{
			$callbackObj->code = "usuario-inexistente";
		}

		return $callbackObj;
	}

	public static function atualizarSenha($user, $newPassword)
	{
		$user = self::find_by_id($user->id);

		$password = \HXPHP\System\Tools::hashHX($newPassword);

		$user->password = $password['password'];
		$user->salt = $password['salt'];
		$user->role = 2;

		return $user->save(false);
		
	}
}