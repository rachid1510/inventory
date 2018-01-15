$(document).ready(function() {
   /* $('#myModal').on('hidden.bs.modal', function () {
        location.reload();
    })*/
    var list_sim_checked=[];
    $('#gps_client_check').change(function(){

        if(this.checked){
            //  $("#textrecherche).prop( "disabled", true );
            $('#search1').prop('readonly', true);
            $('#autoUpdate1').fadeIn('slow');
            $('#autoUpdate2').fadeOut('slow');
            $('#sim_client_check').hide();
            $("#selected_box option:first").attr('selected','selected');
            $('#selected_box').trigger('chosen:updated');
            $("#selected_box").val('');
            $("#gsm_product_costumer").val('');


        }

        else{
            $('#search1').prop('readonly', false);
            $('#autoUpdate1').fadeOut('slow');
            $('#sim_client_check').show();
            $("#imei_product_costumer").val('');


        }


    });
    $('#sim_client_check').change(function(){
        if(this.checked) {
            $('#search2').prop('readonly', true);
            $('#autoUpdate2').fadeIn('slow');
            $('#autoUpdate1').fadeOut('slow');
            $("#imei_product_costumer").val('');
            $('#gps_client_check').hide();
            $("#selected_card option:first").attr('selected','selected');
            $('#selected_card').trigger('chosen:updated');
            $("#selected_card").val('');
        }
        else{
            $('#search2').prop('readonly', false);
            $('#autoUpdate1').fadeIn('slow');
            $('#autoUpdate2').fadeOut('slow');
            $('#gps_client_check').show();
            $("#gsm_product_costumer").val('');
        }

    });
    $('.submenu-toggle').click(function () {
        $(this).parent().children('ul.submenu').toggle(200);
    });
    $('#showmodal').click(function() {
        $('#myModal').modal();
    });

    $('#modalactivation_btn').click(function() {
        $('#modalactivation').modal();
    });

    $('#modalaffactation').click(function() {
        var enstockde =0;
        $('#liste').find('input[type="checkbox"]:checked').each(function () {
            list_sim_checked.push($(this).val());
        });
        if(list_sim_checked.length==0)
        {
            $("#nombreaffecter").show();
            $('#modalaffactation_block').modal();
          //  alert("Merci de cocher les produits à affecter");
        }
        else{
            $("#products").val(list_sim_checked);
            $('#modalaffactation_block').modal();
        }

    });
    /*
     *action transfer product between personals
     */
    $('#modaltransfer').click(function () {
        $('#liste').find('input[type="checkbox"]:checked').each(function () {

            if($(this).attr("alt")!=2){
                alert("L'un des produits selectionnés ne peut pas étre transferer");
                return false;
            }
            else{
                var enstockde=$(this).attr("name");
                list_sim_checked.push($(this).val());
                $('#transferdulabel').text($(this).attr("title"));
                $('#enstockde').val(enstockde);
                $("select#personal_id_stock option").each(function()
                {
                    if($(this).val()==enstockde)
                    {
                        $(this).remove();
                    }
                });
                $('select#personal_id_stock').trigger('chosen:updated');
            }

        });
        if(list_sim_checked.length==0)
        {
            alert("Merci de couche les produits à transferer");
        }
        else{
            $("#products_transfer").val(list_sim_checked);
            $('#modaltransfer_block').modal();
        }
    });
    /*
     * submit form
     */
    $('.submitfrm').click(function() {
        var $this = $(this);
        var frmaction=$this.attr("title");

        var form = $("#"+$this.attr("alt"));// $('#'+$this.parent().parent().parent().attr("id"));
        var data=new FormData(form[0]);
        var frm=$('#'+form.attr('id'));

        $.ajax( {
            type: "POST",
            url:url+'/'+frmaction,
            data: data ? data : form.serialize(),
            cache       : false,
            processData : false,
            contentType:false,
            dataType:"json",

            beforeSend: function() {
                $this.button('loading');
            },
            complete: function() {
                $this.button('reset');
            },
            success: function(resultat ) {
                console.log(resultat);
                 if(resultat.msg == 'OK') {
                     console.log(resultat.content);
                    $(".alert.alert-success").show(0).delay(4000).hide(0);
                    $('#liste').load(window.location.href + ' #liste');
                     if(resultat.content.length>0)
                     {
                         window.open(resultat.content, '_blank');
                     }
                   //  $("#personal_id option:first").attr('selected','selected');
                   //
                   // $('#personal_id').trigger("chosen:updated");
                     //location.reload();
                    //$("#myModal").modal();

                }else
                {
                    $(".alert.alert-danger").html(resultat.msg);
                    $(".alert.alert-danger").show(0).delay(4000).hide(0);

                }
            },
            error:function(e)
            {
                console.log(e);
            }
        } );
    } );

    $('.modal').on('hidden.bs.modal', function(){
        location.reload();
        $(this).find('form')[0].reset();
    });

    /*
     * set default value to all datetimepicker control
     */
    $('.datePicker').val(new Date().toDateInputValue());



    $('#selected_box').change(function(){

        $('#typebox').text('');
        $('#typebox').text('Type:'+$('option:selected', this).attr('title'))
    });

    $('#selected_card').change(function(){

        $('#typecard').text('');
        $('#typecard').text('Type:'+$('option:selected', this).attr('title'))
    });
    $('#personal_id').change(function() {

            $('#selected_box').empty();
            $('#selected_box').trigger('chosen:updated');
            $('#selected_card').empty();
            $('#selected_card').trigger('chosen:updated');
            filter_drop('selected_box', 'personal/getbox','id', 'imei_product', $(this).val(),'model');
            filter_drop('selected_card', 'personal/getsim','id', 'label', $(this).val(),'model');




    });
    $('#selected_costmer').change(function() {
        $('#selected_vehicle').empty();

        $('#selected_vehicle').trigger('chosen:updated');

       filter_drop('selected_vehicle', 'vehicle/getvehiclebycostumer','id', 'imei', $(this).val(),'model');

    });
    $('#displaynewvehicle').change(function() {
        if ($(this).is(':checked')) {
            if($('#selected_costmer').val()==''){
                alert("Merci de sélectionner le client");
                $(this).prop('checked', false);
                return false;
            }else
            {


                $('.newvehicle').fadeIn('slow');
            }

        }
        else
        {

            $('.newvehicle').fadeOut('slow');
        }
    });
    /*
     * submit on search imei product
     */
    $("#imei_searsh").blur(function() {
        $("#filtre").submit();
    });

});
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
function filter_drop(select_to_update,action,v,txt,selected_value,title){
       $.ajax( {
        type: "POST",
        url:url+'/'+ action,
        dataType:'json',
        data:{id:selected_value},
        success: function(resultat ) {

            if(resultat.length>0){
                $('#'+select_to_update).append($('<option></option>').attr('value', '').text('veuillez selectionner'));
                $.each(resultat, function (key, entry) {

                    $('#'+select_to_update).append($('<option></option>').attr({'value': entry[v],'title':entry[title]}).text(entry[txt]));
                });
                $('#'+select_to_update).trigger('chosen:updated');

            }
            else
            {

                $('#'+select_to_update).append($('<option></option>').attr('value', '').text('Aucun Element Trouvé'));
                $('#'+select_to_update).trigger('chosen:updated');

            }
           // $('#myModal').modal();
        }
    } );
}
function update_function(id_select)
{
    $('#date_installation').removeClass('datePicker');
    $('#installation_form_submit').attr('title','installation/update');
    $('#id_installation').val(id_select);//attr('title','installation/update');
    $('.displaynewvehicle').fadeOut('slow');
    $('#myModalLabel').html('ReConfigurer installation');
    $.ajax( {
        type: "POST",
        url: url+'/installation/edit',
        data:{id:id_select},
        dataType:'json',
        success: function(resultat ) {
             if(resultat.length>0){
                $('#date_installation').val(resultat[0].installed_at);

                $("select#personal_id option").each(function()
                {
                     if($(this).val()==resultat[0].personal_id)
                     {
                         $(this).prop('selected', true);
                     }
                });
                // $('select#personal_id').trigger('change');
                $('select#personal_id').trigger('chosen:updated');

                  // filter product by personal selected

                $("select#selected_vehicle option").each(function()
                {
                    if($(this).val()==resultat[0].vehicle_id)
                    {
                        $(this).prop('selected', true);
                    }
                });
                $('select#selected_vehicle').trigger('chosen:updated');
                $("select#selected_costmer option").each(function()
                {
                    if($(this).val()==resultat[0].costumer)
                    {
                        $(this).prop('selected', true);
                    }
                });
                $('select#selected_costmer').trigger('chosen:updated');

               if(resultat.length==2) {
                   $("select#selected_box option").each(function () {
                       if ($(this).val() == resultat[0].id_product || $(this).val() == resultat[1].id_product) {
                           $(this).prop('selected', true);
                       }
                   });
                   $('select#selected_box').trigger('chosen:updated');

                   $("select#selected_card option").each(function () {
                       if ($(this).val() == resultat[0].id_product || $(this).val() == resultat[1].id_product) {
                           $(this).prop('selected', true);
                       }
                   });
                   $('select#selected_card').trigger('chosen:updated');
                  if(resultat[0].category==1)
                  {
                      $("#id_box_old").val(resultat[0].id_product);
                      $("#id_sim_old").val(resultat[1].id_product);
                  }
                  else{
                      $("#id_box_old").val(resultat[1].id_product);
                      $("#id_sim_old").val(resultat[0].id_product);
                  }

               }
               else{

                   if(resultat[0].category==1)
                   {
                       $("select#selected_box option").each(function () {
                           if ($(this).val() == resultat[0].id_product) {
                               $(this).prop('selected', true);
                           }
                       });
                       $('select#selected_box').trigger('chosen:updated');
                       $("#id_box_old").val(resultat[0].id_product);
                   }
                   else
                   {
                       $("select#selected_card option").each(function () {
                           if ($(this).val() == resultat[0].id_product) {
                               $(this).prop('selected', true);
                           }
                       });
                       $('select#selected_card').trigger('chosen:updated');
                      $("#id_sim_old").val(resultat[0].id_product);
                   }
                       //gps_client_check
                   get_costumer_product(resultat[0].installation_id,resultat[0].category);


               }

            // $('select#selected_costmer').val(resultat[0].co).trigger("change");

            }
            $('#myModal').modal();
        }
    } );



}
function get_costumer_product(installation,category){

    $.ajax( {
        type: "POST",
        url: url+'/costumer/getproduct',
        data:{id:installation},
        dataType:'json',
        success: function(resultat) {
            console.log(resultat);
         if(resultat.length>0)
         {
             if(category==1){
                 $("#gsm_product_costumer").val(resultat[0].imei_product);
                 $("#operateur_product_costumer").val(resultat[0].provider);
                 $("#sim_client_check").prop('checked', true);
                 $('#autoUpdate2').fadeIn('slow');
             }else
             {
                 $("#imei_product_costumer").val(resultat[0].imei_product);
                 $("#provider_product_costumer").val(resultat[0].provider);
                 $("#gps_client_check").prop('checked', true);
                 $('#autoUpdate1').fadeIn('slow');
             }


         }
        }
        });
}
