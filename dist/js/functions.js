$(document).ready(function() {
    var list_sim_checked=[];
    $('#gps_client_check').change(function(){

        if(this.checked){
            //  $("#textrecherche).prop( "disabled", true );
            $('#search1').prop('readonly', true);
            $('#autoUpdate1').fadeIn('slow');
            $('#sim_client_check').hide();
        }

        else{
            $('#search1').prop('readonly', false);
            $('#autoUpdate1').fadeOut('slow');
            $('#sim_client_check').show();
        }


    });
    $('#sim_client_check').change(function(){
        if(this.checked) {
            $('#search2').prop('readonly', true);
            $('#autoUpdate2').fadeIn('slow');
            $('#gps_client_check').hide();
        }
        else{
            $('#search2').prop('readonly', false);
            $('#autoUpdate2').fadeOut('slow');
            $('#gps_client_check').show();
        }

    });
    $('.submenu-toggle').click(function () {
        $(this).parent().children('ul.submenu').toggle(200);
    });
    $('#showmodal').click(function() {
        $('#myModal').modal();
    });
    $('#modalaffactation').click(function() {
        var enstockde =0;
        $('#liste').find('input[type="checkbox"]:checked').each(function () {
            list_sim_checked.push($(this).val());
        });
        if(list_sim_checked.length==0)
        {
            alert("Merci de couche les produits à affecter");
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
                list_sim_checked.push($(this).val());
                $('#transferdulabel').text($(this).attr("title"));
                $('#enstockde').val($(this).attr("name"));
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
        console.log(url+'/'+frmaction);
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
                    $(".alert.alert-success").show(0).delay(6000).hide(0);
                    $('#liste').load(window.location.href + ' #liste');
                    //location.reload();
                    //$("#myModal").modal();

                }else
                {
                    $(".alert.alert-danger").show(0).delay(6000).hide(0);

                }
            }
        } );
    } );

    $('.modal').on('hidden.bs.modal', function(){
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
            $('#myModal').modal();
        }
    } );
}
function update_function(id_select)
{
    $('#date_installation').removeClass('datePicker');
    $('#installation_form_submit').attr('title','installation/update');
    $('#id_installation').val(id_select);//attr('title','installation/update');
    $('.displaynewvehicle').fadeOut('slow');
    $('#myModalLabel').html('Modifier installation');
    $.ajax( {
        type: "POST",
        url: url+'/installation/edit',
        data:{id:id_select},
        dataType:'json',
        success: function(resultat ) {
           console.log(resultat);
            if(resultat.length>0){
                $('#date_installation').val(resultat[0].installed_at);

                $("select#personal_id option").each(function()
                {
                     if($(this).val()==resultat[0].personal_id)
                     {
                         $(this).prop('selected', true);
                     }
                });
                $('select#personal_id').trigger('chosen:updated');

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
                   }
                   else
                   {
                       $("select#selected_card option").each(function () {
                           if ($(this).val() == resultat[0].id_product) {
                               $(this).prop('selected', true);
                           }
                       });
                       $('select#selected_card').trigger('chosen:updated');
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
