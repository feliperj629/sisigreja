<?php 
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');
require("../include/seguranca.php");
require_once('../classes/usuario.class.php');
require_once('../classes/banco.class.php');

   $clConexao = new Conexao;
   $conn = $clConexao->conecta();
   $NOME_TABELA = 'Usuario';  
   
	$I_INSERIDO = 'Inserido com sucesso!';
	$I_ALTERAR = 'Alterado com sucesso!';
	$I_NAO_ALTERAR = 'Nao foi possível alterar!';
	$I_NAO_CADASTRAR = 'Nao foi possível cadastrar!';

   
	$res = $_REQUEST['res'];
   
   
   if($res == NA){
		$html = "<div class='alert alert-warning alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
  <strong>ERRO!</strong>  $I_NAO_ALTERAR </div>";
	}elseif($res == N){
	$html = "<div class='alert alert-warning alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
  <strong>ERRO!</strong>  $I_NAO_CADASTRAR </div>";
	}elseif($res == I){
	$html = "<div class='alert alert-info alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
  <strong>Parabéns!</strong>  $I_INSERIDO </div>";
	}elseif($res == AI){
	$html = "<div class='alert alert-info alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
  <strong>Parabéns!</strong>  $I_ALTERAR </div>";
	}
	
	
	
	
$id_acesso = $_SESSION['id_acesso'];

if(($id_acesso!=1) && ($id_acesso!=2)&& ($id_acesso!=3)){
header('Location: index.php?erro=1');
}
	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">

	<title>Chama Viva - Listar <?php echo $NOME_TABELA;?></title>

<link href="../css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="../css/sb-admin.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="../css/plugins/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../font-awesome-4.1.0/css/font-awesome.css" rel="stylesheet" type="text/css">


</head>

<body>
<!-- Navigation -->

 <?php
	
	//$id_igreja = $_SESSION['id_igreja'];
	
	
	$sql = "SELECT c.*, a.acesso as perfil
FROM usuario c
INNER JOIN acesso a
ON a.idacesso = c.idtipoacesso
ORDER BY 1";
	
	// Executa a query (o recordset $rs contém o resultado da query)
	$rs = pg_query($sql);
	//print_r ($rs);
	
	?>

<div id="page-wrapper">
    <?php require("topo.php");?>
<!-- MENSAGEM DE RESPOSTA AO GRAVAR-->	
	<?php echo $html;?>
	
	<div id="myModal" class="modal fade">		
	  <div class="modal-dialog"> 
		<div class="modal-content"> 
		  <!-- dialog body -->
		  <div class="modal-body"> 
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			Excluir o(s) registro(s)? </div>
		  <!-- dialog buttons -->
		  <div class="modal-footer"> 
			<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			<button type="button" class="btn btn-danger" onClick="excluir()">Excluir</button>
		  </div>
		</div>
	  </div>	  
	</div>
	
	
	<!-- Modal Usuario -->
	<div class="modal fade bs-example-modal-lg" id="myModalusuario" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<?php// require_once('cadusuario.php');?>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<!--<button type="button" class="btn btn-primary">Save changes</button> -->
				</div>
			</div>	
		</div>
	</div>
	<!-- Modal Usuario FIM -->	
	
  <div class="intro-header">
    <div class="container">
      <h2> <span class="glyphicon glyphicon-list-alt"></span> Lista de <?php echo $NOME_TABELA;?><small>  cadastrados!</small></h2>
    </div>
    <!-- Contact with Map - START -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="well well-sm">
			<form action="consusuario.php" name="frm" id="frm" method="post">
			<div class="panel-heading"> 
              <div class="btn-group"> 
			  <button type="button" class="btn btn-default" onClick="inicio()"> 
                <span class="glyphicon glyphicon-home"></span> Inicio</button>
				
                <button type="button" class="btn btn-default" onClick="showconfuser()"> 
                <span class="glyphicon glyphicon-plus"></span> Novo Cadastro</button>
               
                <button type="button" class="btn btn-default" onClick="showExcluir()"> 
                <span class="glyphicon glyphicon-minus"></span> Excluir</button>
		
              </div>
			                  
              <div class="btn-group"> 
             </div>
            </div>
			</div>
					<table class="table table-hover">
						<thead>
						<tr>
							<th>#</th>
							<th>Cod</th>
							<th>Nome Completo</th>
							<th>Login </th>							
							<th>Perfil </th>
							<th>Telefone </th>
							<th>Celular </th>
							<th>E-mail </th>
														
						</tr>
						</thead>
						<tbody :nth-child >
					<?php 
					
		  // Loop pelo recordset $rs
		// Cada linha vai para um array ($row) usando pg_fetch_array
		while($row = pg_fetch_array($rs)) {
		?>	
					
						<tr>
								<td width="1%" align="center"> <input type="checkbox" name="idcheck[]" id="idcheck[]" value="<?php print $row[0] ?>" /></td>
                     			<td width="2%"><?php print $row[0] ?></td>
								<td width="30%"><a href="cadusuario.php?op=A&id=<?php echo $row['idusuario']; ?>">  <?php print $row['nomeusuario'] ?></a></td>
								<td width="15%"><?php print $row['login']; ?></td>
								<td width="15%"><?php print $row['perfil']; ?></td>	
								<td width="15%"><?php print $row['telefone']; ?></td>
								<td width="15%"><?php print $row['celular']; ?></td>
								<td width="15%"><?php print $row['email']; ?></td>
															
						</tr>
						
					<?php
						  }
						// Encerra a conexão
						pg_close();
					?>
						
					
						
						
					</tbody>
					
					
					</table>
					
					</form>
            
          
        </div>
      </div>
    </div>
  </div>
  
</div>
<!-- /#wrapper --> 

<!-- jQuery Version 1.11.0 --> 
<script src="../js/jquery-1.11.0.js"></script> 

<script type="text/javascript" charset="utf-8">
	function novo()
	{
		window.location.href = 'cadusuario.php?op=I';
	}
	
	function inicio()
	{
		window.location.href = 'index.php';
	}
	/*function listacompleta()
	{
		window.location.href = 'listar.php';
	}
	*/
	function emitirRelatorio(codigo)
		{
			if (codigo == 2)
			{
				document.forms[0].action='allficha.php';
				document.forms[0].target="_blank";
				document.forms[0].submit();
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
				document.getElementById('frm').action='exec.usuario.php?op=E';
    			document.getElementById('frm').submit();
			}


	function showconfuser()
			{
				$('#myModalusuario').modal({
  					keyboard: true
				})
			}			
			
			
			
</script>



<!-- Bootstrap Core JavaScript --> 
<script src="../js/bootstrap.min.js"></script> 

<!-- Morris Charts JavaScript --> 
<script src="../js/plugins/morris/raphael.min.js"></script> 
<script src="../js/plugins/morris/morris.min.js"></script> 
<script src="../js/plugins/morris/morris-data.js"></script>
</body>
</html>