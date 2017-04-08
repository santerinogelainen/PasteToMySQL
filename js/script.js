$(document).ready(function(){
    
  var columnseparator = parseInt($("#column_separator").val());
  var rowseparator = parseInt($("#row_separator").val());
  var database = "";
  var table = "";
  
  $("#column_separator").change(function(){
     columnseparator = parseInt($("#column_separator").val());
     if (columnseparator == 4) {
       $("#custom_column_separator").css("display", "inline-block");
     } else {
       $("#custom_column_separator").hide();
     }
  });
  
  $("#row_separator").change(function(){
     rowseparator = parseInt($("#row_separator").val());
     if (rowseparator == 2) {
       $("#custom_row_separator").css("display", "inline-block");
     } else {
       $("#custom_row_separator").hide();
     }
  });
  
  
  $("#database").change(function(){
    database = $(this).val();
    $.ajax({
      url: "gettables.php",
      type: "POST",
      data: {"db": database},
      success: function(data) {
        $("#table .replace_me").remove();
        $("#table").append(data);
        $("#tables").show();
      }
    });
  });
  
  
  $("#table").change(function(){
    table = $(this).val();
    $.ajax({
      url: "getcolumns.php",
      type: "POST",
      data: {"db": database, "table": table},
      success: function(data) {
        $("#data_table thead").replaceWith(data);
        $(".overflow_scroll, #paste_data_block").show();
      }
    });
  });
  
  
  $("#process_data").click(function(){
    var pastedata = $("#paste_data").val();
    var rows = pastedata.split(/\r|\n/);
    var i = 0;
    while (i < rows.length) {
      switch (columnseparator) {
        case 1:
          var columns = rows[i].split('\t');
          break;
        case 2:
          var columns = rows[i].split(',');
          break;
        case 3:
          var columns = rows[i].split(';');
          break;
        case 4:
          var separator = $("#custom_column_separator").val();
          var columns = rows[i].split(separator);
          break;
        default:
          alert("Error.");
          return;
      }
      var html = "<tr><td class='remove_row' onclick='removeRow(this);'>&#x2716;</td>";
      var x = 0;
      while (x < columns.length) {
        html += "<td><textarea class='form-control'>" + columns[x] + "</textarea></td>";
        x++;
      }
      html += "</tr>";
      $("#data_table tbody").append(html);
      i++;
    }
    $("#paste_data").val("");
  });
  
  
  
  $("#add_to_sql").click(function(){
    var columns = $("#data_table thead tr th select");
    var column = [];
    columns.each(function(){
      column.push($(this).val());
    });
    var rows = $("#data_table tbody tr");
    rows.each(function(){
      var datacol = $(this).find("td textarea");
      var data = [];
      datacol.each(function(){
        data.push($(this).val());
      });
      $.ajax({
        url: "pushtosql.php",
        type: "POST",
        data: {"db": database, "table": table, "columns": column, "data": data},
        success: function(data) {
          console.log(data);
        }
      });
    });
  });
  
  
  $("#clear_paste_data").click(function(){
    $("#paste_data").val("");
  });
  
  $("#clear_table").click(function(){
    $("#data_table tbody *").remove();
  });
  
  
});


function removeRow(element) {
  $(element).parent().remove();
}