<?php

include_once __DIR__.'/../default/defaultModel.php';

class UserPermissionDAO extends DefaultModel
{
    public $table = 'user_permission';

    public function listuserpermission($where = '', $order = ''){
		try {
			$query = "SELECT id as id_user_permission, id_user, id_user_type, id_client_address
						FROM user_permission";
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