<?php

include_once __DIR__.'/../default/defaultModel.php';

class TutorialItemDAO extends DefaultModel
{
    public $table = 'tutorial_item';

    public function listtutorialitem($where = '', $order = ''){
		try {
			$query = "SELECT id as id_tutorial_item, id_tutorial
						FROM tutorial_item";
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