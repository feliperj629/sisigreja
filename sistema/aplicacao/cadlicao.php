<?php @session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');
require("../include/seguranca.php");
?>
<html>
<head>
<?php
   
   $FORM_NAME = 'Licao';
   $FORM_ACTION = 'exec.licao.php';
   $FORM_BACK = 'conslicao.php';

	$retorno = $_REQUEST['retorno'];
	if ($retorno == 'INS_OK')
	{
		$MENSAGEM_RETORNO = $FORM_NAME.' adicionado com sucesso!';
		$MENSAGEM_COLOR = 'success';
	}
	if ($retorno == 'ALT_OK')
	{
		$MENSAGEM_RETORNO = $FORM_NAME.' alterado com sucesso!';
		$MENSAGEM_COLOR = 'success';
	}
	if ($retorno == 'DEL_OK')
	{
		$MENSAGEM_RETORNO = $FORM_NAME.' exclu&iacute;do com sucesso!';
		$MENSAGEM_COLOR = 'success';
	}
	if ($retorno == 'INS_ERRO')
	{
		$MENSAGEM_RETORNO = 'Não foi possível adicionar o '.$FORM_NAME.'!';
		$MENSAGEM_COLOR = 'warning';
	}
	if ($retorno == 'ALT_ERRO')
	{
		$MENSAGEM_RETORNO = 'Não foi possível alterar o '.$FORM_NAME.'!';
		$MENSAGEM_COLOR = 'warning';
	}
	if ($retorno == 'DEL_ERRO')
	{
		$MENSAGEM_RETORNO = 'Não foi possível excluir o '.$FORM_NAME.'!';
		$MENSAGEM_COLOR = 'warning';
	}



	require_once('../classes/banco.class.php');
	require_once('../classes/licao.class.php');
		
   $clConexao = new Conexao;
   $conn = $clConexao->conecta();
   
   $Classe= new Licao();
   $Classe->conn = $conn;

   $op=$_REQUEST['op'];
   $id=$_REQUEST['id'];
   if ( ($op=='A') && (!empty($id)) )
   {
   	   $Classe->getById($id);
				$idlicao = $Classe->idlicao;
			    $licao = $Classe->licao;
			   
			   
  }
?>

   	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">

	<title>Chama Viva </title>

<link href="../css/bootstrap.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="../css/sb-admin.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="../css/plugins/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../font-awesome-4.1.0/css/font-awesome.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
<div id="myModal" class="modal fade">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <!-- dialog body -->
      <div class="modal-body"> 
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        Excluir todos os registros? </div>
      <!-- dialog buttons -->
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger" onClick="excluir()">Excluir</button>
      </div>
    </div>
  </div>
</div>
    <div id="page-wrapper">
		<?php include "topo.php";?>

       <div id="page-wrapper">
            <div class="row">
                
      <div class="col-lg-12"> 
        <h1 class="page-header"> 
          <?php echo $FORM_NAME;?>
        </h1>
        <?php if ($retorno!='')	{ ?>
        <div id="alertdiv" class="alert alert-<?php echo $MENSAGEM_COLOR;?>"><span class="glyphicon glyphicon-exclamation-sign"></span> 
          <?php echo $MENSAGEM_RETORNO;?>
        </div>
        <? } ?>
        <div id="alert_placeholder"> </div>
      </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                
      <div class="col-lg-12"> 
        <!-- /.panel-heading -->
        <div class="row"> 
          <div class="col-lg-12"> 
            <div class="panel panel-default"> 
              <div class="panel-heading"> 
                <button type="button" class="btn btn-default"  onClick="salvarFechar()"> 
                <span class="glyphicon glyphicon-floppy-disk"></span> Salvar</button>
               
                <div class="btn-group"> 
                  <button type="button" class="btn btn-default" onClick="voltar();"> 
                  <span class="glyphicon glyphicon-chevron-left"></span> Voltar</button>
                </div>
              </div>
              <div class="panel-body"> 
                <div class="row"> 
                  <div class="col-lg-6"> 
                    <form role="form" name="frm" id="frm" action="<?php echo $FORM_ACTION;?>">
                      <input type="hidden" name="op" id="op" value="<?php echo $op;?>">
                      <input type="hidden" name="fechar" id="fechar" value="s">
                      <input type="hidden" name="edtidlicao" id="edtidlicao" value="<?php echo $idlicao;?>">
                      <div class="control-group"> 
                        <div class="form-group"> 
                          <label class="control-label" for="edtnomelicao">licao</label>
                          <input class="form-control" name="edtnomelicao" id="edtnomelicao" value="<?php  echo $licao;?>">
                        </div>
						
					
                      </div>
                    </form>
                  </div>
                  <!-- /.col-lg-6 (nested) -->
                  <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
              </div>
              <!-- /.panel-body -->
              <div class="panel-footer"> 
                <button type="button" class="btn btn-default" onClick="salvarFechar()"> 
                <span class="glyphicon glyphicon-floppy-disk"></span> Salvar</button>
                <button type="reset" class="btn btn-default"> <span class="glyphicon glyphicon-ban-circle"></span> 
                Cancelar</button>
              </div>
            </div>
            <!-- /.panel -->
          </div>
          <!-- /.col-lg-12 -->
        </div>
        <!-- /.table-responsive -->
      </div>
          <!-- /.panel -->
        <!-- /.col-lg-12 -->
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->

    </div>
	</div>

    <!-- /#wrapper -->
