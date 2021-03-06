<?php session_start();

//error_reporting(E_ALL);
//ini_set('display_errors','1');

require("../include/seguranca.php");
require_once('../classes/tesouraria.class.php');
require_once('../classes/cadastro.class.php');
require_once('../classes/banco.class.php');

	$NOMETABELA = "tesouraria";
  
	$res = $_REQUEST['RES'];
   
   
	if($res =='NI'){
	$corerro = "warning";
	$msg = " <strong>ERRO!</strong> Não foi possível cadastrar nova entrada! ";
	}elseif($res =='I'){
	$corerro = "info";
	$msg = " <strong>Parabéns!</strong> Nova entrada cadastrada com sucesso! ";
	}elseif($res == 'IS'){
	$corerro = "info";
	$msg = " <strong>Parabéns!</strong> Nova saída cadastrada com sucesso! ";
	}elseif($res == 'NIS'){
	$corerro = "warning";
	$msg = " <strong>ERRO!</strong> Não foi possível cadastrar nova saída! ";
	}elseif($res == 'NEE'){
	$corerro = "warning";
	$msg = " <strong>ERRO!</strong> Não foi possível excluir entrada! ";
	}elseif($res == 'EE'){
	$corerro = "info";
	$msg = " <strong>Parabéns!</strong> Entrada(s) excluida(s) com sucesso! ";
	}elseif($res == 'ES'){
	$corerro = "info";
	$msg = " <strong>Parabéns!</strong> Saida(s) excluida(s) com sucesso! ";
	}elseif($res == 'NES'){
	$corerro = "warning";
	$msg = " <strong>ERRO!</strong> Não foi possível excluir saida(s)! ";
	}elseif($res == 'AE'){
	$corerro = "info";
	$msg = " <strong>Parabéns!</strong> Entrada(s) Alterada(s) com sucesso! ";
	}elseif($res == 'AS'){
	$corerro = "info";
	$msg = " <strong>Parabéns!</strong> Saida(s) Alterada(s) com sucesso! ";
	}


$id_acesso = $_SESSION['id_acesso'];

if(($id_acesso!=4) && ($id_acesso!=1) && ($id_acesso!=2)&& ($id_acesso!=3)){
header('Location: index.php?erro=1');
}

 $FORM_ACTION = 'exec.tesouraria.php';


	$clConexao = new Conexao;
	$conn = $clConexao->conecta();
   
	$Tesouraria = new Tesouraria;
	$Tesouraria->conn = $conn;
	
	$Cadastro = new Cadastro;
	$Cadastro->conn = $conn;
  
	$op=$_REQUEST['op'];
	$id=$_REQUEST['id'];
  

   if ( ($op=='AE') && (!empty($id)) )
   {
       $Tesouraria->getById($id);	    
	    $id = $Tesouraria->id;
	    $idtipoentrada = $Tesouraria->idtipoentrada;
	    $idpessoa = $Tesouraria->idpessoa;
		$dataentrada = $Tesouraria->dataentrada;
		$valorentrada = $Tesouraria->valorentrada;
		$descentrada = $Tesouraria->descentrada;
	   //print_r ($_REQUEST);
	}
	
   if ( ($op=='AS') && (!empty($id)) )
   {
       $Tesouraria->getById($id);	    
	    $id = $Tesouraria->id;
	    $idtiposaida = $Tesouraria->idtiposaida;
	   	$datasaida = $Tesouraria->datasaida;
		$valorsaida = $Tesouraria->valorsaida;
		$descsaida = $Tesouraria->descsaida;
	   //print_r ($_REQUEST);
	}


	$relmes = $_REQUEST['relmes'];
	if(empty($relmes)){
		$relmes = date('Y'-'m');		
		$anoref = date( 'Y');
	    $mesref= date( 'm');		
	}else{
	$anoref = date( 'Y', strtotime( $relmes ));
	$mesref= date( 'm', strtotime( $relmes ));
	}
	
	$filtroopene = $_REQUEST['filtroe'];	
	$filtroopens = $_REQUEST['filtros'];
	$filtroopenb = $_REQUEST['filtrob'];	
	
	$erro = $_REQUEST['erro'];		
	if($erro == '1'){
	$colorerro = 'style="color:red"';
	}
 
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">

	<title>Chama Viva - Tesouraria</title>

