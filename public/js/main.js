// =======================================================================
// Main
// =======================================================================

define('common', [
    "/components/jquery/jquery.min.js",
    "/components/bootstrap/js/bootstrap-collapse.js",
    "/components/bootstrap/js/bootstrap-dropdown.js",
    "/components/bootstrap/js/bootstrap-alert.js",
    "/components/chosen/chosen/chosen.jquery.min.js",
    "/components/jquery.tablesorter/js/jquery.tablesorter.min.js",
    "/components/sdis62-ui/js/main.js"
], function() {

    // =======================================================================
    // Comportements pour le formulaire utilisateur
    // =======================================================================

    $("form.form-user select[id=type]").change(function() {
        if($(this).val() == 1) {
            $("form.form-user fieldset[id=fieldset-db]").hide();
            $("form.form-user fieldset[id=fieldset-ldap]").show();
        }
        else {
            $("form.form-user fieldset[id=fieldset-ldap]").hide();
            $("form.form-user fieldset[id=fieldset-db]").show();
        }
    }).change();

    $("form.form-user select[id=typeprofile]").change(function() {
        if($(this).val() == 1) {
            $("form.form-user div.db_elu").hide();
            $("form.form-user div.db_pompier").hide();
        }
        else if($(this).val() == 2){
            $("form.form-user div.db_elu").hide();
            $("form.form-user div.db_pompier").show();
        }
        else {
            $("form.form-user div.db_elu").show();
            $("form.form-user div.db_pompier").hide();
        }
    }).change();

    $("form.form-user select[id=db_elu-typeprofileelu]").change(function() {
        if($(this).val() == 0) {
            $("form.form-user div.db_elu_maire").show();
            $("form.form-user div.db_elu_prefet").hide();
        }
        else {
            $("form.form-user div.db_elu_maire").hide();
            $("form.form-user div.db_elu_prefet").show();
        }
    }).change();

});
 
// on charge le module commun
require(['common']);