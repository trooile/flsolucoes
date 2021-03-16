<?php

include_once __DIR__.'/../default/defaultModel.php';

class LoginDAO extends DefaultModel
{
    public $table = 'login';

    public function listlogin($where = '', $order = ''){
		try {
			$query = "SELECT id as id_login, date_login
						FROM login";
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