<link href="../css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="../css/sb-admin.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="../css/plugins/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../font-awesome-4.1.0/css/font-awesome.css" rel="stylesheet" type="text/css">

</head>

<body>

<div id="page-wrapper">
    <?php require("topo.php");
	if(!empty($msg) && !empty($corerro)){
	?>
	<!-- MENSAGEM DE RESPOSTA AO GRAVAR-->		
	<div class='alert alert-<?php echo $corerro;?> alert-dismissible' role='alert'>
	  <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
	 <?php echo $msg;?>
	</div>
	<?php }?>	
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
	<div id="myModalsaida" class="modal fade">
			
		  <div class="modal-dialog"> 
			<div class="modal-content"> 
			  <!-- dialog body -->
			  <div class="modal-body"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				Excluir o(s) registro(s)? </div>
			  <!-- dialog buttons -->
			  <div class="modal-footer"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				<button type="button" class="btn btn-danger" onClick="excluirsaida()">Excluir</button>
			  </div>
			</div>
		  </div>
		  
	</div>
	
<div class="panel panel-default "> 
	<div class="intro-header">
		<div class="container">
		  <h2> <span class="glyphicon glyphicon-usd"></span>Controle de Caixa<small> Entradas e Saídas</small></h2>
		</div>		
	</div>	
    <!-- Contact with Map - START -->
    <div class="container">
      <div class="row">
	    <div class="col-md-12">
		
			<!-- Botoes de Cima-->
		<div class="well well-sm">
			<form name="frm" id="frm" method="post" action="constesouraria.php">
			<div class="panel-heading"> 
              <div class="btn-group"> 
                <button type="button" class="btn btn-default" onClick="inicio()"> 
                <span class="glyphicon glyphicon-home"></span> Inicio</button>
               				
              </div>
			   <!-- Single button -->
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					Imprimir <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" role="menu">
					<li><a onClick="emitirRelatorio(1)" href="#"><span class="glyphicon glyphicon-print pull-right"></span>PDF</a></li>					
					<!--<li class="divider"></li>
					<li><a onClick="emitirRelatorio(1)" href="#"><span class="glyphicon glyphicon-print pull-right"></span>Excel</a></li>
				  -->
				  </ul>
				</div>
            
			  <!--
			  <div class="btn-group"> 
              <a class="fancybox fancybox.iframe" href="saldo.php">  <button type="button" class="btn btn-default" > 
                <span class="glyphicon glyphicon-usd"></span> Saldo</button></a>
              </div>
			 
				<input value="01/2014" id="relmes" name="relmes" type="month"> -->
				
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOneFiltro"></a>
              <button type="button" class="btn btn-default" data-toggle="collapse" data-parent="#accordion" href="#collapseOneFiltro"> 
              <span class="glyphicon glyphicon-filter"></span> Filtro </button>
			  
			  
              <div class="btn-group"> 
                <button type="button" class="btn btn-default" onClick="voltar();"> 
                <span class="glyphicon glyphicon-chevron-left"></span> Voltar</button>
              </div>
            </div>
            <div id="collapseOneFiltro" class="panel-collapse collapse <?php if ($filtroopenb==true){ echo "in";} else {echo "out";}?>"> 
              <div class="panel-body"> 
                <div class="row-fluid"> 
                  <div class="row"> 
                    <div class="col-lg-6"> 
                      <div class="input-group input-group-sm"> <span class="input-group-addon">Data</span> 
                        <input id="relmes" name="relmes" type="month" class="form-control"  value="<?php echo $_REQUEST['relmes'];?>">
                      </div>
                    </div>
					<div class="col-lg-3"> 
                      <div class="btn-group"> 
                        <button type="button" class="btn btn-success" onClick="filterApply();"> 
                        <span class="glyphicon glyphicon-ok-circle"></span> Filtrar 
                        </button>
						<!--
                        <button type="button" class="btn btn-danger" onClick="removeFilter();"> 
                        <span class="glyphicon glyphicon-remove-circle"></span> 
                        Limpar</button>
						-->
					  </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
				<!-- Saldo em caixa-->
				<?php echo $Tesouraria-> saldo(); ?>
				
            </div>			
		 </form>				
		</div>
		
			<!-- FIM ---------- Botoes de Cima-->
            
         <!-- Entrada/Receita-->
         <div class="col-md-6 alert-info">
		    <div class="container">
				<div class="col-md-5 ">	
					<H3 class="navbar-text"><span class="glyphicon glyphicon-plus">
					</span><a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Entrada/Receita</a></H3>
				</div>					
			</div>				
            <div id="collapseOne" class="panel-collapse collapse <?php if ($filtroopene==true){ echo "in";} else {echo "out";}?>"> 
            <div class="panel-body">
			
            <form action="<?php echo $FORM_ACTION;?>" name="formentrada" class="form-horizontal" method="post" id="formentrada" >
			<input type="hidden" name="op" id="op" value="<?php echo $op; ?>">
			<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
			<fieldset>    
				Os campos obrigatórios estão marcados com (*)
				<div class="col-md-6" <?php echo $colorerro;?>> Tipo de Entrada: (*) 
					<?php echo $Tesouraria->listaTipoEntrada('idtipoentrada',$idtipoentrada,'N','class="form-control"');?>
				</div>
				<div class="col-md-6"> Dizimista:
					<?php echo $Cadastro->listaPessoa('boxidpessoa',$idpessoa,'N','class="form-control"');?>
				</div>
				<div class="col-md-6"  <?php echo $colorerro;?>> Data Entrada: (*)
					<input id="data_entrada" name="data_entrada" type="date" class="form-control" value="<?php echo $dataentrada;?>" required>
				</div>
				<div class="col-md-4" <?php echo $colorerro;?>> Valor: (*)
					<input id="valor_entrada" name="valor_entrada"  type="text" onkeypress="return(MascaraMoeda(this,'.',',',event))" class="form-control" value="<?php echo $valorentrada;?>" required>
				</div>
				
				<div class="col-md-12"> Desc/Obs:
					<input id="desc_entrada" name="desc_entrada" type="text" class="form-control" value="<?php echo $descentrada;?>">
				</div>	
            </fieldset>
			
			</div>
			<div class="col-md-6"> 
				<button type="submit" class="btn btn-success" onClick="salvarEntrada();"> 
				<span class="glyphicon glyphicon-ok-circle"></span> Salvar 
				</button>
            </div>
			</form>	  
            </div>
            <!-- /.panel-heading -->
				 <form action="<?php echo $FORM_ACTION;?>" name="formentradalista" class="form-horizontal" method="post" id="formentradalista" >
					<input type="hidden" name="op" id="op" value="<?php echo $op; ?>">
					<table class="table table-hover">
						<thead>
						<tr>
							<th>
								<button type="button" class="btn btn-warning" onClick="showExcluir()"> 
								<span class="glyphicon glyphicon-trash"></button>
							</th>
							<th>Tipo Entrada </th>
							<th>Data Entrada </th>
							<th>Dizimista </th>
							<th></th>	
							<th>Valor</th>							
							<th>Descrição</th>
						</tr>
						</thead>
						<tbody :nth-child>
							<?php 
							
						

	//query SQL
	$sql = "SELECT m.*, te.tipoentrada, p.nome
	FROM movimentacao m
	LEFT JOIN tipoentrada te ON m.idtipoentrada = te.idtipoentrada
	LEFT JOIN pessoa p ON m.idpessoa = p.idpessoa ";

	//if(!empty($mesref) && !empty($anoref)){
	$sql .= "
	where  Extract('Month' From dataentrada) = ".$mesref."
	 and Extract('Year' From dataentrada) = ".$anoref;
	//}

	$sql.= " and status = 1
			ORDER BY dataentrada DESC ";
	//print $sql;
	//exit;
		
		// Executa a query 
		$rs = pg_query($sql);
	
		// Loop pelo recordset $rs
		// Cada linha vai para um array ($row) usando pg_fetch_array
			while($row = pg_fetch_array($rs)) {
			
				$data_entrada = $row[dataentrada];
				if(!empty($data_entrada)){
					$DFm = explode("-",$data_entrada);
					$data_entrada = $DFm[2].'/'.$DFm[1].'/'.$DFm[0];
					}
								
		?>	
			<tr>
				<td width="1%" align="center"> 
				<input type="checkbox" name="idcheckentrada[]" id="idcheckentrada[]" value="<?php echo $row['idmovimentacao']; ?>" />
				</td>
                <td width="5%"><a href="constesouraria.php?op=AE&id=<?php echo $row['idmovimentacao']; ?>&filtroe=true"> <?php echo $row['tipoentrada']; ?></a></td>
				<td width="20%"><a href="constesouraria.php?op=AE&id=<?php echo $row['idmovimentacao']; ?>&filtroe=true"><?php echo $data_entrada; ?></a></td>
				<td width="40%"><a href="constesouraria.php?op=AE&id=<?php echo $row['idmovimentacao']; ?>&filtroe=true"><?php echo $row['nome']; ?></a></td>
				<td width="1%">R$</td>
				<td align="right" width="10%"><a href="constesouraria.php?op=AE&id=<?php echo $row['idmovimentacao']; ?>&filtroe=true"><?php echo (number_format($row['valorentrada'],2,',','.'));; ?></a></td>
				<td width="10%"><a href="constesouraria.php?op=AE&id=<?php echo $row['idmovimentacao']; ?>&filtroe=true">  <?php echo $row['descentrada']; ?></a></td>
				
			</tr>	
					<?php
					$total_entrada += $row['valorentrada'];
						  }
						// Encerra a conexão
					//print number_format($total_entrada,2,',','.');
						
					?>	
					</tbody>
					</table>
					 </form>
					<div align="right" class="alert alert-info" role="alert">
						<h3> Total Entrada:<?php echo " R$ ".number_format($total_entrada,2,',','.');?></h3>
					</div>
			</div>
			
			<!--FIM --------- Entrada/Receita-->
		

		<!-- Saida/Despesa-->
         <div class="col-md-6 alert-warning">
		    <div class="container">
				<div class="col-md-5 ">	
					<H3 class="navbar-text"><span class="glyphicon glyphicon-minus">
					</span><a data-toggle="collapse" data-parent="#accordion" href="#collapseOnesaida">Saída/Despesa</a></H3>
				</div>	
				
			</div>	
				
            <div id="collapseOnesaida" class="panel-collapse collapse <?php if ($filtroopens==true){ echo "in";} else {echo "out";}?>"> 
            <div class="panel-body">
			
            <form action="<?php echo $FORM_ACTION;?>" name="formsaida" class="form-horizontal" method="post" id="formsaida" >
			<input type="hidden" name="op" id="op" value="<?php echo $op;?>">            
			<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
			<fieldset>  
			Os campos obrigatórios estão marcados com (*)			
				<div class="col-md-6"  <?php echo $colorerro;?>> Escolha o Tipo de Saída:  (*)
					<?php echo $Tesouraria->listaTipoSaida('idtiposaida',$idtiposaida,'N','class="form-control"');?>
				</div>
				<div class="col-md-6"  <?php echo $colorerro;?>> Data Saída:  (*)
					<input id="data_saida" name="data_saida" type="date" class="form-control" value="<?php echo $datasaida;?>" required>
				</div>
				<div class="col-md-4" <?php echo $colorerro;?>> Valor:  (*)
					<input id="valor_saida" name="valor_saida" type="text" onKeyPress="return(MascaraMoeda(this,'.',',',event))" class="form-control" value="<?php echo $valorsaida;?>" required>
				</div>
				
				<div class="col-md-12"> Desc/Obs:
					<input id="desc_saida" name="desc_saida" type="text" class="form-control" value="<?php echo $descsaida;?>" >
				</div>	
            </fieldset>
			
			</div>
			<div class="col-md-6"> 
				<button type="submit" class="btn btn-success" onClick="salvarsaida();"> 
				<span class="glyphicon glyphicon-ok-circle"></span> Salvar 
				</button>
            </div>
			</form>	  
            </div>
            <!-- /.panel-heading -->
				 <form action="<?php echo $FORM_ACTION;?>" name="formsaidalista" id="formsaidalista" class="form-horizontal" method="post"  >
					<input type="hidden" name="op" id="op" value="<?php echo $op; ?>">
					<table class="table table-hover">
						<thead>
						<tr>
							<th>
								<button type="button" class="btn btn-warning" onClick="showExcluirSaida()"> 
								<span class="glyphicon glyphicon-trash"></button>
							</th>
							<th>Tipo Saída </th>
							<th>Data Saída </th>
							<th>Valor</th>							
							<th>Descrição</th>
						</tr>
						</thead>
						<tbody :nth-child>
							<?php 
				//query 
