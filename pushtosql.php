<?php

require_once "includes/config.php";
require_once "includes/database.php";

$sql = new MySQL($config->host, $config->username, $config->password, $_POST["db"]);

echo $sql->insert($_POST["table"], $_POST["columns"], $_POST["data"]);


?>