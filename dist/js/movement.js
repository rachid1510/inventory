$(document).ready(function() {
    $('#category').change(function(){
        var x = document.getElementById("category");
        var cat = x.options[x.selectedIndex].value;var i;

        if(cat==2)
        {
            $('#provider').find('option').remove().end()
                .append('<option value="Orange">Orange</option>\n' +
                    '<option value="Inwi">Inwi</option>\n' +
                    '<option value="Iam">Iam</option>').val('whatever');
            $("#labelplanmodel").text("Plan");
        }
        else
        {
            $('#provider').find('option').remove().end()
                .append('<option value="BCE">BCE</option><option value="Techtonika">Techtonika</option><option value="Dakisoft">Dakisoft</option><option value="Ruptila">Ruptila</option>').val('whatever');
            $("#labelplanmodel").text("Modèl");
        }

        $("#provider option:first").attr('selected','selected');
    });
});

function update_movement(id_select)
{

    $('#id_movement_form_submit').attr('title','movement/update');
    $('#id_movement').val(id_select);//attr('title','installation/update');

    $('#myModalLabel').html('Modifier le mouvement');
    $.ajax( {
        type: "POST",
        url: url+'/movement/edit',
        data:{id:id_select},
        dataType:'json',
        success: function(resultat ) {
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

