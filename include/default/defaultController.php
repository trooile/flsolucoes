<?php
date_default_timezone_set('America/Sao_Paulo');
include_once __DIR__.'/../../configuration/Config.php';
include_once __DIR__.'/mysqliExpression.php';

Class DefaultController{

    public $masterMysqli;
    public $id_sup;
    public $id_log_controller;
    public $flag_save_log = 1;
    
    function __construct($preventXss = false)
    {
        try{

            $this->preventXss = $preventXss;


            global $_DB_PROFILER;
            $_DB_PROFILER = [];

            set_error_handler('callbackException');

            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 

            $config = new Configuration\Config();

            $this->masterMysqli = new mysqli($config->getDBServer(),$config->getDBUser(),$config->getDBPass(),$config->getDBName());
            $this->masterMysqli->set_charset("utf8");

	        if (mysqli_connect_errno()) throw new Exception(mysqli_connect_error());
            
            $_POST = $this->xSQLInjection($_POST);
            $_GET = $this->xSQLInjection($_GET);
            $_REQUEST = $this->xSQLInjection($_REQUEST);
            
            if(isset($_SESSION['id_sup'])){
                $this->id_sup = $_SESSION['id_sup'];
            }else{
                $this->id_sup = 1; 
            }
            $this->return = array('error'=> false, 'data'=> array(), 'message'=>'');

            if($this->flag_save_log){
                $this->logControllerDAO = new LogControllerDAO($this->masterMysqli);

                $bind_log_controller = ['controller' => ''];

                if(!isset($_SERVER['REQUEST_URI'])){
                    $bind_log_controller['server'] = json_encode($_SERVER);
                    if(isset($_SERVER['PHP_SELF'])){
                        $bind_log_controller['controller'] = $_SERVER['PHP_SELF'];
                    }
                    elseif(isset($_SERVER['SCRIPT_NAME'])){
                        $bind_log_controller['controller'] = $_SERVER['SCRIPT_NAME'];
                    }

                }
                else{
                    $bind_log_controller['controller'] = $_SERVER['REQUEST_URI'];
                }

                if(!in_array($bind_log_controller['controller'],$this->array_ignorar_log)){                             
                    $this->id_log_controller = $this->logControllerDAO->insert($bind_log_controller);
                }
            }

        }catch(Exception $e){
            $this->return($e);
        }
    }

    function return($exception = null){
        try{

                    $GLOBALS['_DB_PROFILER'] = preg_replace('/\s\s+/', ' ', $GLOBALS['_DB_PROFILER']);
                    $this->retorno['lastSql'] = $GLOBALS['_DB_PROFILER'];

            if($exception == null){
                
                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    echo json_encode($this->return);
                }
            }else{

                $this->return['error'] =  true;
                $this->return['message'] =  'Error: '.$exception->getMessage();

                    $this->return['erroMensagem'] =  $exception->getMessage();


                if($exception->getCode() == -1){
                    $this->return['message'] =  $exception->getMessage();
                }

                if($exception->getCode() == -2){
                    $return_ws =  json_decode($exception->getMessage(),true);

                    if(is_array($return_ws)){
                        if($retorno_ws['exception_code'] == -1){
                            $this->return['message'] = $return_ws['message'];
                        }else{
                            $this->return['message'] = 'Error Web Service: '.$retorno_ws['message'];
                        }
                            $this->return['return_ws'] = $return_ws;

                    }else{
                        $this->return['message'] =  'Decode Exception Ws. ';
                    } 
                }

                if(!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] == 'POST'){
                    echo json_encode($this->return);
                }else{

                    if(getenv('APPLICATION_ENV') == 'localhost' || getenv('HTTP_HOST') == '' ){
                        echo json_encode($this->return);
                    }else{
                        throw $exception; 
                    } 
                }   
            }
        }catch(Exception $e){
            throw $e;
        }
    }

    function returnFile($file_name,$complete_address,$new_file_name =  ''){
        try{

            $content = file_get_contents($complete_address);
            
            if($content == false){
                throw new Exception('File Not Found');
            }

            if($new_file_name != ''){
                $file_name = $new_file_name;
            }
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$file_name.'"');
            
            if(getenv('APPLICATION_ENV') == 'localhost'){
                ob_clean();
            }
            echo $content;

        }catch(Exception $e){
            throw $e;
        }
    }

    function returnTextFile($text,$file_name =  ''){
        try{
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$file_name.'"');

            if(getenv('APPLICATION_ENV') == 'local'){
                ob_clean();
            }
            echo $text;

        }catch(Exception $e){
            throw $e;
        }
    }

    public function xSQLInjection($request){
        try{
            return $this->letterCount($request);  
        }catch(Exception $e){
            throw new Exception('Error sql');
        }
    }

    public function letterCount($params){
        try{

            if(is_array($params)){			
                foreach($params as $key=>$value){
                    $params[$key] = $this->letterCount($value);
                }
        
            }else{

                if(is_string($params)){

                    $temp_param = json_decode($params, true);
                    
                    if(is_array($temp_param)){

                        if(!empty($temp_param)){

                            foreach($temp_param as $key=>$value){
                                $temp_param[$key] = $this->letterCount($value);
                            }
                            $params = json_encode($temp_param);
                        }
                    }else{
                        $params = $this->masterMysqli->real_escape_string($params);
                        
                        if($this->preventXss){
                            $params = htmlspecialchars($params, ENT_QUOTES, 'UTF-8');
                        }

                    }

                }else{
                    $params = $this->masterMysqli->real_escape_string($params);

                    if($this->preventXss){
                        $params = htmlspecialchars($params, ENT_QUOTES, 'UTF-8');
                    }
                    
                }

                $dicionary = array('select', 'insert', 'update', 'delete', 'drop', 'truncate', 'create', 'function', 'view', 'trigger', 'procedure', 'database', 'exists', 'alter');
                $params =  explode(' ',  $params);

                foreach($params as $key=>$value){
                    if(in_array(strtolower($value),$dicionary)){
                        unset($params[$key]);
                    }
                }

                $params = implode(" ",$params);

            }

            return $params;
        }catch(Exception $e){
            throw new Exception('Error sql');
        }

    }

    function recusivEscapeString($bind){
        try{

            
            if(is_array($bind)){

                foreach($bind as $key => $value){
                    $bind[$key] = $this->recusivEscapeString($value);
                }

            }else{
                $bind = $this->masterMysqli->real_escape_string($bind);
            }

            return $bind;

        }catch(Exception $e){
            throw $e;
        }
    }

    function admin(){
        
        if (!preg_match('/admin/',$_SESSION['userPermissions'])){
            exit;
        }
    }

    public function filterMaster($string){

        return $this->masterMysqli->real_escape_string(iconv(mb_detect_encoding($string, mb_detect_order(), true), "UTF-8//IGNORE", $string));
    }
    
}
?>