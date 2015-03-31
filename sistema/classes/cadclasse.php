<?php @session_start();
require("../include/seguranca.php");
?>
<html>
<head>
<?php
   $FORM_NAME = 'Classe';
   $FORM_ACTION = 'exec.classe.php';
   $FORM_BACK = 'consclasse.php';

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
	require_once('../classes/classe.class.php');
		
   $clConexao = new Conexao;
   $conn = $clConexao->conecta();
   
   $Classe= new Classe();
   $Classe->conn = $conn;

   $op=$_REQUEST['op'];
   $id=$_REQUEST['id'];
   if ( ($op=='A') && (!empty($id)) )
   {
   	   $Classe->getById($id);
				$idclasse = $Classe->idclasse;
			    $classe = $Classe->classe;
			    $siglaclasse = $Classe->siglaclasse;
			    $ordem = $Classe->ordem;
			    $proximoclasse = $Classe->proximoclasse;
			    $ativo = $Classe->ativo;
				$descricao = $Classe->descricao;
	   
	   
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
                <button type="button" class="btn btn-default"  onClick="salvarFechar('')"> 
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
                      <input type="hidden" name="fechar" id="fechar" value="">
                      <input type="hidden" name="edtidclasse" id="edtidclasse" value="<?php echo $idclasse;?>">
                      <div class="control-group"> 
                        <div class="form-group"> 
                          <label class="control-label" for="edtnomeclasse">Nome Classe</label>
                          <input class="form-control" name="edtnomeclasse" id="edtnomeclasse" required minlength="150" value="<?php echo $classe;?>">
                        </div>
						<div class="form-group"> 
                          <label class="control-label" for="edtsiglaclasse">Sigla classe</label>
                          <input class="form-control" name="edtsiglaclasse" id="edtsiglaclasse" required minlength="150" value="<?php echo $siglaclasse;?>">
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
                <button type="button" class="btn btn-default" onClick="salvarFechar('')"> 
                <span class="glyphicon glyphicon-floppy-disk"></span> Salvar</button>
                <?php if ($op=='I'){?>
                <button type="button" class="btn btn-default" onClick="salvarFechar('s')"> 
                <span class="glyphicon glyphicon-floppy-disk"></span> Salvar e 
                Sair</button>
                <?php } ?>
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
	   if ((document.getElementById('edtnomeclasse').value == '') )
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


	function salvarFechar(fechar)
	{
	   if (validaForm()==true){
    	   $('#myModal').modal('hide');
				document.getElementById('fechar').value=fechar;
				//document.getElementById('frm').action='<?php echo $FORM_ACTION;?>';
				document.getElementById('form').submit();
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
  <!-- Bootstrap Core JavaScript --> 
<script src="../js/bootstrap.min.js"></script> 

<!-- Morris Charts JavaScript --> 
<script src="../js/plugins/morris/raphael.min.js"></script> 
<script src="../js/plugins/morris/morris.min.js"></script> 
<script src="../js/plugins/morris/morris-data.js"></script>
    

    

</body>

</html>
