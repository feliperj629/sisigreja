<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');
require_once('../classes/banco.class.php');

require_once('../classes/tesouraria.class.php');
require("../include/seguranca.php");

$NOMEFUNCAO = 'tesouraria';
$NOMETABELA = 'tesouraria';
$M_CADASTRADO_COM_SUCESSO = 'Cadastrado com sucesso';
$I_INSERIDO_COM_SUCESSO = 'Inserido com sucesso';
$M_NAO_FOI_POSSIVEL_ALTERAR = 'Não foi possível alterar';
$M_NAO_FOI_POSSIVEL_CADASTRAR = 'Não foi possível cadastrar';
$E_ITEM_EXCLUIDO_COM_SUCESSO = 'Item excluido com sucesso';


$clConexao = new Conexao;
$conn = $clConexao->conecta();

$Tesouraria = new Tesouraria;
$Tesouraria->banco = $banco;

//print_r	($_SESSION);
//print_r	($_REQUEST);
//exit;

if(!empty($_REQUEST['op2'])){
$operacao2 = $_REQUEST['op2'];
}

if(!empty($_REQUEST['op'])){
$operacao = $_REQUEST['op'];
}



$criadopor = $_SESSION['id_usuario'];

$id_tipo_entrada = $_REQUEST['idtipoentrada'];
$id = $_REQUEST['id'];
$desc_entrada = $_REQUEST['desc_entrada'];
$idpessoa = $_REQUEST['boxidpessoa'];
$valor_ent = $_REQUEST['valor_entrada'];
$data_entrada = $_REQUEST['data_entrada'];

//Converte valor para formato float gravando corretamente no banco

if(!empty($valor_ent)){
    $converterValor = str_replace('.','',$valor_ent);
    $valor_entrada = str_replace(',','.',$converterValor);
}
if(!empty($valor_entrada) && empty($operacao)){
$operacao = "IE";
	
}
	$Tesouraria->idtipoentrada = $id_tipo_entrada;
 	$Tesouraria->id = $id;
 	$Tesouraria->descentrada = $desc_entrada;
 	$Tesouraria->valorentrada = $valor_entrada;
 	$Tesouraria->dataentrada = $data_entrada; 	
	$Tesouraria->criadopor = $criadopor;
	$Tesouraria->idpessoa = $idpessoa;
	
$id_tipo_saida = $_REQUEST['idtiposaida'];
$desc_saida = $_REQUEST['desc_saida'];
$data_saida = $_REQUEST['data_saida'];	
$valor_sai = $_REQUEST['valor_saida'];
//Converte valor para formato float gravando corretamente no banco
if(!empty($valor_sai)){
    $converterValor = str_replace('.','',$valor_sai);
    $valor_saida = str_replace(',','.',$converterValor);
}
if(!empty($valor_saida) && empty($operacao)){
$operacao = "IS";
	
}
	
	$Tesouraria->idtiposaida = $id_tipo_saida;
 	$Tesouraria->descsaida = $desc_saida;
 	$Tesouraria->valorsaida = $valor_saida;
 	$Tesouraria->datasaida = $data_saida; 	
	$Tesouraria->criadopor = $criadopor;
	$Tesouraria->idpessoa = $idpessoa;
	
if(empty($idpessoa)){
	$idpessoa = "NULL";
}

//---------------------------------------------------------------------
if (($operacao=='IE') && (!empty($valor_ent)) && (!empty($data_entrada)))
{  $result = $Tesouraria->incluir();
  
  if (!$result)
	{
	   //echo "<script language= 'javascript'>alert('".$M_NAO_FOI_POSSIVEL_CADASTRAR."')</script>";	
	   echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?RES=NI'</script>";
	}
	else
	{
	  //echo "<script language= 'javascript'>alert('".$I_INSERIDO_COM_SUCESSO."')</script>";	
        echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?RES=I'</script>";
	}
}

if (($operacao=='AE') && (!empty($valor_ent)) && (!empty($data_entrada)))
{  
	$result = $Tesouraria->alteraEntrada($id);
  
  if (!$result)
	{
	   //echo "<script language= 'javascript'>alert('".$M_NAO_FOI_POSSIVEL_CADASTRAR."')</script>";	
	   echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?RES=NA'</script>";
	}
	else
	{
	  //echo "<script language= 'javascript'>alert('".$I_INSERIDO_COM_SUCESSO."')</script>";	
        echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?RES=AE'</script>";
	}
}

if ($operacao=='IS')
{	$result = $Tesouraria->incluirSaida();

    if (!$result)
	{
	  // echo "<script language= 'javascript'>alert('".$M_NAO_FOI_POSSIVEL_CADASTRAR."')</script>";	
	   echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?RES=NIS'</script>";
	}
	else
	{
	  //echo "<script language= 'javascript'>alert('".$I_INSERIDO_COM_SUCESSO."')</script>";	
        echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?RES=IS'</script>";
	}
}
if (($operacao=='AS') && (!empty($valor_saida)) && (!empty($data_saida)))
{
	$result = $Tesouraria->alteraSaida($id);
  
  if (!$result)
	{
	   //echo "<script language= 'javascript'>alert('".$M_NAO_FOI_POSSIVEL_CADASTRAR."')</script>";	
	   echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?RES=NA'</script>";
	}
	else
	{
	  //echo "<script language= 'javascript'>alert('".$I_INSERIDO_COM_SUCESSO."')</script>";	
        echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?RES=AE'</script>";
	}
}


// EXCLUIR Entrada
if ($operacao2=='EE')
{
//print_r ($_REQUEST);
$id = $_REQUEST['idcheckentrada'];
    if (!empty($id))
	{
	//print_r ($id);
	//exit;
 		$result = $Tesouraria->alterarexcluir($id);
		if (!$result)
		{
		  // echo "<script language= 'javascript'>alert('".$M_NAO_FOI_POSSIVEL_CADASTRAR."')</script>";	
		   echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?RES=NEE'</script>";
		}
		else
		{
		  //echo "<script language= 'javascript'>alert('".$I_INSERIDO_COM_SUCESSO."')</script>";	
		  echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?RES=EE'</script>";
		}
			
	}  
}

// EXCLUIR Saida
if ($operacao2=='ES')
{
//print_r ($_REQUEST);
//exit;
$id = $_REQUEST['idchecksaida'];
//print_r ($id);
//exit;
    if (!empty($id))
	{
	
 		$result = $Tesouraria->alterarexcluir($id);
		print "aqui";
		if (!$result)
		{
		  // echo "<script language= 'javascript'>alert('".$M_NAO_FOI_POSSIVEL_CADASTRAR."')</script>";	
		   echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?RES=NES'</script>";
		}
		else
		{
		  //echo "<script language= 'javascript'>alert('".$I_INSERIDO_COM_SUCESSO."')</script>";	
		  echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?RES=ES'</script>";
		}
			
	}  
}

?>