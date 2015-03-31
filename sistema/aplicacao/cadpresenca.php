<?php session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');
?>
<!DOCTYPE html>
<?php 
	require("../include/seguranca.php");
	require_once('../classes/escolabiblica.class.php');
	require_once('../classes/professor.class.php');
	require_once('../classes/banco.class.php');
	require_once('../classes/paginacao.en.class.php');
	require_once('../classes/aula.class.php');
	require_once('../classes/presenca.class.php');

$id_acesso = $_SESSION['id_acesso'];

if(($id_acesso!=5)  && ($id_acesso!=1) && ($id_acesso!=2) && ($id_acesso!=3)){
header('Location: index.php?erro=1');
}


$op = $_REQUEST['op']; 
$idaula = $_REQUEST['idaula']; 


	$clConexao = new Conexao;
	$conn = $clConexao->conecta();
	
	
	
	$Classe = new EscolaBiblica(); // <-- Alterar o nome da classe
	$Classe->conn = $conn;
	
	$Professor = new Professor(); 
	$Professor->conn = $conn;	
	
	$Aula = new Aula(); 
	$Aula->conn = $conn;

				
	if ( ($op=='A') && (!empty($idaula)) )
   {

		$Aula->getById($idaula);				
		$conteudo = $Aula->conteudo;
		$idprofessor = $Aula->idprofessor;	   
  }		
	
	
   $FORM_NAME = 'cadpresenca';
   
	$retorno = $_REQUEST['res'];
	
	if ($retorno == 'I_AULA')
	{
		$MENSAGEM_RETORNO = 'Aula cadastrada com sucesso!';
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
		$MENSAGEM_RETORNO = 'N√£o foi poss√≠vel adicionar o '.$FORM_NAME.'!';
		$MENSAGEM_COLOR = 'warning';
	}
	if ($retorno == 'NA')
	{
		$MENSAGEM_RETORNO = 'N√£o foi poss√≠vel alterar o '.$FORM_NAME.'!';
		$MENSAGEM_COLOR = 'warning';
	}
	
	
	$filtroclasse = $_REQUEST['edtfiltroclasse'];
	$cmboxordenacao = $_REQUEST['cmboxordenacao'];
	$idclasse = $_REQUEST['id'];

	class MyPag extends Paginacao
	{
		function desenhacabeca($row)
		{
		 	 $html = '
			        <thead>
					 <tr valign="top" class="tab_bg_2"> 
                      <th width="3%">#</th>
                      <th width="40%">Aluno</th>
                      <th width="20%">OBS</th>
                      <th width="10%">Status</th>
                      <th width="10%"></th>
                      </tr>
					  </thead>
                      ';
		 		echo $html;
		}

		function desenha($row){					
			//converte datas
			//$data_nas = date('d/m/Y',strtotime($row['datanas']));
			//print $classe = $row['classe'];
			//print_r ($row);
			//exit;
			$idaluno = $row['idaluno'];
			$idaluno_classe_licao_trimestre = $row['idaluno_classe_licao_trimestre'];
			$idprofessor = $_REQUEST['idprofessor'];
			$idaula = $_REQUEST['idaula'];
			$idclasse = $_REQUEST['id'];
			
			$obs = $row['obs'];
			$status = $row['status'];
			if(!empty($status)){
	
				if($status=="P"){
				$presente =	selected;
				}elseif($status=="J"){
				$justificado =	selected;
				}
			}
			$html = '				
					<form action="exec.presenca.php" name="frm2" id="frm2" method="post">	
					<input type="hidden" name="op" id="op" value="I">					
					<input type="hidden" name="id" id="id" value="'.$idclasse.'">					
					<input type="hidden" name="idaluno" id="idaluno" value="'.$row['idaluno'].'">					
					<input type="hidden" name="idprofessor" id="idprofessor" value="'.$idprofessor.'">					
					<input type="hidden" name="idaula" id="idaula" value="'.$idaula.'">					
					<input type="hidden" name="idaluno_classe_licao_trimestre" id="idaluno_classe_licao_trimestre" value="'.$idaluno_classe_licao_trimestre.'">	
					
					  <td align="center"><input type="checkbox" name="id_[]" id="id_" value="'.$row['0'].'" /></td>
					  <td nowrap>'.$row['aluno'].'</td>
					  <td nowrap> <input type="text" class="form-control"  name="edtobs" id="edtobs" value="'.$obs.'"> </td>
					  <td nowrap> <select name="edtstatus" id="edtstatus" class="form-control" >
									<option value = "">  </option>	
									<option value = "P" '.$presente.'> Presente </option>	
									<option value = "J" '.$justificado.'> Justificado </option>
								  </select>	
					  </td>
					  <td nowrap>
					 
							<button class="btn btn-warning" type="submit"> 
							<span class="glyphicon glyphicon-floppy-disk"></span> Salvar</button>
					  </td>
					  </form>
					  ';
				if(!empty($idprofessor)){	  
		 		echo $html;
				}
				echo "";
		}// function
	}
    
	$paginacao = new MyPag();
	$paginacao->conn = $conn;
	
	$Presenca = new Presenca();
	$Presenca->conn = $conn;
	
	$sql = "SELECT clt.*,aclt.idaluno_classe_licao_trimestre, a.idaluno, a.aluno, c.classe, p.idpresenca, p.data, p.status, p.obs
			FROM classe_licao_trimestre clt
			INNER JOIN aluno_classe_licao_trimestre aclt on clt.idclasse_licao_trimestre = aclt.idclasse_licao_trimestre
			INNER JOIN aluno a on aclt.idaluno = a.idaluno
			INNER JOIN classe c on clt.idclasse = c.idclasse
			LEFT JOIN presenca p on aclt.idaluno_classe_licao_trimestre = p.idaluno_classe_licao_trimestre 
			where  aclt.idclasse_licao_trimestre  = ".$idclasse;	

			
	$filtroopen = false;
	if (!empty($filtroclasse))
	{
		$sql.=" and classe ilike '%".$filtroclasse."%'";
		$filtroopen = true;
	}

	if ($cmboxordenacao == 'ano')
	{
		$sql.=" order by ano ";
		//print $sql;
	}if ($cmboxordenacao=='trimestre')
	{
		$sql.=" order by trimestre ";
		//print $sql;
	}if(empty($cmboxordenacao)){
		$sql.= " order by 2 ";
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
			<h1 class="page-header">Cadastro de Aula e Registro de Presen√ßa!</h1>
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
          <form action="cadpresenca.php" name="frm" id="frm" method="post">
		    <input type="hidden" name="id" id="id" value="<?php echo $idclasse;?>">
          	<input type="hidden" name="idprofessor" id="idprofessor" value="<?php echo $idprofessor;?>">
            
			<div class="panel-heading"> 
             <div class="btn-group"> 
                <button type="button" class="btn btn-info" onClick="salvarFechar();"> 
                <span class="glyphicon glyphicon-floppy-disk"></span> Salvar</button>
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
			<div class="panel-body"> 
				 <div class="row"> 
                    <div class="col-lg-6">						
						<label class="control-label" for="edtprofessor">Professor: (*) </label>		
						<?php echo $Professor->listaCombo('cmboxprofessor',$idprofessor,'N','class="form-control"');?>
											
						<label class="control-label" for="edtprofessor">Conte√∫do da Aula: (*) </label>		
						<textarea name="edtconteudo" id="edtconteudo" class="form-control" rows="3"><?php echo $conteudo; ?></textarea>
										
                  </div>
                  </div>
            </div>
		 </form>	
            <!-- /.panel-heading -->
            <div class="panel-body"> 
				 
              <div style="overflow:auto;"> 
                <div class="table-responsive"> 
                  <?php $paginacao->paginar();?>
                </div>
                <!-- /.table-responsive -->
              </div>
            </div>
         
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

	function validaForm()
	{
	   r = true;
	   m = '';
	   if ((document.getElementById('edtconteudo').value == '') || (document.getElementById('cmboxprofessor').value == '') )
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
				document.getElementById('frm').action='exec.presenca.php?op=IA';
				document.getElementById('frm').submit();
	   }
	}

	function novoaluno()
	{
		window.location.href = 'cadaluno.php?op=I';
	}
	
	function inicio()
	{
		window.location.href = 'index.php';
	}
	
	function filterApply()
	{
		document.getElementById('frmfiltro').action='cadpresenca.php';
    	document.getElementById('frmfiltro').submit();
	}
	function removeFilter()
	{
		window.location.href = 'cadpresenca.php';
	}
	function montapaginacao(p,nr)
	{
		document.getElementById('frm').action='cadpresenca.php?p='+p+'&nr='+nr;
    	document.getElementById('frm').submit();
	}
	
	function validaForm2()
	{
	   r = true;
	   m = '';
	   if ((document.getElementById('edtstatus').value == '') )
	   { 
	      r = false;
		  m = 'Para registrar  presen√ßa √© obrigat√≥rio escolher o Status. \r\n';
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
	function salvarStatus()
	{	 if (validaForm2()==true){
		document.getElementById('frm2').action='exec.presenca.php';
    	document.getElementById('frm2').submit();
		}
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
				document.getElementById('frmstatus').action='exec.<?php echo $FORM_NAME;?>.php?op=E';
    			document.getElementById('frmstatus').submit();
			}
			
function voltar()
	{
		window.location.href = 'consebd.php';
	}			
			
			
			
</script>

<!-- jQuery Version 1.11.0 --> 
<script src="../js/jquery-1.11.0.js"></script> 

<!-- Bootstrap Core JavaScript --> 
<script src="../js/bootstrap.min.js"></script> 

<!-- Morris Charts JavaScript --> 
<script src="../js/plugins/morris/raphael.min.js"></script> 
<script src="../js/plugins/morris/morris.min.js"></script> 
<script src="../js/plugins/morris/morris-data.js"></script>
    

</body>

</html>