$sqlsaida = "SELECT m.*, ts.tiposaida 
			 FROM movimentacao m 
			 LEFT JOIN tiposaida ts ON m.idtiposaida = ts.idtiposaida ";

$sqlsaida .= "
			where  Extract('Month' From datasaida) = ".$mesref."
			 and Extract('Year' From datasaida) = ".$anoref;

$sqlsaida .= " 	and status = 1
				ORDER BY datasaida DESC ";
			// Executa a query (o recordset $rs contém o resultado da query)
			
			//print $sqlsaida;
			$rss = pg_query($sqlsaida);
			
		  // Loop pelo recordset $rs
		// Cada linha vai para um array ($row) usando pg_fetch_array
			while($row = pg_fetch_array($rss)) {
			//print_r ($row);
				$data_saida = $row['datasaida'];
				if(!empty($data_saida)){
					$DFm = explode("-",$data_saida);
					$data_saida = $DFm[2].'/'.$DFm[1].'/'.$DFm[0];
					}
				
		?>	
			<tr>
				<td align="center"> <input type="checkbox" name="idchecksaida[]" id="idchecksaida[]" value="<?php echo $row['idmovimentacao']; ?>" /></td>
                <td><a href="constesouraria.php?op=AS&id=<?php echo $row['idmovimentacao']; ?>&filtros=true"> <?php echo $row['tiposaida']; ?></a></td>
				<td><?php echo $data_saida; ?></td>
				<td align="right"><?php echo ("R$ ".number_format($row[valorsaida],2,',','.')); ?></td>
				<td align="center">  <?php echo $row['descsaida']; ?></td>
				
			</tr>	
				
					<?php
					$total_saida += $row[valorsaida];
						  }
						 
						// Encerra a conexão
						pg_close();
					?>	
					</tbody>
					
					
					</table>
					</form>	
					<div align="right" class="alert alert-warning" role="alert">
						<h3> Total Saida:<?php echo " R$ ".number_format($total_saida,2,',','.');?></h3>
					</div>
					
			</div>
			
			<!--FIM --------- Saída/Despesa-->
				
			            
          
        </div>
      </div>
    </div>
	
  
  </div>
