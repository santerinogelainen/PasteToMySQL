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
            die("Error getting databases. Error: " . $this->mysqli->error);
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
            die("Error getting tables. Error: " . $this->mysqli->error);
        }
    }
    
    
    public function getColumns($table) {
        //fuck you mysqli for not accepting table name as '?'
        if ($result = $this->mysqli->query("DESCRIBE " . $this->mysqli->real_escape_string($table))) {
            $results = array();
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $results[] = $row;
            }
            return $results;
        } else {
            die("Error getting columns. Error: " . $this->mysqli->error);
        }
    }
    
    
    public function insert($table, $columns, $data) {
        $sql = "INSERT INTO `" . $this->mysqli->real_escape_string($table) . "`(";
        foreach ($columns as $index => $column) {
            if ($column != "0") {
                if ($index != 0) {
                    $sql .= ",";
                }
                $sql .= "`" . $this->mysqli->real_escape_string($column) . "`";
            }
        }
        $sql .= ") VALUES (";
        foreach ($data as $index => $value) {
            if ($columns[$index] != "0") {
                if ($index != 0) {
                    $sql .= ",";
                }
                if (is_numeric($value)) {
                    $sql .= $this->mysqli->real_escape_string($value);
                } else {
                    $sql .= "'" . $this->mysqli->real_escape_string($value) . "'";
                }
            }
        }
        
        $sql .= ")";
        if ($result = $this->mysqli->query($sql)) {
            return "Success.";
        } else {
            die("Error inserting data. Error: " . $this->mysqli->error);
        }
    }
    
    
}


?>