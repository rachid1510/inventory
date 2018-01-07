

function update_vehicle(id_select)
{

    $('#update_vehicle_form_submit').attr('title','vehicle/update');
    $('#id_vehicle').val(id_select);//attr('title','installation/update');

    $('#myModalLabel').html('Modifier le vehicule');
    $.ajax( {
        type: "POST",
        url: url+'/vehicle/edit',
        data:{id:id_select},
        dataType:'json',
        success: function(resultat ) {
            console.log(resultat);
            if (resultat.length > 0) {
                $('#vehicle_imei').val(resultat[0].imei);
                $('#vehicle_marque').val(resultat[0].marque);
                $('#vehicle_model').val(resultat[0].model);

                $("select#costumer_id option").each(function()
                {
                    if($(this).val()==resultat[0].costumer_id)
                    {
                        $(this).prop('selected', true);
                    }
                });
                $('select#costumer_id').trigger('chosen:updated');



                $('#myModal').modal();
            }
        }
    });



}

