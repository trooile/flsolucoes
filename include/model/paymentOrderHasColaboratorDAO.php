<?php

include_once __DIR__.'/../default/defaultModel.php';

class PaymentOrderHasColaboratorDAO extends DefaultModel
{
    public $table = 'payment_order_has_colaborator';

    public function listpaymentorderhascolaborator($where = '', $order = ''){
		try {
			$query = "SELECT id_payment_order, id_payment_type, id_colaborator, id_colaborator_type 
						FROM payment_order_has_colaborator";
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