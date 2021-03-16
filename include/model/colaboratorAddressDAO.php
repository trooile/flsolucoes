<?php

include_once __DIR__.'/../default/defaultModel.php';

class ColaboratorAddressDAO extends DefaultModel
{
    public $table = 'colaborator_address';

    public function listcolaboratoraddress($where = '', $order = ''){
		try {
			$query = "SELECT id as id_colaborator_address, cep, street, number, district, city, state, country
						FROM colaborator_address";
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