<?php

namespace Configuration;

use Exception;
use mysqli;

class Config
{
    private
        $bd,
        $path;

    function __construct()
    {
        $dir = __DIR__;

        switch ($server) {
            case 'pti':
                $database = "localtest7";
                $user = "root";
                $server = "localhost";
                $pass = "";
                break;

            case '':
                $database = "";
                $user = "";
                $server = "";
                $pass = "";
                break;

            default:
                throw new Exception("Invalid 3.", 1);
                break;
        }

        $this->path = Array('root' => "C:\wamp64\www\flsolucoes",
                            'bd' => "C:\wamp64\www\flsolucoes/includes/bd.php",
                            'admin' => "C:\wamp64\www\flsolucoes/admin/",
                            'include' => "C:\wamp64\www\flsolucoes/include/",
                            'images' => "C:\wamp64\www\flsolucoes/images/");

        $this->bd = Array('server' => $server, 'user' => $user, 'pass' => $pass, 'database' => $database);

        if(getenv('APPLICATION_ENV') == 'local'){
            $this->bd = Array('server' => "localhost", 'user' => 'root', 'pass' => "", 'database' => 'localtest7');
            $this->path = Array('root' => "/",
                                'bd' => "includes/bd.php",
                                'include' => "include/",
                                'images' => "images/");
        }
    }

    public function executeFromServer($query)
    {
        $server = $this->getDBServer();
        $user = $this->getDBUser();
        $pass = $this->getDBPass();
        $database = $this->getDBName();

        $conn = new mysqli($server, $user, $pass, $database);
        if (mysqli_connect_errno()) throw new Exception(mysqli_connect_error());

        $conn->query("SET NAMES 'utf8'");
        $conn->query('SET character_set_connection=utf8');
        $conn->query('SET character_set_client=utf8');
        $conn->query('SET character_set_results=utf8');

        $result = $conn->query($query);
        if (is_bool($result)) {
            return Array('error' => !$result, 'query' => $query, 'id' => $conn->insert_id, 'error_description' => $conn->error );
        } else {
            $response = Array();
            while ($data = $result->fetch_assoc())
                array_push($response, $data);
            return $response;
        }
        mysqli_close($conn);
    }

    public function getDB(){
        return $this->bd;
    }

    public function getPath(){
        return $this->path;
    }

    public function getDBServer(){
        return $this->bd['server'];
    }

    public function getDBUser(){
        return $this->bd['user'];
    }

    public function getDBPass(){
        return $this->bd['pass'];
    }

    public function getDBName(){
        return $this->bd['database'];
    }

    public function getPathRoot(){
        return $this->path['root'];
    }

    public function getPathDB(){
        return $this->path['bd'];
    }

    public function getPathIncludes(){
        return $this->path['include'];
    }

    public function getPathImg()
    {
        return $this->path['images'];
    }
}