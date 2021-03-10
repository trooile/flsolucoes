<?php
include_once __DIR__ . "/../configuration/Config.php";
use Configuracoes\Config;
$Config = new Config();
$server = $Config->getDBServer();
$user = $Config->getDBUser();
$pass = $Config->getDBPass();
$database = $Config->getDBName();

if (!isset($con) || !mysql_ping($con)){
    $con = mysql_pconnect ( $server, $user, $pass ) or die ( 'Connection DB Error!' );
    mysql_select_db ( $database, $con );

    mysql_query("SET NAMES 'utf8'");
    mysql_query('SET character_set_connection=utf8');
    mysql_query('SET character_set_client=utf8');
    mysql_query('SET character_set_results=utf8');
}

?>
