<?php 
session_start();
require("../include/seguranca.php");
require_once('../classes/cadastro.class.php');
require_once('../classes/banco.class.php');

$id_acesso = $_SESSION['id_acesso'];

if(($id_acesso!=5)  && ($id_acesso!=1) && ($id_acesso!=2) && ($id_acesso!=3)){
header('Location: index.php?erro=1');
}
   $clConexao = new Conexao;
   $conn = $clConexao->conecta();

   $I_INSERIDO = 'Inserido com sucesso!';
   $I_ALTERAR = 'Alterado com sucesso!';
   $E_EXCLUIDO = 'Excluido com sucesso!';
   $I_NAO_ALTERAR = 'Nao foi possível alterar!';
   $I_NAO_CADASTRAR = 'Nao foi possível cadastrar!';
   
 $res = $_REQUEST['res'];
   
   
 	
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">

	<title>Chama Viva - Listar Membros</title>

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
	
	$id_igreja = $_SESSION['id_igreja'];
	
	if($id_igreja==3){
	
	$strSQL = "SELECT pessoa.idpessoa, pessoa.nome, pessoa.idcargo, pessoa.idrecebimento, pessoa.datanas, pessoa.databat, pessoa.naturalidade,
pessoa.idestadocivil, pessoa.cpf, pessoa.rg, pessoa.idigreja, pessoa.datarec,  igreja.igreja as igreja, cargo.cargo as cargos, estadocivil.estadocivil 
FROM pessoa	
left join igreja on pessoa.idigreja = igreja.idigreja	
left join cargo on pessoa.idcargo = cargo.idcargo	
left join estadocivil on pessoa.idestadocivil = estadocivil.idestadocivil	
order by 1 ";
	
	}else{
	
	//query SQL
	$strSQL = "SELECT pessoa.idpessoa, pessoa.nome, pessoa.idcargo, pessoa.idrecebimento, pessoa.datanas, pessoa.databat, pessoa.naturalidade,
pessoa.idestadocivil, pessoa.cpf, pessoa.rg, pessoa.idigreja, pessoa.datarec,  igreja.igreja, cargo.cargo as cargos, estadocivil.estadocivil 
FROM pessoa	
left join igreja on pessoa.idigreja = igreja.idigreja	
left join cargo on pessoa.idcargo = cargo.idcargo	
left join estadocivil on pessoa.idestadocivil = estadocivil.idestadocivil	
where pessoa.idigreja = ".$id_igreja." order by 1 ";
	}
	 //print $strSQL;
	// Executa a query (o recordset $rs contém o resultado da query)
	$rs = pg_query($strSQL);
	//print $rs;
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
  <div class="intro-header">
    <div class="container">
      <h2> <span class="glyphicon glyphicon-list-alt"></span> Listagem com total de membros <small> já cadastrados!</small></h2>
    </div>
    <!-- Contact with Map - START -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="well well-sm">
			<form action="conscadastro.php" name="frm" id="frm" method="post">
			<div class="panel-heading"> 
              <div class="btn-group"> 
			  <button type="button" class="btn btn-default" onClick="inicio()"> 
                <span class="glyphicon glyphicon-home"></span> Inicio</button>
				
                <button type="button" class="btn btn-default" onClick="novo()"> 
                <span class="glyphicon glyphicon-plus"></span> Novo Cadastro</button>
               
                <button type="button" class="btn btn-default" onClick="showExcluir()"> 
                <span class="glyphicon glyphicon-minus"></span> Excluir</button>
			
			<div class="btn-group"> 
              <a class="fancybox fancybox.iframe" href="lista.php">  <button type="button" class="btn btn-default" > 
                <span class="fa fa-fw fa-table"></span> Lista completa</button></a>
             </div>
				<button type="button" class="btn btn-default" onClick="voltar();"> 
                <span class="glyphicon glyphicon-chevron-left"></span> Voltar</button>
				
              </div>
			  
			  
			  <!-- Single button -->
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					Imprimir <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" role="menu">
					<li><a onClick="emitirRelatorio(2)" href="#"><span class="glyphicon glyphicon-print pull-right"></span>PDF</a></li>					
					<li class="divider"></li>
					<li><a onClick="emitirRelatorio(1)" href="#"><span class="glyphicon glyphicon-print pull-right"></span>Excel</a></li>
				  </ul>
				</div>
			  
			  <!--
				<a href="#" onClick="emitirRelatorio(2)">
					  <span class="glyphicon glyphicon-print pull-right"></span>
				</a>
				<a href="#" onClick="emitirRelatorio(1)">
					  <span class="glyphicon glyphicon-print pull-right"></span> XLS
				</a>
				
				-->
                 
              <div class="btn-group"> 
             </div>
            </div>
			</div>
		<!--	<button type="button" class="btn btn-lg btn-danger" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">Click to toggle popover</button>
		-->
					<table class="table table-hover">
						<thead>
						<tr>
							<th>#</th>
							<th>Cod</th>
							<th>Nome Completo</th>
							<th>Cargo</th>
							<th>Recebimento </th>
							<th>Nascimento </th>							
							<th>Batismo </th>							
							<th>Natural </th>							
							<th>E. Civil </th>							
							<th>CPF </th>
							<th>RG </th>														
							<th>Igreja </th>							
													
						</tr>
						</thead>
						<tbody :nth-child >
					<?php 
		  // Loop pelo recordset $rs
		// Cada linha vai para um array ($row) usando pg_fetch_array
		while($row = pg_fetch_array($rs)) {
		//print_r ($row);
		//exit;
			
			$data_n = $row['datanas'];			
			$data_nas = implode("/",array_reverse(explode("-",$data_n)));
			if($data_nas == 0){
			$data_nas = "";
			}	
			$data_r = $row['datarec'];			
			$data_rec = implode("/",array_reverse(explode("-",$data_r)));
			if($data_rec == 0){
			$data_rec = "";
			}	
			$data_b = $row['databat'];			
			$data_bat = implode("/",array_reverse(explode("-",$data_b)));
			if($data_bat == 0){
			$data_bat = "";
			}	
			
			$idfoto = $row[0];
			$nomefoto = $row['nome'];
			//Funcao Criar Codigo de membro com CV+4 digitos		
			$cod = "CV".substr('0000',0,4-strlen($row['0'])).$row['0']; 	
			
		?>	
		<?php if(!empty($idfoto)){?>
							<a href="cadastro.php?op=A&id=<?php echo $idfoto;?>">
								<img class="img-thumbnail img-responsive"  src="imagem/<?php echo $idfoto;?>.jpg" alt="<?php echo $nomefoto;?>" height="80px" width="50px">
							</a>
						<?php }?>
						
							<tr>	
								<td width="1%" align="center"> <input type="checkbox" name="idcheck[]" id="idcheck[]" value="<?php print $row[0] ?>" /></td>
                     			<td width="2%"><?php print $cod; ?></td>
								<td width="30%"><a href="cadastro.php?op=A&id=<?php echo $row['0']; ?>">  <?php print $row['nome']; ?></a></td>
								<td width="10%"><?php print $row['cargos']; ?></td>	
								<td width="10%"><?php print $data_rec; ?></td>	
								<td width="10%"><?php print $data_nas; ?></td>								
								<td width="10%"><?php print $data_bat; ?></td>								
								<td width="25%"><?php print $row['naturalidade']; ?></td>																	
								<td width="10%"><?php print $row['estadocivil'];?></td>										
								<td width="40%"><?php print $row['cpf']; ?></td>
								<td width="40%"><?php print $row['rg']; ?></td>				
								<td width="15%"><?php print $row['igreja']; ?></td>
								
						</tr>
						
					<?php
						  }
						// Encerra a conexão
						pg_close();
					?>
						
					
						
						
					</tbody>
					<thead>
						<tr>
							<th>#</th>
							<th>Cod</th>
							<th>Nome Completo</th>
							<th>Cargo</th>
							<th>Recebimento </th>
							<th>Nascimento </th>							
							<th>Batismo </th>							
							<th>Natural </th>							
							<th>E. Civil </th>							
							<th>CPF </th>
							<th>RG </th>														
							<th>Igreja </th>	
						</thead>
					
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
		window.location.href = 'cadastro.php?op=I';
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
			if (codigo == 1)
			{
				document.forms[0].action='relmembroexcel.php';
				document.forms[0].target="_blank";
				document.forms[0].submit();
			}
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
				document.getElementById('frm').action='exec.cadastro.php?op=E';
    			document.getElementById('frm').submit();
			}
function voltar()
	{
		window.location.href = 'index.php';
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