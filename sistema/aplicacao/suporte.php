<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Chama Viva Maps</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<link rel="stylesheet" type="text/css" href="../../contato/font-awesome/css/font-awesome.min.css" />
		
		<script type="text/javascript" src="../../contato/js/jquery-1.10.2.min.js"></script>
		
        <script type="text/javascript" src="../../contato/bootstrap/js/bootstrap.min.js"></script>
		
		
		
    <!--       <link rel="stylesheet" type="text/css" href="contato/bootstrap/css/bootstrap.min.css" />
        <!-- CSS do validador -->
        <link href="../../formulario-envia/css/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
        <link href="../../formulario-envia/css/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
        <link href="../../formulario-envia/css/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
		<script language="JavaScript" type="text/javascript" src="js/MascaraValidacao.js"></script>
        <!-- Css do formulario -->
        <link rel="stylesheet" href="../../css/estilo.css" type="text/css" />


    </head>
    <body>
     <div class="page-header">
		 <div class="intro-header">
		 <?php
			//	require 'topo.php';
			?>
        <div class="container">
          
            
                <h1>Suporte técnico <small>envie sua dúvida e nós entraremos em contato.</small></h1>
            </div>

            <!-- Contact with Map - START -->
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="well well-sm">
                            <form class="form-horizontal" method="post" action="envia.php" name="form1">
                                <fieldset>
                                    <legend class="text-center header">Contato</legend>

                                    <div class="form-group">
                                        <div class="col-md-10 col-md-offset-1">
                                            <input id="nomeremetente" name="nomeremetente" type="text" placeholder="Nome" class="form-control" required="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-10 col-md-offset-1">
                                            <input id="assunto" name="assunto" type="text" placeholder="Assunto" class="form-control" required="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-10 col-md-offset-1">
                                            <input id="emailremetente" name="emailremetente" type="text" placeholder="Endereço de Email" class="form-control" >
                                        </div>
                                    </div>

                                
                                    <div class="form-group">
                                        <div class="col-md-10 col-md-offset-1">
                                            <input id="telefone" name="telefone" type="text" placeholder="Telefone" class="form-control" onKeyPress="MascaraTelefone(form1.telefone);" maxlength="14"  onBlur="ValidaTelefone(form1.telefone);" required="">
                                        </div>
                                    </div>
									


                                    <div class="form-group">
                                        <div class="col-md-10 col-md-offset-1">
                                            <textarea class="form-control" id="mensagem" name="mensagem" placeholder="Digite sua menssagem aqui. Nós entraremos em contato com você dentro de 2 dias úteis." rows="7" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12 text-center">
                                            <input name="limpar" type="reset" value="Limpar" class="btn btn-danger btn-lg"  />
                                            <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
					<!--
                    <div class="col-md-6">
                        <div>
                            <div class="panel panel-default">
                                <div class="text-center header">Nossa Igreja</div>
                                <div class="panel-body text-center">
                                    <h4>Endereço</h4>
                                    <div>
                                        R. Babi nº 30 - Recantus (Antigo Babi)<br />
                                        Belford Roxo - RJ - CEP: 26163-190<br />
                                        contato@chamaviva.net.br<br />
                                    </div>
                                    <hr />
                                    <div id="map1" class="map">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					-->
                </div>
            </div>
 </div>

            <script src="http://maps.google.com/maps/api/js?sensor=false"></script>

            <script type="text/javascript">
                jQuery(function ($) {
                    function init_map1() {
                        var myLocation = new google.maps.LatLng(-22.716186, -43.388106);
                        var mapOptions = {
                            center: myLocation,
                            zoom: 16
                        };
                        var marker = new google.maps.Marker({
                            position: myLocation,
                            title: "Property Location"
                        });
                        var map = new google.maps.Map(document.getElementById("map1"),
                                mapOptions);
                        marker.setMap(map);
                    }
                    init_map1();
                });
            </script>

            <style>
                .map {
                    min-width: 300px;
                    min-height: 300px;
                    width: 100%;
                    height: 100%;
                }

                .header {
                    background-color: #F5F5F5;
                    color: #36A0FF;
                    height: 70px;
                    font-size: 27px;
                    padding: 10px;
                }
            </style>


            <script type="text/javascript" src="../../formulario-envia/js/SpryValidationTextField.js" language="javascript" ></script>
            <script type="text/javascript" src="../../formulario-envia/js/SpryValidationTextarea.js" language="javascript" ></script>
            <script type="text/javascript" src="../../formulario-envia/js/SpryValidationSelect.js" language="javascript" ></script>    


            <script type="text/javascript">

                var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
                var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email");
                var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {minChars: 2, maxChars: 2});
                var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
                var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
                var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");

            </script>
			
			
			<script>
		mascaraTelefone( form1.telefone );
		</script>
		
		<!-- rodapé -->
     <?php
      //  require 'rodape.php';
    ?>

            <!-- Contact with Map - END -->

        </div>



    </body>
</html>