</div>
<!-- /#wrapper --> 

<!-- jQuery Version 1.11.0 --> 
<script src="../js/jquery-1.11.0.js"></script> 

<script type="text/javascript" charset="utf-8">
//Formata Moeda
function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if (whichCode == 13) return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}

//-----------------------------------------------------------------------------------------------

	function removeFilter()
		{
			window.location.href = 'constesouraria.php';
		}
		
		function filterApply()
		{
			document.getElementById('frm').action='constesouraria.php?filtrob=true';
			document.getElementById('frm').submit();
		}
		
	function novo()
	{
		window.location.href = 'constesouraria.php?op=I';
	}
	function voltar()
	{
		window.location.href = 'index.php';
	}
	function inicio()
	{
		window.location.href = 'index.php';
	}
	
	function validaForm1()
	{
	   r = true;
	   m = '';
	   if ( (document.getElementById('idtipoentrada').value == '')  || 
			 (document.getElementById('valor_entrada').value == '')
			
	       )
	   { 
		  erro = '1';
	      r = false;
		  m = 'Verifique o preenchimento dos campos Obrigatorios em vermelho.\r\n';
				document.getElementById('frm').action='constesouraria.php?filtroe=true&erro='+erro+'';
				document.getElementById('frm').submit();
	   }
	   else
	   {
	   	  
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
	
	function validaForm2()
	{
	   r = true;
	   m = '';
	   if (  (document.getElementById('idtiposaida').value == '') || 
			 (document.getElementById('valor_saida').value == '')
	       )
	   { 
	      erro = '1';
	      r = false;
		  m = 'Verifique o preenchimento dos campos Obrigatorios em vermelho.\r\n';
				document.getElementById('frm').action='constesouraria.php?filtros=true&erro='+erro+'';
				document.getElementById('frm').submit();
	   }
	   else
	   {
	   	  
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

	function salvarEntrada()
	{
	   if (validaForm1()==true){
			document.getElementById('formentrada').action="exec.tesouraria.php";
   			document.getElementById('formentrada').submit();
	   }
	}
	function salvarsaida()
	{
	   if (validaForm2()==true){
			document.getElementById('formsaida').action="exec.tesouraria.php";
   			document.getElementById('formsaida').submit();
	   }
	}
	/*
	function salvarSaida()
	{
		window.location.href = 'exec.tesouraria.php';
	}
		*/
		function emitirRelatorio(codigo)
		{
			if (codigo == 1)
			{
				document.forms[0].action='relentrada.php?tipo=S';
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
				document.getElementById('formentradalista').action='exec.tesouraria.php?op2=EE';
    			document.getElementById('formentradalista').submit();
			}	
			
	function showExcluirSaida()
			{
				$('#myModalsaida').modal({
  					keyboard: true
				})
			}			
		function excluirsaida()
			{
				$('#myModalsaida').modal('hide');
				document.getElementById('formsaidalista').action='exec.tesouraria.php?op2=ES';
    			document.getElementById('formsaidalista').submit();
			}
/*
msg de erro da tela de login com tempo para fechar
 function showalert(message,alerttype) 
	{  
    $('#alert_placeholder').append('<div id="alertdiv" class="alert ' +  alerttype + '"><a class="close" data-dismiss="alert">X</a><span>'+message+'</span></div>');
    setTimeout(function() {
	// this will automatically close the alert and remove this if the users doesnt close it in 5 secs
      $("#alertdiv").remove();
	  }, 5000);
	} $(document).ready(function() {
				<?php if ($_REQUEST['e']==1)
				{
					echo 'showalert("Usu&aacute;rio ou senha inv&aacute;lidos.","alert-danger");';
				}?>
				<?php if ($_REQUEST['e']==2)
				{
					echo 'showalert("Sess&atilde;o expirou.","alert-danger");';
				}?>
			} );
*/			
			
</script> 

<!-- Bootstrap Core JavaScript --> 
<script src="../js/bootstrap.min.js"></script> 

<!-- Morris Charts JavaScript --> 
<script src="../js/plugins/morris/raphael.min.js"></script> 
<script src="../js/plugins/morris/morris.min.js"></script> 
<script src="../js/plugins/morris/morris-data.js"></script>



</body>
</html>