<?php


class MySQL {
    
    private $mysqli;
    
    function __construct($host, $username, $password, $db = "") {
        $this->mysqli = new mysqli($host, $username, $password);
        $this->setCharset("utf8");
        $this->setDatabase($db);
        $this->checkConnectionError();
    }
    
    
    private function checkConnectionError() {
        if ($this->mysqli->connect_error) {
            die('Connect Error (' . $this->mysqli->connect_errno . ') '. $this->mysqli->connect_error);
        }
    }
    
    
    private function setDatabase($db) {
        $this->mysqli->select_db($db);
    }
    
    
    private function setCharset($charset) {
        if (!$this->mysqli->set_charset($charset)) {
            printf("Error loading character set utf8: %s\n", $this->mysqli->error);
            exit();
        }
    }
    
    public function getDatabases() {
        if ($result = $this->mysqli->query("SHOW DATABASES")) {
            $results = array();
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                $results[] = $row[0];
            }
            return $results;
        } else {
            die("Error getting databases.");
        }
    }
    
    
    public function getTables() {
        if ($result = $this->mysqli->query("SHOW TABLES")) {
            $results = array();
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                $results[] = $row[0];
            }
            return $results;
        } else {
            die("Error getting tables.");
        }
    }
    
    
}


?>