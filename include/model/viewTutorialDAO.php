<?php

include_once __DIR__.'/../default/defaultModel.php';

class ViewTutorialDAO extends DefaultModel
{
    public $table = 'view_tutorial';

    public function listviewtutorial($where = '', $order = ''){
		try {
			$query = "SELECT id as id_view_tutorial, id_user, id_payment
						FROM view_tutorial";
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