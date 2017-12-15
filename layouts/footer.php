    </div>
    </div>

    <footer class="footer">
        <div class="container">
            <span class="text-muted">© 2017 Opentech inventory systéme. Tous droits réservés</span>
        </div>
    </footer>

    <script
            src="https://code.jquery.com/jquery-3.2.1.js"
            integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
            crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<!--    <script src="https://cdn.jsdelivr.net/semantic-ui/2.2.13/semantic.min.js"></script>-->
    <script>
    $(document).ready(function() {
        $('#gps_client_check').change(function(){

            if(this.checked){

                $('#autoUpdate1').fadeIn('slow');
                $('#sim_client_check').hide();
            }

            else{
                $('#autoUpdate1').fadeOut('slow');
                $('#sim_client_check').show();
            }


        });
        $('#sim_client_check').change(function(){
            if(this.checked) {
                $('#autoUpdate2').fadeIn('slow');
                $('#gps_client_check').hide();
            }
            else{
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

             alert(data);
             $.ajax( {
                 type: "POST",
                 url: frmaction,
                 data: data ? data : form.serialize(),
                 cache       : false,
                 contentType : false,
                 processData : false,
                 beforeSend: function() {

                    $this.button('loading');
                    },
                complete: function() {

                    $this.button('reset');
                    },
                success: function(resultat ) {
                    if(resultat['msg'] =='OK') {
                       // $('#mymodal').modal('toggle');
                        $(".alert.alert-success").show();
                       // window.setTimeout(function(){ window.location.href = window.location.origin + "/inventory/movement"; }, 3000);

                    }
                    else
                    {
                        $(".alert .alert-danger").show();
                    }
                }
            } );

        });

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