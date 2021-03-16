<?php

include_once __DIR__.'/../default/defaultModel.php';

class LogControllerDAO extends DefaultModel
{
    public $table = 'log_controller';

    public function listlogcontroller($where = '', $order = ''){
		try {
			$query = "SELECT id as id_log_controller
						FROM log_controller";
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