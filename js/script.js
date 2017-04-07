$(document).ready(function(){
    
  var separator = parseInt($("#separator").val());
  
  $("#separator").change(function(){
     separator = parseInt($("#separator").val());
     if (separator == 4) {
       $("#custom_separator").css("display", "inline-block");
     } else {
       $("#custom_separator").hide();
     }
  });
  
  
  $("#database").change(function(){
    var database = $(this).val();
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
  
});