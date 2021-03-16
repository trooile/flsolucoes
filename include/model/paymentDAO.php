<?php

include_once __DIR__.'/../default/defaultModel.php';

class PaymentDAO extends DefaultModel
{
    public $table = 'payment';

    public function listpayment($where = '', $order = ''){
		try {
			$query = "SELECT id as id_payment, id_payment_order
						FROM payment";
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