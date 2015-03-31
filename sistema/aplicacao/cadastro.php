<?php session_start();
//print_r ($_REQUEST);
//print_r ($_SESSION);

$id_acesso = $_SESSION['id_acesso'];

if(($id_acesso!=5) && ($id_acesso!=1) && ($id_acesso!=2)){
header('Location: index.php?erro=1');
}

 $FORM_ACTION = 'exec.cadastro.php';
 $FORM_BACK = 'conscadastro.php';

require_once('../classes/banco.class.php');
require_once('../classes/cadastro.class.php');
require("../include/seguranca.php");

$clConexao = new Conexao;
$conn = $clConexao->conecta();

$Cadastro = new Cadastro;
$Cadastro->banco = $banco;

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];
$felipe = $_SESSION['id_usuario'];
$igreja_usuario = $_SESSION['id_igreja'];

  if($igreja_usuario == 3){
	   $id_igreja = $Cadastro->id_igreja;
	   }else{
	    $id_igreja =  $igreja_usuario;
	   }
	   
 if ( ($op=='A') && (!empty($id)) )
   {
	//print $id;
    $Cadastro->getById($id);
	
	   if($igreja_usuario == 3){	  
	   $id_igreja = $Cadastro->id_igreja;
	   }else{
	    $id_igreja =  $igreja_usuario;
	   } 

	   $idcadastro = $Cadastro->id;
	   $nome = $Cadastro->nome;
	   $data_nas = $Cadastro->data_nas;
	   $id_sexo = $Cadastro->id_sexo;
	   $id_estado_civil = $Cadastro->id_estado_civil;
	   $id_escolaridade = $Cadastro->id_escolaridade;
	   $cpf = $Cadastro->cpf;
	   $rg = $Cadastro->rg;
	   $origem = $Cadastro->origem;
	   $id_cargo = $Cadastro->id_cargo;
	   $data_bat = $Cadastro->data_bat;
	   $data_bat_esp = $Cadastro->data_bat_esp;
	   $nascionalidade = $Cadastro->nascionalidade;
	   $naturalidade = $Cadastro->naturalidade;
	   $profissao = $Cadastro->profissao;
	   $telefone = $Cadastro->telefone;
	   $celular = $Cadastro->celular;
	   $email = $Cadastro->email;
	   $rua = $Cadastro->rua;
	   $numero = $Cadastro->numero;
	   $bairro = $Cadastro->bairro;
	   $cidade = $Cadastro->cidade;
	   $cep = $Cadastro->cep;
	   $uf = $Cadastro->uf;
	   $complemento = $Cadastro->complemento;
	   $nome_pai = $Cadastro->nome_pai;
	   $nome_mae = $Cadastro->nome_mae;
	   $conjuge = $Cadastro->conjuge;
	   $n_filhos = $Cadastro->n_filhos;
	   $id_recebimento = $Cadastro->id_recebimento;
	   $data_rec = $Cadastro->data_rec;
	   $igreja_ant = $Cadastro->igreja_ant;
	   $id_cargo_ant = $Cadastro->id_cargo_ant;
	   $tempo_cargo = $Cadastro->tempo_cargo;
	   $obs = $Cadastro->obs;
	   $ativo = $Cadastro->ativo;
	 

	}	

	 /*
 Lista arquivos da pasta imagem

 $path = "imagem/"; $diretorio = dir($path); 
	echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
	while($arquivo = $diretorio -> read()){
	echo "<a href='".$path.$arquivo."'>".$arquivo."</a><br />";
	}
	$diretorio -> close(); 

*/
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Chama Viva - Cadastrar Membro </title>

