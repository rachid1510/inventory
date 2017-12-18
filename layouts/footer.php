    </div>
    </div>

    <footer class="footer">

            <span class="text-muted">© 2017 Opentech inventory systéme. Tous droits réservés</span>

    </footer>

    <script
            src="https://code.jquery.com/jquery-3.2.1.js"
            integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
            crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo $url;?>/dist/js/chosen.jquery.min.js"></script>
<!--    <script src="https://cdn.jsdelivr.net/semantic-ui/2.2.13/semantic.min.js"></script>-->
    <script>
    $(document).ready(function() {
        $(".chosen-select").chosen({width: "95%"});
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


        $('#submitfrm').click(function() {
            var $this = $(this);
            var frmaction=$this.attr("title");
            var form = $('#'+$this.parent().parent().parent().attr("id"));
            var data=new FormData(form[0]);//form.serialize();//new FormData(form) ;//

             $.ajax( {
                 type: "POST",
                 url: frmaction,
                 data: data ? data : form.serialize(),
                 cache       : false,
                 processData : false,
                 contentType:false,
                 beforeSend: function() {

                    $this.button('loading');
                    },

                complete: function() {
                    $this.button('reset');
                    },
                success: function(resultat ) {

                    if(resultat.msg === 'OK') {
                        $(".alert.alert-success").show(0).delay(3000).hide(0);
                        //setTimeout($(".alert.alert-success").show(),3000);
                        $this.button('reset');
                    }else
                    {
                        $(".alert .alert-danger").show();
                    }
                }
            } );
        } );



        /*
         * set default value to all datetimepicker control
         */
        $('.datePicker').val(new Date().toDateInputValue());
         /*
          * search in select option input text change
          */
        $('.search_input').change(function(){
            var text_selected = $(this).val();
            var hidden_element=$(this).attr("title");
            var id_dropdown=$(this).parent(".col-md-6").children(".data_list").children(0).attr('id');
           $("#"+id_dropdown+"> option").each(function()
            {
                if($(this).text() == text_selected)
                {

                    $('#'+hidden_element).val($(this).attr("data-value"));
                    if(id_dropdown=='imei_boitier'){
                       $('#typebox').text('');
                       $('#typebox').text('Type:'+$(this).attr("title"))

                    }
                    if(id_dropdown=='imei_gsm'){
                        $('#typecard').text('');
                        $('#typecard').text('Type:'+$(this).attr("title"))
                    }
                }
            });

            });


    });
    Date.prototype.toDateInputValue = (function() {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0,10);
    });


</script>

  </body>
  </html>