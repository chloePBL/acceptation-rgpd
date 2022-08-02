$(document).ready(function(){
   
   var InpuOptIn = $(".checkboxes");
   if (InpuOptIn.prop("checked") == true) {
      $("#opt_in_none").prop("checked", false);
   }
   $('#opt_in_none').click(function(){
      if (this.checked) {
         $(".checkboxes").prop("checked", false);
      }	
   });
   $('.checkboxes').click(function(){
      if (this.checked == true) {
         $("#opt_in_none").prop("checked", false);
      }	
   });
   
});