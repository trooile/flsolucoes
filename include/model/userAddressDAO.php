<?php

include_once __DIR__.'/../default/defaultModel.php';

class UserAddressDAO extends DefaultModel
{
    public $table = 'user_address';

    public function listUserAddress($where = '', $order = ''){
		try {
			$query = "SELECT id as id_client_address, cep, street, number, district, city, state, country
						FROM user_address";
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