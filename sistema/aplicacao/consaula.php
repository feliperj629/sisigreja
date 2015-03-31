<?php session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');

?>

<!DOCTYPE html>
<?php 
	require("../include/seguranca.php");
	require_once('../classes/escolabiblica.class.php');
	require_once('../classes/banco.class.php');
	require_once('../classes/paginacao.en.class.php');

$id_acesso = $_SESSION['id_acesso'];

if(($id_acesso!=5)  && ($id_acesso!=1) && ($id_acesso!=2) && ($id_acesso!=3)){
header('Location: index.php?erro=1');
}
	
   $FORM_NAME = 'Classe Escola B√≠blica Dominical';
	
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
		$MENSAGEM_RETORNO = 'N√£o foi poss√≠vel adicionar o '.$FORM_NAME.'!';
		$MENSAGEM_COLOR = 'warning';
	}
	if ($retorno == 'ALT_ERRO')
	{
		$MENSAGEM_RETORNO = 'N√£o foi poss√≠vel alterar o '.$FORM_NAME.'!';
		$MENSAGEM_COLOR = 'warning';
	}
	if ($retorno == 'DEL_ERRO')
	{
		$MENSAGEM_RETORNO = 'N√£o foi poss√≠vel excluir o '.$FORM_NAME.'!';
		$MENSAGEM_COLOR = 'warning';
	}
	
	
	$filtroclasse = $_REQUEST['edtfiltroclasse'];
	$cmboxordenacao = $_REQUEST['cmboxordenacao'];

	class MyPag extends Paginacao
	{
		function desenhacabeca($row)
		{
		 	 $html = '
			        <thead>
					 <tr valign="top" class="tab_bg_2"> 
                      <th width="3%">#</th>
                      <th width="8%">Conteudo</th>
                      <th width="8%">Data</th>
                      <th width="20%">Professor</th>
                      </tr>
					  </thead>
                      ';
		 		echo $html;
		}

		function desenha($row){
		
			$data = date('d/m/Y',strtotime($row['data']));					
			$html = ' 
                      <td align="center"><input type="checkbox" name="id_[]" id="id_" value="'.$row['idaula'].'" /></td>
					  <td nowrap><a href="cadpresenca.php?op=A&id='.$row['idaula'].'">'.$row['conteudo'].'</a></td>
					  <td nowrap>'.$data.'</td>
					  <td nowrap>'.$row['professor'].'</td>
					  ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->conecta();
	
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
	
	$Classe = new EscolaBiblica(); // <-- Alterar o nome da classe
	$Classe->conn = $conn;

	
	$id_igreja = $_SESSION['id_igreja'];
	
	$filtroigreja = $_REQUEST['cmboxigreja'];
	
	
	
	$sql = "select a.*,p.professor from aula a
INNER JOIN professor p ON a.idprofessor = p.idprofessor
			";	

	
	$filtroopen = false;
	if (!empty($filtroclasse))
	{
		$sql.=" and classe ilike '%".$filtroclasse."%'";
		$filtroopen = true;
	}

	if ($cmboxordenacao == 'professor')
	{
		$sql.=" order by professor ";
		//print $sql;
	}if ($cmboxordenacao=='conteudo')
	{
		$sql.=" order by conteudo ";
		//print $sql;
	}if(empty($cmboxordenacao)){
		$sql.= " order by data desc ";
	}
	print $sql;
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
		  <?php require("topo.php");?>
       <div id="page-wrapper">
        <div class="row">
                
		  <div class="col-lg-12"> 
			<h1 class="page-header">Escola B√≠blica Dominical</h1>
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
          <form action="#" name="frm" id="frm" method="post">
            <input type="hidden" name="sql_filtro" id="sql_filtro" value="<?php //echo $sql;?>">
            <div class="panel-heading"> 
             <div class="btn-group"> 
            
				<button type="button" class="btn btn-default" onClick="novo();"> 
					<span class="glyphicon glyphicon-plus"></span> Montar Classe</button>
				
				<button type="button" class="btn btn-default" onClick="showExcluir();"> 
					<span class="glyphicon glyphicon-minus"></span> Excluir</button>
            </div>
<!--
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-print"></i> Imprimir <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" role="menu">
				<li><a href="#" onClick="emitirRelatorio(2)"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
				<li><a href="#" onClick="emitirRelatorio(1)"><i class="fa fa-file-excel-o"></i> Excel</a></li>
			  </ul>
			</div>
			
			-->
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<i class="glyphicon glyphicon-plus"></i> Cadastrar <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" role="menu">
				<li><a href="#" onClick="cadastro(5)"><i class="fa fa-users"></i> Aluno</a></li>
				<li><a href="#" onClick="cadastro(1)"><i class="fa fa-graduation-cap"></i> Professor</a></li>
				<li><a href="#" onClick="cadastro(2)"><i class="glyphicon glyphicon-home"></i> Classe</a></li>
				<li><a href="#" onClick="cadastro(4)"><i class="glyphicon glyphicon-text-width"></i> Trimestre</a></li>
				<li><a href="#" onClick="cadastro(3)"><i class="glyphicon glyphicon-book"></i> Li√ß√£o</a></li>
				
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
                      <div class="input-group input-group-sm"> <span class="input-group-addon">Classe</span> 
                        <input type="text" class="form-control"  name="edtfiltroclasse" id="edtfiltroclasse" value="<?php echo $_REQUEST['edtfiltroclasse'];?>">
                      </div>
                    </div>
                    <div class="col-lg-3"> 
                      <div class="input-group input-group-sm"> <span class="input-group-addon">Ordenado 
                        por</span> 
                        <select name="cmboxordenacao" id="cmboxordenacao"  class="form-control" placeholder="Order">
                          <option value="">Filtro</option>
                          <option value="ano" <?php if ($cmboxordenacao=='ano') echo "selected";?> >Ano</option>
                          <option value="trimestre" <?php if ($cmboxordenacao=='ano') echo "selected";?> >trimestre</option>
                           </select>
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
		window.location.href = 'montaclasse.php?op=IM';
	}
	
	function inicio()
	{
		window.location.href = 'index.php';
	}
	
	function filterApply()
	{
		document.getElementById('frm').action='consebd.php';
    	document.getElementById('frm').submit();
	}
	function removeFilter()
	{
		window.location.href = 'consebd.php';
	}
	function montapaginacao(p,nr)
	{
		document.getElementById('frm').action='consebd.php?p='+p+'&nr='+nr;
    	document.getElementById('frm').submit();
	}
	/*function listacompleta()
	{
		window.location.href = 'listar.php';
	}
	*/
	function cadastro(codigo)
		{
			if (codigo == 1)
			{
				window.location.href = 'consprofessor.php';
			}
			if (codigo == 2)
			{
				window.location.href = 'consclasse.php';
			}if (codigo == 3)
			{
				window.location.href = 'conslicao.php';
			}if (codigo == 4)
			{
				window.location.href = 'constrimestre.php';
			}if (codigo == 5)
			{
				window.location.href = 'consaluno.php';
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
				document.getElementById('frm').action='exec.classe.php?op=EM';
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
