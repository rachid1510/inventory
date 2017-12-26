

function update_costumer(id_select)
{

    $('#costumer_form_submit').attr('title','costumer/update');
    $('#id_costumer').val(id_select);//attr('title','installation/update');

    $('#myModalLabel').html('Modifier le client');
    $.ajax( {
        type: "POST",
        url: url+'/costumer/edit',
        data:{id:id_select},
        dataType:'json',
        success: function(resultat ) {
            console.log(resultat);
            if (resultat.length > 0) {
                $('#costumer_name').val(resultat[0].name);
                $('#costumer_phone').val(resultat[0].phone);
                $('#costumer_city').val(resultat[0].city);
                $('#costumer_departement').val(resultat[0].departement);
                $('#costumer_adress').val(resultat[0].adress);


                $('#myModal').modal();
            }
        }
    });



}

