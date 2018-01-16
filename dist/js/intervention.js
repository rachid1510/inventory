$(document).ready(function() {
    $("#export_intervention").click(function () {
        $('#modalinterventionexporter').modal();
    });

    $( "#personalproduct").focusout(function() {

       var id_select =$('#instalateur').find(":selected").val();
        if(id_select==0)
        {
            alert("Veuillez sélectionner un installateur");
            return false;
        }
        $.ajax({
            type: "POST",
            url: url+'/personal/getbox',
            data:{id:id_select},
            dataType:'json',
            success: function(resultat ) {
                console.log(resultat);
             if(resultat.length< $("#personalproduct").val())
             {
                 alert("Attention le nombre d'exportation est supèrieur au stock personnel");
                 $("#personalproduct").val('');
                 $( "#personalproduct" ).focus();
             }

            }
        });
    });


        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

});
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
                $('#type').val(resultat[0].type);
                $('#marque').val(resultat[0].marque);
                $('#matricule').val(resultat[0].matricule);
                $('#kilometrage').val(resultat[0].kilometrage);
                $('#remarque').val(resultat[0].remarque)


                $('#myModal').modal();
            }
        }
    })


}

function load_notification_intervention(id)

{

    $.ajax({

        url:url+"/product/interventioninprogress",
        method:"POST",
        dataType:"json",
        success:function(data)

        {
            if(data.notification >0){
                $('.profile>a').css("color","red");
                $('#'+id).show();
                $('#'+id+'>span').html(data.notification);
            }


            // if(data.unseen_notification > 0)
            // {
            //     $('.count').html(data.unseen_notification);
            // }

        }

    });

}
function checked_responsable(id) {
    var isGood=confirm('Êtes vous sûr de vouloir valider la fiche d\'intervention');
    if (!isGood) {
        return false;
    }
    $.ajax( {
        type: "POST",
        url: url+'/intervention/validationresponsable',
        data:{id:id},
        dataType:'json',
        success: function(resultat ) {
            $('#liste').load(window.location.href + ' #liste');




        }
    });
}
load_notification_intervention('intervention_alert')