<?php

include_once __DIR__.'/../default/defaultModel.php';

class PaymentOrderDAO extends DefaultModel
{
    public $table = 'payment_order';

    public function listpaymentorder($where = '', $order = ''){
		try {
			$query = "SELECT id as id_payment_order, id_payment_type
						FROM payment_order";
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