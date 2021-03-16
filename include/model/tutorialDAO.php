<?php

include_once __DIR__.'/../default/defaultModel.php';

class TutorialDAO extends DefaultModel
{
    public $table = 'tutorial';

    public function listtutorial($where = '', $order = ''){
		try {
			$query = "SELECT id as id_tutorial,id_payment_order, id_payment_type
						FROM tutorial";
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