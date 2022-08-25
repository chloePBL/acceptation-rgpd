$(document).ready(function(){
   // Script qui permet de décocher les opt-in si le client coche la case précisant qu'il ne souhaite pas recevoir des com.
   var InpuOptIn = $(".checkboxes");
   // Vérifie si la case "aucun moyen com" est coché
   if (InpuOptIn.prop("checked") == true) {
      $("#opt_in_none").prop("checked", false);
   }
   // "Aucun moyen de com" coché, toutes les checkboxes décochées
   $("#opt_in_none").click(function(){
      if (this.checked) {
         $(".checkboxes").prop("checked", false);
      }	
   });
   // Si un des moyens de com choisi, la case "aucun moyen de com" décoché
   $(".checkboxes").click(function(){
      if (this.checked == true) {
         $("#opt_in_none").prop("checked", false);
      }	
   });

   // Vérif envoie formulaire si au moins une case est coché et si ce n'est pas le cas afffichage d'un message d'erreur
  $(".msgError").hide();
  $(".form").submit(function(event){               
   //on vérifie que nos conditions d'envoi sont bonnes
      if (countCheckedJQuery() <= 0){
         //on empêche le questionnaire de s'envoyer
         $(".msgError").html("<p><span><img src='./assets/img/icone-error.svg' alt='icone message erreur'></span> Veuillez faire un choix.</p>");
         $(".msgError").fadeIn("slow");
         event.preventDefault();
      }
   });
   function countCheckedJQuery(){
      var checked = $("input:checkbox:checked");//pareil mais avec toutes les checkbox de la page
      return checked.length;
   }
});