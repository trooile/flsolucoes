<?php

include_once __DIR__.'/../default/defaultModel.php';

class LogDAO extends DefaultModel
{
    public $table = 'log';

    public function listlog($where = '', $order = ''){
		try {
			$query = "SELECT id as id_log, id_log_controller, id_colaborator, id_login
						FROM log";
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