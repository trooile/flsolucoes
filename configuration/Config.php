<?php

namespace Configuracoes;

use Exception;
use mysqli;

class Config
{
    private
        $bd,
        $path,
        $apiKeyPagarMe;

    /**
     * Config constructor.
     * Detecta automaticamente qual portal você está usando e seta os paths e a configuração do BD automaticamente
     */
    function __construct()
    {
        $dir = __DIR__;

        if(isset($_SERVER['USER']) && $_SERVER['USER']=='root'){//cron
            if(isset($_SERVER['HOSTNAME'])){
                switch ($_SERVER['HOSTNAME']) {
                    case 'portal.cedet.com.br':
                    case 'portal.cedet.internal':
                        $ambiente = "portal";
                        break;

                    case 'portaldev.cedet.com.br':
                        $ambiente = "portaldev";
                        break;

                    default:
                        printar($_SERVER);
                        throw new Exception("Parâmetros inválidos para ".$_SERVER['HOSTNAME'], 1);
                        break;
                }
            }
            else{ //cron nao tem hostname
                $ambiente = "portal";
            }

        }
        else //acesso via web, usa o hostname
        switch(getenv('HTTP_HOST')){
            case 'portal.cedet.com.br':
            case 'portal.cedet.com.br:443':
            case 'portal-intra.cedet.com.br':
            case 'portal-intra.cedet.com.br:443':
                $ambiente = "portal";   
                break;  

            case 'portaldev.cedet.com.br':
            case 'portaldev.cedet.com.br:443':
                $ambiente = "portaldev";
                break;  

            case 'portal':
                $ambiente = "portal";
                break;  

            default:
                throw new Exception("Parâmetros inválidos 2.", 1);
                break;
        }

        switch ($ambiente) {
            case 'portal':
                $database = "localtest";
                $user = "root";
                $server = "localhost";
                $pass = "";
                break;

            case 'portaldev':
                $database = "portal_homologacao";
                $user = "cedet_portaldev";
                $server = "localhost";
                $pass = "WQNcCZzQHzAAfmBBzz";
                break;

            case '':
                $database = "";
                $user = "";
                $server = "";
                $pass = "";
                break;

            default:
                throw new Exception("Parâmetros inválidos 3.", 1);
                break;
        }

        $this->path = Array('root' => "C:\wamp64\www\portal",
                            'bd' => "C:\wamp64\www\portal/includes/bd.php",
                            'admin' => "C:\wamp64\www\portal/admin/",
                            'includes' => "C:\wamp64\www\portal/includes/",
                            'classes' => "C:\wamp64\www\portal/includes/classes/",
                            'img' => "C:\wamp64\www\portal/img/",
                            'file' => "C:\wamp64\www\portal/files/",
                            'tmp' => "C:\wamp64\www\portal/tmp/",
                            'productPictures' => "C:\wamp64\www\portal/files/cadastros/products/");

        $this->bd = Array('server' => $server, 'user' => $user, 'pass' => $pass, 'database' => $database);
        $this->apiKeyPagarMe = "ak_live_cMBhHW4PvsIgCoMm3WXEWrUQ2jCdbk";

        if(getenv('APPLICATION_ENV') == 'local'){
            $this->bd = Array('server' => "localhost", 'user' => 'root', 'pass' => "", 'database' => 'localtest');
            $this->apiKeyPagarMe = "ak_live_cMBhHW4PvsIgCoMm3WXEWrUQ2jCdbk";
            $this->path = Array('root' => "/",
                                'bd' => "includes/bd.php",
                                'admin' => "admin/",
                                'includes' => "includes/",
                                'classes' => "includes/classes/",
                                'img' => "img/",
                                'file' => "files/",
                                'tmp' => "tmp/",
                                'productPictures' => "files/cadastros/products/");
        }
    }

    /**
     * @param $query
     * @return array
     * @throws Exception
     * Executa uma query no Portal
     */
    public function executeFromPortal($query)
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

    public
    function getDB()
    {
        return $this->bd;
    }

    public
    function getPath()
    {
        return $this->path;
    }

    public
    function getDBServer()
    {
        return $this->bd['server'];
    }

    public
    function getDBUser()
    {
        return $this->bd['user'];
    }

    public
    function getDBPass()
    {
        return $this->bd['pass'];
    }

    public
    function getDBName()
    {
        return $this->bd['database'];
    }

    public
    function getPathRoot()
    {
        return $this->path['root'];
    }

    public
    function getPathDB()
    {
        return $this->path['bd'];
    }

    public
    function getPathAdmin()
    {
        return $this->path['admin'];
    }

    public
    function getPathIncludes()
    {
        return $this->path['includes'];
    }

    public
    function getPathClasses()
    {
        return $this->path['classes'];
    }

    public
    function getPathImg()
    {
        return $this->path['img'];
    }

    public
    function getPathFile()
    {
        return $this->path['file'];
    }

    public
    function getPathImgProducts()
    {
        return $this->path['productPictures'];
    }

    public
    function getPathTmp()
    {
        return $this->path['tmp'];
    }
    public function getPagarMeKey()
    {
        return $this->apiKeyPagarMe;
    }
}