<?php
//error_reporting(E_ALL);
//ini_set('display_errors','1');
	require_once('../classes/banco.class.php');
	require_once('../classes/trimestre.class.php');
		
   
	//print_r ($_REQUEST);
	//exit;
$NOMEFUNCAO = 'Trimestre';
$NOMETABELA = 'trimestre';
$M_CADASTRADO_COM_SUCESSO = 'Cadastrado com sucesso';
$M_NAO_FOI_POSSIVEL_ALTERAR = 'Não foi possível alterar';
$M_NAO_FOI_POSSIVEL_CADASTRAR = 'Não foi possível cadastrar';


   $clConexao = new Conexao;
   $conn = $clConexao->conecta();
   
$Classe = new Trimestre(); // <-- Alterar o nome da trimestre
$Classe->conn = $conn;

$operacao = $_REQUEST['op'];
$id = $_REQUEST['idtrimestre'];
if (($operacao=='I') || ($operacao=='A'))
{
  
	$fechar = $_REQUEST['fechar'];
	$idtrimestre = $_REQUEST['edtidtrimestre'];
	$nometrimestre = $_REQUEST['edtnometrimestre'];
	$conteudo = $_REQUEST['edtconteudo'];
	$datainicio = $_REQUEST['edtdatainicio'];
	$datafim = $_REQUEST['edtdatafim'];
	$ano = $_REQUEST['edtanotrimestre'];

	$Classe->idtrimestre = $idtrimestre;
	$Classe->trimestre = $nometrimestre;
	$Classe->conteudo = $conteudo;
	$Classe->datainicio = $datainicio;
	$Classe->datafim = $datafim;
	$Classe->ano = $ano;
}



if ($operacao=='I')
{
   $result = $Classe->incluir();
   if (!$result)
	{
	   echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?retorno=INS_ERRO&op=I'</script>";
	}
	else
	{
  	    if ($fechar == 's')
	    {
        	echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?retorno=INS_OK'</script>";
		}
		else
		{
        	echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?retorno=INS_OK&op=I'</script>";
		}
	}
}
if ($operacao=='A')
{
   //$idtrimestre = $_REQUEST['edtidtrimestre'];
   
   $result = $Classe->alterar($idtrimestre);
   if (!$result)
	{
	   echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?retorno=ALT_ERRO&op=A&id=".$idtrimestre."'</script>";
	}
	else
	{
  	    if ($fechar == 's')
	    {
	    	echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?retorno=ALT_OK'</script>";
		}
		else
		{
	    	echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?retorno=ALT_OK&op=A&id=".$idtrimestre."'</script>";
		}
	}
}

if ($operacao=='E')
{
	$id = $_REQUEST['idtrimestre'];
	$conta_erros = 0;
    if (!empty($id)){
 		$result = $Classe->excluir($id);
		if (!$result)
		{
		   $conta_erros++;
		}
	}
	else
	{
		$box=$_REQUEST['id_'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Classe->excluir($val);
			if (!$result)
			{
			   $conta_erros++;
			}
		}
	} 
	if ($conta_erros==0)
	{
		echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?retorno=DEL_OK'</script>";
 	}
	else
	{	
		echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?retorno=DEL_ERRO'</script>";
	}
}

?>



