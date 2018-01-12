

function update_user(id_select)
{

    $('#user_form_submit').attr('title','user/update');
    $('#id_user').val(id_select);//attr('title','installation/update');

    $('#myModalLabel').html('Modifier l\'utilisateur');
    $.ajax( {
        type: "POST",
        url: url+'/user/edit',
        data:{id:id_select},
        dataType:'json',
        success: function(resultat ) {

            if (resultat.length > 0) {
                $('#user_name').val(resultat[0].name);
                $('#user_mail').val(resultat[0].email);
                $("#user_role option[value='"+resultat[0].fonction+"']").prop('selected', true);

                // $('#costumer_mail').val(resultat[0].mail);
                // $('#costumer_city').val(resultat[0].city);
                // $('#costumer_departement').val(resultat[0].departement);
                // $('#costumer_adress').val(resultat[0].adress);


                $('#myModal').modal();
            }
        }
    });



}

function disableduser(id) {
    var isGood=confirm('Êtes vous sûr de vouloir désactiver le compte');
    if (!isGood) {
        return false;
    }
    $.ajax( {
        type: "POST",
        url: url+'/user/disabled',
        data:{id:id},
        dataType:'json',
        success: function(resultat ) {
            $('#liste').load(window.location.href + ' #liste');
            // if(resultat.msg=='OK')
            // {
            //     alert("Le compte a été désactivé");
            // }


        }
    });
}

function enableduser(id) {
    var isGood=confirm('Êtes vous sûr de vouloir activer le compte');
    if (!isGood) {
        return false;
    }
    $.ajax( {
        type: "POST",
        url: url+'/user/enabled',
        data:{id:id},
        dataType:'json',
        success: function(resultat ) {
            $('#liste').load(window.location.href + ' #liste');
            // if(resultat.msg=='OK')
            // {
            //     alert("Le compte a été activé");
            // }


        }
    });

}