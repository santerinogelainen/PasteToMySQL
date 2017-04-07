<?php

require_once "includes/config.php";
require_once "includes/database.php";

$sql = new MySQL($config->host, $config->username, $config->password, $_POST["db"]);

foreach ($sql->getTables() as $table) {
    echo "<option class='replace_me' value='" . $table . "'>" . $table . "</option>";
}

?>