<!-- jQuery Version 1.11.0 --> 
<script src="../js/jquery-1.11.0.js"></script> 

<!-- Bootstrap Core JavaScript --> 
<script src="../js/bootstrap.min.js"></script> 

    <!-- Core Scripts - Include with every page -->
	<script type="text/javascript" charset="utf-8">

/**
  Bootstrap Alerts -
  Function Name - showalert()
  Inputs - message,alerttype
  Example - showalert("Invalid Login","alert-error")
  Types of alerts -- "alert-error","alert-success","alert-info"
  Required - You only need to add a alert_placeholder div in your html page wherever you want to display these alerts "<div id="alert_placeholder"></div>"
  Written On - 14-Jun-2013
**/

  function showalert(message,alerttype) {
    $('#alert_placeholder').append('<div id="alertdiv" class="alert ' +  alerttype + '"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>');
    setTimeout(function() {
		 // this will automatically close the alert and remove this if the users doesnt close it in 5 secs
      $("#alertdiv").remove();
	  }, 3000);
  }


	function validaForm()
	{
	   r = true;
	   m = '';
	   if ((document.getElementById('edtnomelicao').value == '') )
	   { 
	      r = false;
		  m = 'Verifique o preenchimento dos campos. \r\n';
	   }

	   if (r == false){
	   	   alert(m);
		   return false;
	   }
	   else
	   {
	      return true;
	   }
	}


	function salvarFechar()
	{
	   if (validaForm()==true){
    		  //$('#myModal').modal('hide');
				document.getElementById('frm').action='<?php echo $FORM_ACTION;?>';
				document.getElementById('frm').submit();
	   }
	}




			function showExcluir()
			{
				$('#myModal').modal({
  					keyboard: true
				})
			}
			function excluir()
			{
				$('#myModal').modal('hide');
				//showalert("Deleted","alert-error");
			  	//$('#myModal').modal();
			}
			
			function voltar()
			{
				window.location.href = '<?php echo $FORM_BACK;?>';
			}		
			
			
			$(document).ready(function() {
			
				/* Init DataTables */
				/*$('#example').dataTable();*/
				
				setTimeout(function() {
		 // this will automatically close the alert and remove this if the users doesnt close it in 5 secs
      				$("#alertdiv").remove();
	  			}, 5000);
				
				$('#example').dataTable( {
					"bFilter": true,
        			"sPaginationType": "full_numbers"
    			} );
				
				/* Add events */
				$('#example tbody tr').live('dblclick', function () {
					/*var sTitle;
					var nTds = $('td', this);
					var sBrowser = $(nTds[1]).text();
					var sGrade = $(nTds[4]).text();
					if ( sGrade == "A" )
						sTitle =  sBrowser+' will provide a first class (A) level of CSS support.';
					else if ( sGrade == "C" )
						sTitle = sBrowser+' will provide a core (C) level of CSS support.';
					else if ( sGrade == "X" )
						sTitle = sBrowser+' does not provide CSS support or has a broken implementation. Block CSS.';
					else
						sTitle = sBrowser+' will provide an undefined level of CSS support.';
					alert( $(nTds[0]).text());
					alert( sTitle )
					*/
				} );
			} );
		
		</script>
</body>

</html>
