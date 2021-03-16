<?php

include_once __DIR__.'/../default/defaultModel.php';

class ColaboratorDAO extends DefaultModel
{
    public $table = 'colaborator';

    public function listcolaborator($where = '', $order = ''){
		try {
			$query = "SELECT id as id_colaborator, id_colaborator_type, id_colaborator_address, cnpj, name
						FROM colaborator";
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