<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="../css/sb-admin.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="../css/plugins/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script language="JavaScript" type="text/javascript" src="../js/MascaraValidacao.js"></script>
		<script language="javascript" type="text/javascript">
			 function validar() {
		 var nome = form.nome.value;
				 
		 if (nome == "") {
		 alert('Preencha o campo com seu nome');
		 form.nome.focus(); return false; } 
		 
		 if (nome.length < 5) { 
		 alert('Digite seu nome completo');
		 form.nome.focus(); return false; }
		 }
	  function consultacep(cep){
      cep = cep.replace(/\D/g,"")
      url="http://cep.correiocontrol.com.br/"+cep+".js"
      s=document.createElement('script')
      s.setAttribute('charset','utf-8')
      s.src=url
      document.querySelector('head').appendChild(s)
    }
 
    function correiocontrolcep(valor){
      if (valor.erro) {
        alert('Cep não encontrado');       
        return;
      };
      document.getElementById('logradouro').value=valor.logradouro
      document.getElementById('bairro').value=valor.bairro
      document.getElementById('localidade').value=valor.localidade
      document.getElementById('uf').value=valor.uf
    }
			</script> 

</head>

<body>
<!-- Navigation -->

<div id="page-wrapper">
	<?php require("topo.php");?>
  <div class="intro-header">
    <div class="container">
      <h2> <span class="glyphicon glyphicon-fire"></span>Chama Viva <small>Seja bem-vindo!</small></h2>
    </div>
    <!-- Contact with Map - START -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="well well-sm">
            <form name="form" class="form-horizontal" method="post" action="<?php echo $FORM_ACTION;?>" id="form" >
			<input type="hidden" name="op" id="op" value="<?php echo $op;?>">
			<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
			<input type="hidden" name="edtidcadastro" id="edtidcadastro" value="<?php echo $id;?>">
			  
			<div class="panel-heading"> 
              <div class="btn-group"> 
                 <button type="button" class="btn btn-default" onClick="inicio()"> 
                <span class="glyphicon glyphicon-home"></span> Inicio</button>
               
              </div>
              <!--<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"></a>-->
              
              <div class="btn-group"> 
                <button type="button" class="btn btn-default" onClick="voltar();"> 
                <span class="glyphicon glyphicon-chevron-left"></span> Voltar</button>
              </div>
            </div>
			
              <fieldset>				  
			    <legend class="text-center header">               
					<h3> <span class="glyphicon glyphicon-pencil"></span>Cadastrar</h3>
				</legend>
				  <p> Obs: Para facilitar o cadastro de endereço, basta digitar primeiro o CEP.</p></br>
				
                <div class="form-group">
					<?php if(!empty($id)){?>						 
							<img class="img-thumbnail img-responsive"  src="imagem/<?php echo $id;?>.jpg" alt="Foto3/4 <?php echo $nome;?>" height="100px" width="80px">
					<?php }?>	
					
					<?php if($felipe == 1){ ?>
					<div class="col-md-1"> Id novo: *
						<input id="idnovo" name="idnovo" type="text" class="form-control" value="<?php echo $id ?>">
					</div>
					<?php }?>				 
					  <div class="col-md-6"> Nome: *
						<input id="nome" name="nome" type="text" class="form-control" value="<?php echo $nome;?>" required>
					  </div>
					  <div class="col-md-2"> Data Nascimento: *
						<input id="data_nas" name="data_nas" type="date" class="form-control" maxlength="10" onKeyPress="MascaraData2(form.data_nas);" onBlur= "ValidaData(form.data_nas);" value="<?php echo $data_nas;?>">
					  </div>
					  
					<div class="col-md-2"> Sexo: *
					  <?php echo utf8_encode($Cadastro->listaSexo('id_sexo',$id_sexo,'N','class="form-control"'));?>
					</div>
				
				</div>
				

				<div class="form-group">
				<div class="col-md-2"> Estado Civil *
                  <?php echo $Cadastro->listaEstadoCivil('id_estado_civil',$id_estado_civil,'N','class="form-control"');?>
				</div> 
				
				<div class="col-md-2">  Escolaridade *
                  <?php echo $Cadastro->listaEscolaridade('id_escolaridade',$id_escolaridade,'N','class="form-control"');?>
				</div>
				</div>  
			
               
                <div class="form-group">
                  <div class="col-md-2"> CPF: *
                    <input id="cpf" name="cpf" type="text"  class="form-control" onBlur="ValidarCPF(form.cpf);" onKeyPress="MascaraCPF(form.cpf);" maxlength="14" value="<?php echo $cpf;?>" required>
                  </div>
                  <div class="col-md-2"> Identidade/Rg: *
                    <input id="rg" name="rg" type="text" class="form-control" size="30" maxlength="12" onKeyPress="MascaraRG(form.rg);" value="<?php echo $rg;?>" required>
                  </div>
                  <div class="col-md-2"> Origem rg: *
                    <input id="origem" name="origem" type="text" class="form-control" maxlength="15" value="<?php echo $origem;?>"required>
                  </div>
				<div class="col-md-2">  Cargo:
                  <?php echo $Cadastro->listaCargo('id_cargo',$id_cargo,'N','class="form-control"');?>
				</div> 
				
				<div class="col-md-2">  Igreja:
                  <?php
				  echo $Cadastro->listaIgreja('id_igreja',$id_igreja,'N','class="form-control"');?>
				</div>  
				  
                 
				  <div class="col-md-2"> Data Batismo: 
                    <input id="data_bat" name="data_bat" type="date"  class="form-control" maxlength="10" onKeyPress="MascaraData2(form.data_bat);" onBlur= "ValidaData2(form.data_bat);" value="<?php echo $data_bat;?>">
                  </div>
				   </div>
                <div class="form-group">
				  <div class="col-md-2"> Batismo Esp. Santo: 
                    <input id="data_bat_esp" name="data_bat_esp" type="date" class="form-control" maxlength="10" onKeyPress="MascaraData2(form.data_bat_esp);" onBlur= "ValidaData2(form.data_bat_esp);" value="<?php echo $data_bat_esp;?>">
                  </div>
				  <div class="col-md-2"> Nascionalidade: 
                    <input id="nascionalidade" name="nascionalidade" type="text" class="form-control" maxlength="20" value="<?php echo $nascionalidade;?>">
                  </div>
				  <div class="col-md-2"> Naturalidade:
                    <input id="naturalidade" name="naturalidade" type="text" class="form-control" maxlength="20" value="<?php echo $naturalidade;?>">
                  </div>
				  <div class="col-md-2"> Profissao:
                    <input id="profissao" name="profissao" type="text"  class="form-control" maxlength="50" value="<?php echo $profissao;?>">
                  </div>
				  <div class="col-md-2 "> Telefone: 
                    <input id="telefone" name="telefone" type="text" class="form-control" onKeyPress="MascaraTelefone(form.telefone);" maxlength="14"  onBlur="ValidaTelefone(form.telefone);" value="<?php echo $telefone;?>">
                  </div>
                  <div class="col-md-2 "> Celular:
                    <input id="celular" name="celular" type="text" class="form-control" onKeyPress="MascaraCelular(form.celular);" maxlength="14"  onBlur="ValidaCelular(form.celular);" value="<?php echo $celular;?>">
                  </div>
				  
				</div>
                <div class="form-group">
				  <div class="col-md-4"> E-mail:
                    <div class="input-group"> <span class="input-group-addon">@</span>
                      <input id="email" name="email" type="email" placeholder="Email" class="form-control" value="<?php echo $email;?>">
                    </div>
                  </div>
				  
				  
                </div>
                <div class="form-group">
                  <div class="col-md-4"> Nome da Rua: *
                    <input id="logradouro" name="rua" type="text"  class="form-control" value="<?php echo $rua;?>" >
                  </div>
                  <div class="col-md-2"> Número: *
                    <input id="numero" name="numero" type="number"  class="form-control" value="<?php echo $numero;?>" >
                  </div> 
                  <div class="col-md-2"> Bairro: *
                    <input id="bairro" name="bairro" type="text"  class="form-control" value="<?php echo $bairro;?>" >
                  </div>
                  <div class="col-md-2"> Cidade: *
                    <input id="localidade" name="cidade" type="text"  class="form-control" value="<?php echo $cidade;?>" >
                  </div>
                  <div class="col-md-2"> CEP: *
                    <input id="cep" name="cep" type="text" onblur="consultacep(this.value)"  class="form-control" onKeyPress="MascaraCep(form.cep);" maxlength="10" onBlur="ValidaCep(form.cep)" value="<?php echo $cep;?>" >
                  </div>
				  <div class="col-md-2"> uf: *
                    <input id="uf" name="uf" type="text"  class="form-control" maxlength="2" value="<?php echo $uf;?>" >
                  </div>
				  <div class="col-md-5"> Complemento:
                    <input id="complemento" name="complemento" type="text"  class="form-control" value="<?php echo $complemento;?>">
                  </div>
                </div>
				
                <div class="form-group">
                  <div class="col-md-4"> Nome Pai:
                    <input id="nome_pai" name="nome_pai" type="text"  class="form-control" value="<?php echo $nome_pai;?>">
                  </div>
                  <div class="col-md-3"> Nome Mãe:
                    <input id="nome_mae" name="nome_mae" type="text" class="form-control" value="<?php echo $nome_mae;?>">
                  </div>
                  <div class="col-md-3"> Cônjuge:
                    <input id="conjuge" name="conjuge" type="text" class="form-control" value="<?php echo $conjuge;?>">
                  </div>
                  <div class="col-md-2"> Nº Filhos:
                    <input id="n_filhos" name="n_filhos" type="number" class="form-control" value="<?php echo $n_filhos;?>">
                  </div>
                </div>
                <div class="form-group">
				<div class="col-md-2">  Recebimento por:
				<?$id_recebimento = "2"?>
                  <?php echo $Cadastro->listaRecebimento('id_recebimento',$id_recebimento,'N','class="form-control"');?>
				</div> 
                  
                  <div class="col-md-2"> Data Recebimento:
                    <input id="data_rec" name="data_rec" type="date" class="form-control" maxlength="10" onKeyPress="MascaraData2(form.data_rec);" onBlur= "ValidaData2(form.data_rec);" value="<?php echo $data_rec;?>">
                  </div>
                  <div class="col-md-4"> Igreja de Procedência:
                    <input id="igreja_ant" name="igreja_ant" type="text" class="form-control" value="<?php echo $igreja_ant;?>">
                  </div>
                </div>
                <div class="form-group">
				
				<div class="col-md-2">   Cargo que Ocupava: 
				<?$id_cargo_ant = "14"?>
                  <?php echo $Cadastro->listaCargo('id_cargo_ant',$id_cargo_ant,'N','class="form-control"');?>
				</div> 
				
                  <div class="col-md-3"> Tempo de Cargo:
                    <input id="tempo_cargo" name="tempo_cargo" type="text" class="form-control" value="<?php echo $tempo_cargo;?>">
                  </div>
				  			
                </div>
				
                 <div class="checkbox">
					  <label>
					<input type="checkbox" name="edtativo" id="edtativo" value="1" <?php if($ativo==1){ echo " checked ";}?>>
						Ativo
					  </label>
					  
				</div>
				<div class="form-group">
                  <div class="col-md-10 col-md-offset-1">
                    <textarea class="form-control" id="obs" name="obs" rows="5"><?php echo $obs;?></textarea>
                  </div>
                </div>
				
				
                <p>Campos com (*) são obrigatórios!</p>
                <div class="form-group">
                  <legend class="text-center header">
                  <div class="col-md-12 text-center">
                 
                    <button type="reset" value="Limpar" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-refresh"></span>Limpar</button>
                    <button type="submit" onclick="return validar()" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-floppy-disk"></span>Salvar</button>
                  </div>
                  </legend>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
  mascaraTelefone( form.telefone );	
  </script> <!-- Contact with Map - END --> 
  
</div>
<!-- /#wrapper --> 

<!-- jQuery Version 1.11.0 --> 
<script src="../js/jquery-1.11.0.js"></script> 

<script type="text/javascript" charset="utf-8">
	function novo()
	{
		window.location.href = 'constesouraria.php?op=I';
	}
	 function voltar()
	{
		window.location.href = 'conscadastro.php';
	}
	function inicio()
	{
		window.location.href = 'index.php';
	}
	
	function salvarSaida()
	{
		window.location.href = 'exec.cadastro.php';
	}
	
	function salvarSaida()
	{
		window.location.href = 'exec.cadastro.php';
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
				document.getElementById('frm').action='exec.cadastro.php?op=EE';
    			document.getElementById('frm').submit();
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