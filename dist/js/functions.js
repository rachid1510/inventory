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
        // alert(frmaction);
        // console.log(data);
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

                if(resultat.msg == 'OK') {
                    $(".alert.alert-success").show(0).delay(3000).hide(0);
                    $('#liste').load(window.location.href + ' #liste');

                   // alert(form);
                    //$('#'+form).reset();
                    //form[0].reset();

                    //setTimeout($(".alert.alert-success").show(),3000);

                }else
                {
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

    $(".chosen-select").chosen({width: "95%",search_contains: true});

    $('#selected_box').change(function(){

        $('#typebox').text('');
        $('#typebox').text('Type:'+$('option:selected', this).attr('title'))
    });

    $('#selected_card').change(function(){

        $('#typecard').text('');
        $('#typecard').text('Type:'+$('option:selected', this).attr('title'))
    });
});
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
function update_function(id_select)
{

    $.ajax( {
        type: "POST",
        url: 'edit',
        data:{id:id_select},
        success: function(resultat ) {
            console.log(resultat);
            // if(resultat.length>0){
            $('#order_id').val(resultat.order_ref);
            $('#plan').val(resultat.plan);
            //}
            $('#myModal').modal();
        }
    } );



}