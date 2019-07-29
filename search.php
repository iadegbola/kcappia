<?php 
include('./classes/header1.php');
?>
<body>
<h2>You can search for anyone, anything and anywhere!</h2><br /><br /><br /><br />

                        <div class="collapse navbar-collapse" id="navcol-1">
                    <form class="navbar-form navbar-left">
                        <div class="searchbox"><i class="glyphicon glyphicon-search"></i>
                            <input class="form-control sbox" type="text" placeholder="search">
                            <ul class="list-group autocomplete" style="position:absolute;width:100%; z-index:100">
                            </ul>
                        </div>
                    </form>
                    </div>
                    <h2><u>Popular Users</u></h2>
                    <a href="./ibukun"><h2>Ibukun</h2></a>
                    <a href="./oga"><h2>Oga</h2></a>
                    <a href="./Kcappia"><h2>Kcappia</h2></a>
                    <a href="./basheer"><h2>Basheer</h2></a>
                    <a href="./maratima"><h2>Maratima</h2></a>

                    
                 <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-animation.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
    <script type="text/javascript">

                      $(document).ready(function() {

                                    $('.sbox').keyup(function() {
                        $('.autocomplete').html("")
                        $.ajax({

                                type: "GET",
                                url: "api/search?query=" + $(this).val(),
                                processData: false,
                                contentType: "application/json",
                                data: '',
                                success: function(r) {
                                        r = JSON.parse(r)
                                        for (var i = 0; i < r.length; i++) {
                                               if (console.log(r[i].body)) {
                                                $('.autocomplete').html(
                                                        $('.autocomplete').html() +
                                                        '<a href="./'+r[i].username+'#'+r[i].id+'"><li class="list-group-item"><span>'+r[i].body+'</span></li></a>'
                                                )
                                            } else {
                                                $('.autocomplete').html(
                                                        $('.autocomplete').html() +
                                                        '<a href="./'+r[i].username+'"><li class="list-group-item"><span>'+r[i].username+'</span></li></a>'
                                                )

                                            }
                                        }
                                },
                                error: function(r) {
                                        console.log(r)
                                }
                            })
                    })
                                })
                    </script>
             		 </body>
</html>
