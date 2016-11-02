<?php 

class User extends \HXPHP\System\Model
{
	public static function cadastrar(array $post)
	{
		//vai ate a tabela Role e pega a linha do tipo de usuário "user"
		$role = Role::find_by_role('user');
		//coloca no post o ID do 'user' e o status 1
		$post = array_merge($post, array(
			'role_id' => $role->id,
			'status' => 1 
			));
		//pega a senha do form e criptografa ela
		$password = \HXPHP\System\Tools::hashHX($post['password']);
		//troca a senha 'string' para a senha 'criptografada'
		$post = array_merge($post, $password);
		//usa o POST como array para criação de um novo iten na tabela users
		return self::create($post);
	}
}