    </div>
    </div>

    <footer class="footer">
        <div class="container">
            <span class="text-muted">© 2017 Opentech inventory systéme. Tous droits réservés</span>
        </div>
    </footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function() {
        $('.submenu-toggle').click(function () {
            $(this).parent().children('ul.submenu').toggle(200);
        });
        $('#showmodal').click(function() {
            $('#myModal').modal();
        });

        $('#submitfrm').click(function() {
            var $this = $(this);

            var form = $('#'+$this.parent().parent().parent().attr("id"));
            var data=form.serialize();
             $.ajax( {
                type: "POST",
                url: form.attr( 'action' ),
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $this.button('loading');
                    },
                complete: function() {
                    $this.button('reset');
                    },
                success: function(resultat ) {
                    alert(resultat);
                    if(resultat['msg'] =='OK') {
                        $('#mymodal').modal('toggle');
                        $(".alert.alert-success").show();
                        window.setTimeout(function(){ window.location.href = window.location.origin + "/movement"; }, 3000);

                    }
                    else
                    {
                        $(".alert .alert-danger").show();
                    }
                }
            } );

        });


    });
</script>

  </body>
  </html>