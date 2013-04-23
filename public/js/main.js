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

// =======================================================================
// Activation de tablesorter pour les table contenant la classe .tablesorter
// =======================================================================

$("table.tablesorter").tablesorter({theme: 'bootstrap2'});

// =======================================================================
// Activation de chosen pour les select contenant la classe .chosen
// =======================================================================

$("select.chosen").chosen();