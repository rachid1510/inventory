

function update_movement(id_select)
{

    $('#id_movement_form_submit').attr('title','movement/update');
    $('#id_movement').val(id_select);//attr('title','installation/update');
    $('.import_file').css("display",'none');
    $('#myModalLabel').html('Modifier le mouvement');
    $.ajax( {
        type: "POST",
        url: url+'/movement/edit',
        data:{id:id_select},
        dataType:'json',
        success: function(resultat ) {
            console.log(resultat);
            if (resultat.length > 0) {


                $("select#category option").each(function()
                {
                    if($(this).val()==resultat[0].category_id)
                    {
                        $(this).prop('selected', true);
                    }
                });

                $('#order_id').val(resultat[0].order_ref);
                $('#provider').val(resultat[0].provider);
                $('#plan').val(resultat[0].plan);
                $('#quantite').val(resultat[0].quantity);
                $('#date_arrived').val(resultat[0].date_arrived);
               // $('select#category').trigger('chosen:updated');



                $('#myModal').modal();
            }
        }
    });



}

