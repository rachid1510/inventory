$(document).ready(function() {
    $("#export_intervention").click(function () {
        $('#modalinterventionexporter').modal();
    });


    $("#personalproduct").focusout(function() {

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

        $("#updateintervention").click(function(){

            var form = $("#interventionupdate")
            var data=new FormData(form[0]);
            //var data=$("#interventionupdate").serialize();

            $.ajax({
                type: "POST",
                url: url+'/intervention/update_intervention',
                data:data ? data : form.serialize(), //{id:id,starthour:starthour,endhour:endhour,duree:duree},
                cache       : false,
                processData : false,
                contentType:false,
                dataType:'json',
                success: function(resultat ) {
                    console.log(resultat);
                    if(resultat.msg == 'OK') {
                        $(".alert.alert-success").show(0).delay(4000).hide(0);


                    }else
                    {
                        console.log(resultat);
                        $(".alert.alert-danger").html(resultat.msg);
                        $(".alert.alert-danger").show(0).delay(8000).hide(0);

                    }
                },
                error:function(e)
                {
                    console.log(e);
                }

            })
        });

});
$("#intervention_update").click(function () {
    $('#modalinterventionupdate').modal();
});
function update_intervention(id) {


    // var type= $("#type"+id).val();
    //
    //
    // var starthour= $("#starthour").val();
    // var endhour= $("#endhour").val();
    // var duree= $("#duree").val();
    var form = $("#interventionupdate")
    var data=new FormData(form[0]);
  //var data=$("#interventionupdate").serialize();
  // console.log(data);
    $.ajax({
        type: "POST",
        url: url+'/intervention/update_intervention',
        data:data ? data : form.serialize(), //{id:id,starthour:starthour,endhour:endhour,duree:duree},
        cache       : false,
        processData : false,
        contentType:false,
        dataType:'json',
        success: function(resultat ) {
            console.log(resultat);
            if(resultat.msg == 'OK') {
                $(".alert.alert-success").show(0).delay(4000).hide(0);


            }else
            {
                console.log(resultat);
                $(".alert.alert-danger").html(resultat.msg);
                $(".alert.alert-danger").show(0).delay(8000).hide(0);

            }
        },
        error:function(e)
        {
            console.log(e);
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

        }

    });

}

load_notification_intervention('intervention_alert')