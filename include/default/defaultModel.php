<?php
class DefaultModel
{
    public $table;
    public $id;
    public $masterMysqli;
    public $id_sup;

    function __construct($masterMysqli)
    {
        try {

            $this->masterMysqli = $masterMysqli;

            if(isset($_SESSION['id_sup'])){
                $this->id_sup = $_SESSION['id_sup'];
            }else{
                $this->id_sup = 1; 
            }
            
	        if (mysqli_connect_errno()) throw new Exception(mysqli_connect_error());

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function escapeString($string)
    {
        try{
            return $this->masterMysqli->real_escape_string($string);
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function getLastIdInserted()
    {
        try{
            return $this->masterMysqli->insert_id;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function affectedRows()
    {
        try{
            return $this->masterMysqli->affected_rows;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function executeFromServer($query)
    {
        try{

            array_push($GLOBALS['_DB_PROFILER'],$query);

            $response = [];

            $result = $this->masterMysqli->query($query);

            if(gettype($result) =='object'){
                while ($data = $result->fetch_assoc()){
                    array_push($response, $data);
                }
            }

            return $response;

        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function getAll( $where = '', $order = '', $limit = '', $offset = '',$force_index = ''){

        try{

            $query = "SELECT * FROM ".$this->table;

            if(!empty($force_index)){
                $query .= " FORCE INDEX($force_index)";
            }

            $where != '' ? $query .= ' WHERE '. $where : $query ;

            $order != '' ? $query .= ' ORDER BY '.$order : $query ;

            $limit != '' ? $query .= ' LIMIT '.$limit : $query ;

            $offset != '' ? $query .= ' OFFSET '.$offset : $query ;

            $response = $this->executeFromServer($query);

            return $response;
        
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAllIdConcat ($column, $where = ''){

        try{

            $this->executeFromServer('SET SESSION group_concat_max_len = 4294000000;');
            
            $query = "  SELECT GROUP_CONCAT($column) as '$column'
                        FROM ".$this->table;

            $where != '' ? $query .= ' WHERE '. $where : $query ;

            $response = $this->executeFromServer($query);

            return $response;
        
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function insert($params){
        
        try{

            $query = $this->prepareInsert($params);

            $response = $this->executeFromServer($query);
            
            return $this->getLastIdInserted();
    
        } catch (Exception $e) {
            throw $e;
        }

    }

    public function insertUpdate($params){
        
        try{

            $query = $this->prepareInsertUpdate($params);

            $response = $this->executeFromServer($query);
            
            return $this->getLastIdInserted();
    
        } catch (Exception $e) {
            throw $e;
        }

    }

    public function update($params, $where = ''){
        try{

            if(empty($where)){
                throw new Exception('UPDATE sem WHERE no banco de dados',-1);
            }
            
            $query =  $this->prepareUpdate($params, $where);

            $response = $this->executeFromServer($query);
            
            return [];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete($where = ''){

        try{

            if(empty($where)){
                throw new Exception('DELETE nul WHERE no db',-1);
            }

            $query =  "DELETE FROM ".$this->table." WHERE ".$where;

            $response = $this->executeFromServer($query);
            
            return [];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function count($where = ''){

        try{
            $query =  " SELECT COUNT(*) as 'count' 
                        FROM ".$this->table;

            $where != '' ? $query .= ' WHERE '. $where : $query ;

            $response = $this->executeFromServer($query);
            
            return $response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function sum($column,$where = ''){

        try{
            $query =  " SELECT SUM(".$column.") as 'sum' 
                        FROM ".$this->table;

            $where != '' ? $query .= ' WHERE '. $where : $query ;

            $response = $this->executeFromServer($query);
            
            return $response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function max($column,$where = ''){

        try{
            $query =  " SELECT MAX(".$column.") as 'max' 
                        FROM ".$this->table;

            $where != '' ? $query .= ' WHERE '. $where : $query ;

            $response = $this->executeFromServer($query);
            
            return $response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function min($column,$where = ''){

        try{
            $query =  " SELECT MIN(".$column.") as 'min' 
                        FROM ".$this->table;

            $where != '' ? $query .= ' WHERE '. $where : $query ;

            $response = $this->executeFromServer($query);
            
            return $response;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    function prepareInsert($params){

        try{
            $params =  $this->prepareParams($params);
            
            $stats = implode('`,`',array_keys($params));
            $values = implode(',',$params);

            return "INSERT INTO ".$this->table." (`".$stats."`)"." VALUES (".$values.")";
        } catch (Exception $e) {
            throw $e;
        }
    }

    function prepareInsertUpdate($params){

        try{
            $params =  $this->prepareParams($params);

            $arrayParams = [];
            foreach($params as $key=>$value){
                array_push($arrayParams,'`'.$key."` = ".$value);
            }
            
            $stats = implode('`,`',array_keys($params));
            $values = implode(',',$params);
            
            return "INSERT INTO ".$this->table." (`".$stats."`)"." VALUES (".$values.") ON DUPLICATE KEY UPDATE ".implode(',',$arrayParams);
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    
    function prepareInsertIgnore($params){

        try{
            $params =  $this->prepareParams($params);
            
            $stats = implode('`,`',array_keys($params));
            $values = implode(',',$params);

            return "INSERT IGNORE INTO ".$this->table." (`".$stats."`)"." VALUES (".$values.")";
        } catch (Exception $e) {
            throw $e;
        }
    }

    function prepareUpdate($params,$where = ''){
        try{
            $params =  $this->prepareParams($params);

            $arrayParams = [];
            foreach($params as $key=>$value){
                array_push($arrayParams,'`'.$key."` = ".$value);
            }

            if($where !=''){
                $where = " WHERE ".$where;
            }

            return "UPDATE ".$this->table." SET ".implode(',',$arrayParams).$where;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function prepareParams($params){
        try{
            
            foreach($params as $key=>$value){

                if(is_object($value)){
                    $params[$key] = $value->getSql();
                }else{
                    if(is_null($value)){
                        $params[$key] = "null";
                    }else{
                        if (!is_numeric($value)){

                            $value = str_replace('\r\n',PHP_EOL,$value); 

                            $value = str_replace('\\','',$value); 

                            $params[$key] = "'".$this->convertDate($this->masterMysqli->real_escape_string($value))."'"; 
                            
                        }else{
                            $params[$key] = "'".$value."'"; 
                        }
                    }     
                }

            }
            
            return $params;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function convertDate($value){
        try{
            $dateParser = DateTime::createFromFormat("d/m/Y", $value);;
        
            if($dateParser){
                $value = $dateParser->format('Y-m-d'); 
            }

            return $value;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function whereGenerator($params){
        
        $return = ['1=1'];

        if(!empty($params)){
            foreach($params as $key=>$value){

                if ($value!=""){
                    $where = '';

                    $filter = explode(':', $key);
    
                    $column = $filter[0];
                    $stats_type = $filter[1];

                    

                    if(is_array($value)){
                        $value = implode(',',$value);
                    }
                    
                    switch ($stats_type) {
                        case 'int':
                        case 'float':
    
                        $where .=  $column." = ".$value;
                            break;
                        case 'varchar':
                            $where .=  $column." like('%".$value."%')";
                            break;
                        case 'date':
                            $where .=  $column." ='".$this->convertData($value)."'";
                            break;

                        case 'intin':
                            $where .=  $column."  IN (".$value.")";
                            break;
                    }
    
                    $return[] =  $where;
                } 
            }
        }

        return implode(' AND ',$return);
    }

}
?>