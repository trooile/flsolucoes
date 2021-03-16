<?php

include_once __DIR__.'/../default/defaultModel.php';

class TutorialTypeDAO extends DefaultModel
{
    public $table = 'tutorial_type';

    public function listtutorialtype($where = '', $order = ''){
		try {
			$query = "SELECT id as id_tutorial_type
						FROM tutorial_type";
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