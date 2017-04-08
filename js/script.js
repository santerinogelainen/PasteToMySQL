$(document).ready(function(){
    
  var separator = parseInt($("#separator").val());
  var database = "";
  var table = "";
  
  $("#separator").change(function(){
     separator = parseInt($("#separator").val());
     if (separator == 4) {
       $("#custom_separator").css("display", "inline-block");
     } else {
       $("#custom_separator").hide();
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
    console.log(rows);
  });
  
});