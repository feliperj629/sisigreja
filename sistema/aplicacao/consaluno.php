<?php session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');
?>
<!DOCTYPE html>
<?php 
	require("../include/seguranca.php");
	require_once('../classes/aluno.class.php');
	require_once('../classes/banco.class.php');
	require_once('../classes/paginacao.en.class.php');

$id_acesso = $_SESSION['id_acesso'];

if(($id_acesso!=5)  && ($id_acesso!=1) && ($id_acesso!=2) && ($id_acesso!=3)){
header('Location: index.php?erro=1');
}
	
   $FORM_NAME = 'aluno';
   
   $TABLE_NAME = 'aluno';
	
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
	
	
	

	class MyPag extends Paginacao
	{
		function desenhacabeca($row)
		{
		 	 $html = '
			        <thead>
					 <tr valign="top" class="tab_bg_2"> 
                      <th width="3%">#</th>
                      <th width="32%">aluno</th>
                      <th width="15%">Classe</th>
                      <th width="15%">Telefone</th>
                      <th width="15%">Email</th>
                      <th width="20%">OBS</th>
					  
                      
                      
                      </tr>
					  </thead>
                      ';
		 		echo $html;
		}

		function desenha($row){
					
			//converte datas
			//$data_nas = date('d/m/Y',strtotime($row['datanas']));
		
		
					
			$html = ' 
                      <td align="center"><input type="checkbox" name="id_[]" id="id_" value="'.$row['idaluno_classe_licao_trimestre'].'" /></td>
					  <td nowrap><a href="cadaluno.php?op=A&id='.$row['idaluno'].'&idclasse='.$row['idclasse_licao_trimestre'].'&idalunoclasse='.$row['idaluno_classe_licao_trimestre'].'">'.$row['aluno'].'</a></td>
					  <td nowrap>'.$row['classe'].'</a></td>
					  <td nowrap>'.$row['telaluno'].'</a></td>
					  <td nowrap>'.$row['email'].'</a></td>
					  <td nowrap>'.$row['obsaluno'].'</a></td>
					 
					  
					  
					  ';
		 		echo $html;
				echo "";
		}// function
	}
    $clConexao = new Conexao;
	$conn = $clConexao->conecta();
	
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
	
	$Classe = new aluno(); // <-- Alterar o nome da aluno
	$Classe->conn = $conn;
	
	$filtroaluno = $_REQUEST['edtfiltroaluno'];
	$cmboxordenacao = $_REQUEST['cmboxordenacao'];
	
	$filtroigreja = $_REQUEST['cmboxigreja'];

	$sql = "select a.idaluno, a.aluno, a.telaluno, a.email, a.obsaluno, c.idclasse, c.classe , clt.idclasse_licao_trimestre, aclt.idaluno_classe_licao_trimestre 
			from aluno a
			INNER JOIN aluno_classe_licao_trimestre aclt on a.idaluno = aclt.idaluno
			INNER JOIN classe_licao_trimestre clt on aclt.idclasse_licao_trimestre = clt.idclasse_licao_trimestre
			INNER JOIN classe c on c.idclasse = clt.idclasse ";	
	
	$filtroopen = false;
	if (!empty($filtroaluno))
	{
		$sql.=" and aluno ilike '%".$filtroaluno."%'";
		$filtroopen = true;
	}

	if ($cmboxordenacao == 'ano')
	{
		$sql.=" order by ano ";
		//print $sql;
	}if ($cmboxordenacao=='aluno')
	{
		$sql.=" order by aluno ";
		//print $sql;
	}if(empty($cmboxordenacao)){
		$sql.= " order by 2 ";
	}
	//print $sql;
    $paginacao->sql = $sql; // a seleção sem o filtro
	$paginacao->filtro = ''; // o filtro a ser aplicado ao sql/
	$paginacao->order = $_REQUEST['o']; // como será ordenado o resultado
	$paginacao->numero_colunas = 1; // quantidade de colunas por linha // se for = 1 é sinal que é listagem por linha
	$paginacao->numero_linhas = $_REQUEST['nr']; // quantidade de linhas por páginas
	$paginacao->quadro = ''; // conteúdo em a ser exibido
	$paginacao->altura_linha = '20px'; // altura do quadro em pixel
	$paginacao->largura_coluna = '100%';
	$paginacao->mostra_informe = 'T';//
	$paginacao->pagina = $_REQUEST['p'];//$_REQUEST['p']; // página que está
	$paginacao->tamanho_imagem = '60';
	$paginacao->separador = '' ; // sepador linha que separa as rows
	//$paginacao->paginar();
?> 
<html>

<head>
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
			<h1 class="page-header">Alunos da Escola Bilica Dominical</h1>
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
            <input type="hidden" name="sql_filtro" id="sql_filtro" value="<?php echo $sql;?>">
            <div class="panel-heading"> 
             <div class="btn-group"> 
                <button type="button" class="btn btn-default" onClick="novo();"> 
                <span class="glyphicon glyphicon-plus"></span> Novo</button>
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
                      <div class="input-group input-group-sm"> <span class="input-group-addon">aluno</span> 
                        <input type="text" class="form-control"  name="edtfiltroaluno" id="edtfiltroaluno" value="<?php echo $filtroaluno;?>">
                      </div>
                    </div>
                    <div class="col-lg-3"> 
                      <div class="input-group input-group-sm"> <span class="input-group-addon">Ordenado 
                        por</span> 
                        <select name="cmboxordenacao" id="cmboxordenacao"  class="form-control" placeholder="Order">
                          <option value="">Filtro</option>
                          <option value="ano" <?php if ($cmboxordenacao=='ano') echo "selected";?> >Ano</option>
                          <option value="aluno" <?php if ($cmboxordenacao=='aluno') echo "selected";?> >aluno</option>
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
		window.location.href = 'cad<?php echo $TABLE_NAME;?>.php?op=I';
	}
	
	function inicio()
	{
		window.location.href = 'index.php';
	}
	
	function filterApply()
	{
		document.getElementById('frm').action='cons<?php echo $TABLE_NAME;?>.php';
    	document.getElementById('frm').submit();
	}
	function removeFilter()
	{
		window.location.href = 'cons<?php echo $TABLE_NAME;?>.php';
	}
	function montapaginacao(p,nr)
	{
		document.getElementById('frm').action='cons<?php echo $TABLE_NAME;?>.php?p='+p+'&nr='+nr;
    	document.getElementById('frm').submit();
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
				document.getElementById('frm').action='exec.<?php echo $TABLE_NAME;?>.php?op=E';
    			document.getElementById('frm').submit();
			}
function voltar()
	{
		window.location.href = 'consebd.php';
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
