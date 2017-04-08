<?php

require_once "includes/config.php";
require_once "includes/database.php";

$sql = new MySQL($config->host, $config->username, $config->password, $_POST["db"]);

$columns = $sql->getColumns($_POST["table"]);

echo "<thead>";
foreach($columns as $columnindex => $columndata) {
    echo "<th><select><option value='0' style='color: red;'>Ignore</option>";
    foreach($columns as $optionindex => $optiondata) {
        if ($columnindex == $optionindex) {
            echo "<option selected='selected' value='" . $optiondata["Field"] . "'>" . $optiondata["Field"] . " " . $optiondata["Type"] . "</option>";
        } else {
            echo "<option value='" . $optiondata["Field"] . "'>" . $optiondata["Field"] . " " . $optiondata["Type"] . "</option>";
        }
    }
    echo "</select></th>";
}
echo "</thead>";


?>