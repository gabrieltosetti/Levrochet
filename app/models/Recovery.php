<?php 

class Recovery extends \HXPHP\System\Model
{
	public static function validar($user_email)
	{
		$callback_obj = new \stdClass;
		$callback_obj->user = null;
		$callback_obj->code = null;
		$callback_obj->status = false;

		$user_exists = User::find_by_email($user_email);

		if( !is_null($user_exists))
		{
			$callback_obj->status = true;
			$callback_obj->user = $user_exists;

			self::delete_all(array(
				'conditions' => array(
					'user_id = ?',
					$user_exists->id
				)
			));
		}
		else
		{
			$callback_obj->code = 'nenhum-usuario-encontrado';
		}

		return $callback_obj;
	}
}