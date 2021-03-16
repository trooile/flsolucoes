<?php

include_once __DIR__.'/../default/defaultModel.php';

class PaymentTypeDAO extends DefaultModel
{
    public $table = 'payment_type';

    public function listpaymenttype($where = '', $order = ''){
		try {
			$query = "SELECT id as id_payment_type
						FROM payment_type";
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