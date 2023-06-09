<?php

class Database
{

    public static $instance = null;
    public $dblink = null;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getDBCon() {
        return $this->dblink;
    }
    
    function __construct()
    {
        if (is_null($this->dblink)) {
            $this->connect();
        }
    }

    function connect()
    {
        $this->dblink = mysqli_connect('localhost', 'u202003176', 'u202003176', 'db202003176') or die('CAN NOT CONNECT');
    }

    function __destruct()
    {
        if (!is_null($this->dblink)) {
            $this->close($this->dblink);
        }
    }

    function close()
    {
        mysqli_close($this->dblink);
    }

    function querySQL($sql)
    {
        
        
        
        if ($sql != null || $sql != '') {
            $result = mysqli_query($this->dblink, $sql);
            return $result;
        }
        
        if (!$result) {
            die("Error executing query: " . $this->conn->error);
        }
    }

    function singleFetch($sql)
    {

        $fet = null;
        if ($sql != null || $sql != '') {
            $res = mysqli_query($this->dblink, $sql);
            $fet = mysqli_fetch_object($res);
        }
        return $fet;
    }

    function multiFetch($sql)
    {

        $result = null;
        $counter = 0;
        if ($sql != null || $sql != '') {
            $res = mysqli_query($this->dblink, $sql);
            while ($fet = mysqli_fetch_object($res)) {
                $result[$counter] = $fet;
                $counter++;
            }
        }
        return $result;
    }

    function mkSafe($string)
    {
        /*$string = strip_tags($string);
        if (!get_magic_quotes_gpc()) {
        $string = addslashes($string);
        } else {
        $string = stripslashes($string);
        }
        $string = str_ireplace("script", "blocked", $string);
        $string = trim($string);
        */
        $string = mysqli_real_escape_string($string);

        return $string;
    }

}