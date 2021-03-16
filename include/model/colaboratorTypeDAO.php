<?php

include_once __DIR__.'/../default/defaultModel.php';

class ColaboratorTypeDAO extends DefaultModel
{
    public $table = 'colaborator_type';

    public function listcolaboratortype($where = '', $order = ''){
		try {
			$query = "SELECT id as id_colaborator_type, name
						FROM colaborator_type";
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