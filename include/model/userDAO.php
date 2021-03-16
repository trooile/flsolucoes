<?php

include_once __DIR__.'/../default/defaultModel.php';

class UserDAO extends DefaultModel
{
    public $table = 'user';

    public function listuser($where = '', $order = ''){
		try {
			$query = "SELECT id as id_user, id_user_type, id_client_address, id_login, id_log, firstname, lastname, cpf, rg
						FROM user";
			if($where !=''){
				$query .= ' WHERE ' . $where;
			}
			if($order !=''){
				$query .= ' ORDER BY ' . $order;
			}
			return $this->executeFromServer($query);

		} catch (Exception $e) {
			throw $e;
		}
    }
}
?>