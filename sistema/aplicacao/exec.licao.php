<?php
//error_reporting(E_ALL);
//ini_set('display_errors','1');
	require_once('../classes/banco.class.php');
	require_once('../classes/licao.class.php');
		
   
	//print_r ($_REQUEST);
	//exit;
$NOMEFUNCAO = 'licao';
$NOMETABELA = 'licao';
$M_CADASTRADO_COM_SUCESSO = 'Cadastrado com sucesso';
$M_NAO_FOI_POSSIVEL_ALTERAR = 'Não foi possível alterar';
$M_NAO_FOI_POSSIVEL_CADASTRAR = 'Não foi possível cadastrar';


   $clConexao = new Conexao;
   $conn = $clConexao->conecta();
   
$Classe = new Licao(); // <-- Alterar o nome da licao
$Classe->conn = $conn;

$operacao = $_REQUEST['op'];
//$id = $_REQUEST['edtidlicao'];
if (($operacao=='I') || ($operacao=='A'))
{
  
	$fechar = $_REQUEST['fechar'];
	$idlicao = $_REQUEST['edtidlicao'];
	$nomelicao = $_REQUEST['edtnomelicao'];
	

	$Classe->idlicao = $idlicao;
	$Classe->licao = $nomelicao;
	
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
   //$idlicao = $_REQUEST['edtidlicao'];
   
   $result = $Classe->alterar($idlicao);
   if (!$result)
	{
	   echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?retorno=ALT_ERRO&op=A&id=".$idlicao."'</script>";
	}
	else
	{
  	    if ($fechar == 's')
	    {
	    	echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?retorno=ALT_OK'</script>";
		}
		else
		{
	    	echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?retorno=ALT_OK&op=A&id=".$idlicao."'</script>";
		}
	}
}

if ($operacao=='E')
{
	$id = $_REQUEST['idlicao'];
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



