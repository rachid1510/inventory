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

    $('.submitfrm').click(function() {
        var $this = $(this);
        var frmaction=$this.attr("title");

        var form = $("#"+$this.attr("alt"));// $('#'+$this.parent().parent().parent().attr("id"));
        var data=new FormData(form[0]);
        var frm=$('#'+form.attr('id'));



        $.ajax( {
            type: "POST",
            url: frmaction,
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
                    $(".alert.alert-success").show(0).delay(3000).hide(0);
                    $('#liste').load(window.location.href + ' #liste');
                }else
                {
                    $(".alert.alert-danger").html(resultat.msg);
                    $(".alert.alert-danger").show(0).delay(3000).hide(0);
                    //$(".alert .alert-danger").show();
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
        $('#selected_card').empty();
        $('#selected_box').trigger('chosen:updated');
        $('#selected_card').trigger('chosen:updated');

        filter_drop('selected_box', 'personal/getbox','id', 'imei_product', $(this).val(),'model');
        filter_drop('selected_card', 'personal/getsim','id', 'label', $(this).val(),'model');
    });
});
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
function filter_drop(select_to_update,action,v,txt,selected_value,title){
    console.log(action)
    $.ajax( {
        type: "POST",
        url: action,
        dataType:'json',
        data:{id:selected_value},
        success: function(resultat ) {
   console.log(resultat);
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

    $.ajax( {
        type: "POST",
        url: 'installation/edit',
        data:{id:id_select},
        success: function(resultat ) {
            console.log(resultat);
            if(resultat.length>0){
            $('select#personal_id').val(resultat[0].personal_id).trigger("change");
            $('#personal_id').trigger('chosen:updated');
            $('#date_installation').val(resultat[0].installed_at);
            $('select#selected_costmer').val(resultat[0].co).trigger("change");
            $('#personal_id').trigger('chosen:updated');
            //$('#plan').val(resultat.plan);
            }
            $('#myModal').modal();
        }
    } );



}