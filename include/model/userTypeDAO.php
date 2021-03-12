<?php

include_once __DIR__.'/../default/defaultModel.php';

class UserTypeDAO extends DefaultModel
{
    public $table = 'user_type';

    public function listUserType($where = '', $order = ''){
		try {
			$query = "SELECT id as id_user_type, name_type
						FROM user_type";
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