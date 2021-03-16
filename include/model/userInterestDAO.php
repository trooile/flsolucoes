<?php

include_once __DIR__.'/../default/defaultModel.php';

class UserInterestDAO extends DefaultModel
{
    public $table = 'user_interest';

    public function listuserinterest($where = '', $order = ''){
		try {
			$query = "SELECT id as id_user_interest, id_user
						FROM user_interest";
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