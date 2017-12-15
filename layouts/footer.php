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


        function add() {
            $('#submitfrm').click(function() {
                var $this = $(this);
                var form = $('#'+$this.parent().parent().parent().attr("id"));
                var data=form.serialize();


                $.ajax( {
                    type: "POST",
                    url: form.attr( 'action' ),
                    data: data,
                    //dataType: 'json',

                    beforeSend: function() {
                        $this.button('loading');
                    },
                    complete: function() {
                        $this.button('reset');
                    },
                    success: function(resultat ) {


                        console.log(resultat);

                        if(resultat['msg'] =='OK') {

                            $(".alert.alert-success").show();
                            window.setTimeout(function(){ window.location.href = window.location.origin + "/inventory/movement"; }, 3000);

                        }
                        else
                        {
                            $(".alert .alert-danger").show();
                        }
                    }
                } );

            });
        }
        $( "#submitfrm" ).on( "click", add );



        $('.datePicker').val(new Date().toDateInputValue());

    });
    Date.prototype.toDateInputValue = (function() {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0,10);
    });
</script>

  </body>
  </html>