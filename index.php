
<?php

  require_once "includes/config.php";
  require_once "includes/database.php";

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Push To MySQL</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
      <div class="container">
        <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#settings">Settings</button>
        <div class="collapse" id="settings">
          Column separator:
          <select id="column_separator" class="form-control">
            <option value="1">tab</option>
            <option value="2">comma (,)</option>
            <option value="3">semicolon (;)</option>
            <option value="4">custom:</option>
          </select>
          <input type="text" class="form-control" id="custom_column_separator">
          Row separator:
          <select id="row_separator" class="form-control">
            <option value="1">enter</option>
            <option value="2">custom:</option>
          </select>
          <input type="text" class="form-control" id="custom_row_separator">
        </div>
        <h2>Database:</h2>
        <select class="form-control" id="database">
          <option disabled="disabled" selected="selected">Choose one</option>
          <?php
        
            $sql = new MySQL($config->host, $config->username, $config->password);
            foreach ($sql->getDatabases() as $db) {
              echo "<option value='" . $db . "'>" . $db . "</option>";
            }
        
          ?>
        </select>
        <div id="tables">
          <h2>Table</h2>
          <select id="table" class="form-control">
            <option disabled="disabled" selected="selected">Choose one</option>
          </select>
        </div>
        <div id="paste_data_block">
          <h2>Data:</h2>
          <textarea id="paste_data" class="form-control"></textarea>
          <button class="btn btn-success" id='process_data'>Process and append data</button>
          <button class='btn btn-warning' id='clear_paste_data'>Clear input</button>
        </div>
        <div class='overflow_scroll'>
          <table id='data_table' class='table table-striped'>
            <thead></thead>
            <tbody></tbody>
          </table>
          <button class='btn btn-success' id='add_to_sql'>Add to table</button>
          <button class='btn btn-warning' id='clear_table'>Clear table</button>
        </div>
      </div>
      <script src="js/script.js"></script>
    </body>
</html>