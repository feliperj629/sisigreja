<?php session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');
?>
<!DOCTYPE html>
<?php 
	require("../include/seguranca.php");
	require_once('../classes/cadastro.class.php');
	require_once('../classes/banco.class.php');
	require_once('../classes/paginacao.en.class.php');

$id_acesso = $_SESSION['id_acesso'];

if(($id_acesso!=5)  && ($id_acesso!=1) && ($id_acesso!=2) && ($id_acesso!=3)){
header('Location: index.php?erro=1');
}
	
   $FORM_NAME = 'Cadastro';
	
	$retorno = $_REQUEST['res'];
	if ($retorno == 'I')
	{
		$MENSAGEM_RETORNO = $FORM_NAME.' adicionado com sucesso!';
		$MENSAGEM_COLOR = 'success';
	}
	if ($retorno == 'AI')
	{
		$MENSAGEM_RETORNO = $FORM_NAME.' alterado com sucesso!';
		$MENSAGEM_COLOR = 'success';
	}
	if ($retorno == 'E')
	{
		$MENSAGEM_RETORNO = $FORM_NAME.' exclu&iacute;do com sucesso!';
		$MENSAGEM_COLOR = 'success';
	}
	if ($retorno == 'N')
	{
		$MENSAGEM_RETORNO = 'N„o foi possÌvel adicionar o '.$FORM_NAME.'!';
		$MENSAGEM_COLOR = 'warning';
	}
	if ($retorno == 'NA')
	{
		$MENSAGEM_RETORNO = 'N„o foi possÌvel alterar o '.$FORM_NAME.'!';
		$MENSAGEM_COLOR = 'warning';
	}
	
	
	$filtropessoa = $_REQUEST['edtfiltropessoa'];
	$cmboxordenacao = $_REQUEST['cmboxordenacao'];

	class MyPag extends Paginacao
	{
		function desenhacabeca($row)
		{
		 	 $html = '
			        <thead>
					 <tr valign="top" class="tab_bg_2"> 
                      <th width="3%">#</th>
                      <th width="8%">Cod</th>
                      <th width="30%">Nome Completo</th>
                      <th width="10%">Cargo</th>
                      <th width="10%">Recebimento</th>
                      <th width="10%">Nascimento</th>
                      <th width="10%">Batismo</th>
                      <th width="10%">E. Civil</th>
                      <th width="10%">CPF</th>
                      <th width="10%">RG</th>
                      <th width="10%">Igreja</th>
                      </tr>
					  </thead>
                      ';
		 		echo $html;
		}

		function desenha($row){
			// $date = new DateTime($row['datacadastro']);
			$idfoto = $row[0];
			if(!empty($idfoto)){
				$htmlimg = "
				<a href='cadastro.php?op=A&id=".$idfoto."'>
				<img class='img-thumbnail img-responsive'  src='imagem/".$idfoto.".jpg' height='80px' width='50px'>
				</a>
				";
			}
			
			$turno = $row["turno"];
			if($turno == 'M'){
				$turno = "Manh√£";
			}elseif($turno == 'T'){
				$turno = "Tarde";
			}else{
				$turno = "Noite";
			}	
			//Gera codigo de membro	
			$cod = "CV".substr('0000',0,4-strlen($row['0'])).$row['0'];
			//converte datas
			$data_nas = date('d/m/Y',strtotime($row['datanas']));
			$data_bat = date('d/m/Y',strtotime($row['databat']));
			//$data_bat_esp = date('d/m/Y',strtotime($row['databatesp']));
			$data_rec = date('d/m/Y',strtotime($row['datarec']));
					
			$html = ' 
                      <td align="center"><input type="checkbox" name="id_[]" id="id_" value="'.$row["idpessoa"].'" /></td>
					  <td nowrap><a href="cadastro.php?op=A&id='.$row['idpessoa'].'">'.$cod.$htmlimg.'</a></td>
					  <td nowrap><a href="cadastro.php?op=A&id='.$row['idpessoa'].'">'.$row["nome"].'</a></td>
					  <td nowrap><a href="cadastro.php?op=A&id='.$row['idpessoa'].'">'.$row["cargos"].'</a></td>
					  <td nowrap><a href="cadastro.php?op=A&id='.$row['idpessoa'].'">'.$data_rec.'</a></td>
					  <td nowrap><a href="cadastro.php?op=A&id='.$row['idpessoa'].'">'.$data_nas.'</a></td>
					  <td nowrap><a href="cadastro.php?op=A&id='.$row['idpessoa'].'">'.$data_bat.'</a></td>
					  <td nowrap><a href="cadastro.php?op=A&id='.$row['idpessoa'].'">'.$row["estadocivil"].'</a></td>
					  <td nowrap><a href="cadastro.php?op=A&id='.$row['idpessoa'].'">'.$row["cpf"].'</a></td>
					  <td nowrap><a href="cadastro.php?op=A&id='.$row['idpessoa'].'">'.$row["rg"].'</a></td>
					  <td nowrap><a href="cadastro.php?op=A&id='.$row['idpessoa'].'">'.$row["igreja"].'</a></td>
					  ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->conecta();
	
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
	
	$Classe = new Cadastro(); // <-- Alterar o nome da classe
	$Classe->conn = $conn;

	
	$id_igreja = $_SESSION['id_igreja'];
	
	$filtroigreja = $_REQUEST['cmboxigreja'];
	
	if($id_igreja==3){
	
	$sql = "SELECT pessoa.idpessoa, pessoa.nome, pessoa.idcargo, pessoa.idrecebimento, pessoa.datanas, pessoa.databat, pessoa.naturalidade,
	pessoa.idestadocivil, pessoa.cpf, pessoa.rg, pessoa.idigreja, pessoa.datarec,  igreja.igreja as igreja, cargo.cargo as cargos, estadocivil.estadocivil 
	FROM pessoa	
	left join igreja on pessoa.idigreja = igreja.idigreja	
	left join cargo on pessoa.idcargo = cargo.idcargo	
	left join estadocivil on pessoa.idestadocivil = estadocivil.idestadocivil
	where pessoa.idpessoa = pessoa.idpessoa
	";	
	}else{
	//query SQL
	$sql = "SELECT pessoa.idpessoa, pessoa.nome, pessoa.idcargo, pessoa.idrecebimento, pessoa.datanas, pessoa.databat, pessoa.naturalidade,
	pessoa.idestadocivil, pessoa.cpf, pessoa.rg, pessoa.idigreja, pessoa.datarec,  igreja.igreja, cargo.cargo as cargos, estadocivil.estadocivil 
	FROM pessoa	
	left join igreja on pessoa.idigreja = igreja.idigreja	
	left join cargo on pessoa.idcargo = cargo.idcargo	
	left join estadocivil on pessoa.idestadocivil = estadocivil.idestadocivil	
	where pessoa.idigreja = ".$id_igreja;
	}
	
	$filtroopen = false;
	if (!empty($filtropessoa))
	{
		$sql.=" and pessoa.nome ilike '%".$filtropessoa."%'";
		$filtroopen = true;
	}if ($filtroigreja == '1' || $filtroigreja == '2')
	{
		$sql.=" and pessoa.idigreja = ".$filtroigreja;
		$filtroopen = true;
		//print $sql;
	}

	if ($cmboxordenacao == 'pessoa')
	{
		$sql.=" order by pessoa.nome ";
		//print $sql;
	}if ($cmboxordenacao=='cargo')
	{
		$sql.=" order by pessoa.idcargo ";
		//print $sql;
	}if(empty($cmboxordenacao)){
		$sql.= " order by 1 ";
	}
	//print $sql;
    $paginacao->sql = $sql; // a seleÁ„o sem o filtro
	$paginacao->filtro = ''; // o filtro a ser aplicado ao sql/
	$paginacao->order = $_REQUEST['o']; // como ser· ordenado o resultado
	$paginacao->numero_colunas = 1; // quantidade de colunas por linha // se for = 1 È sinal que È listagem por linha
	$paginacao->numero_linhas = $_REQUEST['nr']; // quantidade de linhas por p·ginas
	$paginacao->quadro = ''; // conte˙do em a ser exibido
	$paginacao->altura_linha = '20px'; // altura do quadro em pixel
	$paginacao->largura_coluna = '100%';
	$paginacao->mostra_informe = 'T';//
	$paginacao->pagina = $_REQUEST['p'];//$_REQUEST['p']; // p·gina que est·
	$paginacao->tamanho_imagem = '60';
	$paginacao->separador = '' ; // sepador linha que separa as rows
	//$paginacao->paginar();
?> 
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">

	<title>Chama Viva - Listar Membros</title>

<link href="../css/bootstrap.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="../css/sb-admin.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="../css/plugins/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../font-awesome-4.1.0/css/font-awesome.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php require("topo.php");?>
<div id="myModal" class="modal fade">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
      <!-- dialog body -->
      <div class="modal-body"> 
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        Excluir todos o(s) registros(s)? </div>
      <!-- dialog buttons -->
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger" onClick="excluir()">Excluir</button>
      </div>
    </div>
  </div>
</div>

    <div id="page-wrapper">
		  
       <div id="page-wrapper">
        <div class="row">
                
		  <div class="col-lg-12"> 
			<h1 class="page-header">Lista de Membros</h1>
			<?php if ($retorno!='')	{ ?>
			<div id="alertdiv" class="alert alert-<?php echo $MENSAGEM_COLOR;?>"><?php echo $MENSAGEM_RETORNO;?></div>
			<? } ?>
			<div id="alert_placeholder"> </div>
		  </div>
                <!-- /.col-lg-12 -->
         </div>
            <!-- /.row -->
            <div class="row">
                
      <div class="col-lg-12"> 
        <div class="panel panel-default"> 
          <form action="conscadastro.php" name="frm" id="frm" method="post">
            <input type="hidden" name="sql_filtro" id="sql_filtro" value="<?php echo $sql;?>">
            <div class="panel-heading"> 
             <div class="btn-group"> 
                <button type="button" class="btn btn-default" onClick="novo();"> 
                <span class="glyphicon glyphicon-plus"></span> Novo</button>
                <button type="button" class="btn btn-default" onClick="showExcluir();"> 
                <span class="glyphicon glyphicon-minus"></span> Excluir</button>
              </div>

			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-print"></i> Imprimir <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" role="menu">
				<li><a href="#" onClick="emitirRelatorio(2)"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
				<li><a href="#" onClick="emitirRelatorio(1)"><i class="fa fa-file-excel-o"></i> Excel</a></li>
				<li><a href="#" onClick="emitirRelatorio(3)"><i class="fa fa-file-pdf-o"></i> Lista de Aniversariantes</a></li>
			  </ul>
			</div>

              <!--<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"></a>-->
              <button type="button" class="btn btn-default" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> 
              <span class="glyphicon glyphicon-filter"></span> Filtro </button>
              <div class="btn-group"> 
                <button type="button" class="btn btn-default" onClick="voltar();"> 
                <span class="glyphicon glyphicon-chevron-left"></span> Voltar</button>
              </div>
            </div>
            <div id="collapseOne" class="panel-collapse collapse <?php if ($filtroopen==true){ echo "in";} else {echo "out";}?>"> 
              <div class="panel-body"> 
                <div class="row-fluid"> 
                  <div class="row"> 
                    <div class="col-lg-6"> 
                      <div class="input-group input-group-sm"> <span class="input-group-addon">Nome</span> 
                        <input type="text" class="form-control"  name="edtfiltropessoa" id="edtfiltropessoa" value="<?php echo $_REQUEST['edtfiltropessoa'];?>">
                      </div>
                    </div>
                    <div class="col-lg-3"> 
                      <div class="input-group input-group-sm"> <span class="input-group-addon">Ordenado 
                        por</span> 
                        <select name="cmboxordenacao" id="cmboxordenacao"  class="form-control" placeholder="Order">
                          <option value="">Filtro</option>
                          <option value="pessoa" <?php if ($cmboxordenacao=='pessoa') echo "selected";?> >Nome</option>
                          <option value="cargo" <?php if ($cmboxordenacao=='cargo') echo "selected";?> >Cargo</option>
                          <option value="igreja" <?php if ($cmboxordenacao=='igreja') echo "selected";?> >igreja</option>
                        </select>
                      </div>
                    </div>
					<div class="col-lg-3"> 
                      <div class="input-group input-group-sm"> <span class="input-group-addon">igreja</span> 
                        <?php echo $Classe->listaIgreja('cmboxigreja',$idigreja,'N','class="form-control"');?>				
                      </div>
                    </div>
                  </div>
                  <div class="row"> 
                    <div class="col-lg-12"><br>
                    </div>
                  </div>
                  <div class="row"> 
                    <div class="col-lg-9"> </div>
                    <div class="col-lg-3"> 
                      <div class="btn-group"> 
                        <button type="button" class="btn btn-success" onClick="filterApply();"> 
                        <span class="glyphicon glyphicon-ok-circle"></span> Filtrar 
                        </button>
                        <button type="button" class="btn btn-danger" onClick="removeFilter();"> 
                        <span class="glyphicon glyphicon-remove-circle"></span> 
                        Limpar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body"> 
              <div style="overflow:auto;"> 
                <div class="table-responsive"> 
                  <?php $paginacao->paginar();?>
                </div>
                <!-- /.table-responsive -->
              </div>
            </div>
          </form>
          <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
      </div>
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->

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
	
	function filterApply()
	{
		document.getElementById('frm').action='conscadastro.php';
    	document.getElementById('frm').submit();
	}
	function removeFilter()
	{
		window.location.href = 'conscadastro.php';
	}
	function montapaginacao(p,nr)
	{
		document.getElementById('frm').action='conscadastro.php?p='+p+'&nr='+nr;
    	document.getElementById('frm').submit();
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
			}if (codigo == 3)
			{
				document.forms[0].action='listaaniver.php';
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
