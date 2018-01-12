

function update_intervention(id_select) {
    $('#intervention_from_submit').attr('title','intervention/update');
    $('#id_intervention').val(id_select);//attr('title','installation/update');

    $('#myModalLabel').html('Modifier l\'interevntion');

    $.ajax({
        type: "POST",
        url: url+'/intervention/edit',
        data:{id:id_select},
        dataType:'json',
        success: function(resultat ) {
            console.log(resultat);
            if (resultat.length > 0) {
                $('#instervened_at').val(resultat[0].instervened_at);
                $('#type' +
                    '').val(resultat[0].type);
                $('#marque').val(resultat[0].marque);
                $('#matricule').val(resultat[0].matricule);
                $('#kilometrage').val(resultat[0].kilometrage);
                $('#remarque').val(resultat[0].remarque)


                $('#myModal').modal();
            }
        }
    })


}