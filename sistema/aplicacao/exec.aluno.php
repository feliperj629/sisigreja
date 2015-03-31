<?php
//error_reporting(E_ALL);
//ini_set('display_errors','1');
	require_once('../classes/banco.class.php');
	require_once('../classes/aluno.class.php');
		
   
	//print_r ($_REQUEST);
	//print_r ($_SESSION);
	//exit;
$NOMEFUNCAO = 'aluno';
$NOMETABELA = 'aluno';
$M_CADASTRADO_COM_SUCESSO = 'Cadastrado com sucesso';
$M_NAO_FOI_POSSIVEL_ALTERAR = 'Não foi possível alterar';
$M_NAO_FOI_POSSIVEL_CADASTRAR = 'Não foi possível cadastrar';



   $clConexao = new Conexao;
   $conn = $clConexao->conecta();
   
$Classe = new Aluno(); // <-- Alterar o nome da aluno
$Classe->conn = $conn;

$operacao = $_REQUEST['op'];
//$id = $_REQUEST['edtidaluno'];
if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$idaluno = $_REQUEST['edtidaluno'];
	$nomealuno = $_REQUEST['edtnomealuno'];
	$telaluno = $_REQUEST['edttelaluno'];
	$emailaluno = $_REQUEST['edtemailaluno'];
	$obsaluno = $_REQUEST['edtobsaluno'];
	$idclasselicaotrimestre = $_REQUEST['cmboxclassealuno'];
	$idalunoclasselicaotrimestre = $_REQUEST['edtidalunoclasse'];
	
	$criadopor = $_SESSION['id_usuario'];
	
	$Classe->idaluno = $idaluno;
	$Classe->aluno = $nomealuno;
	$Classe->telaluno = $telaluno;
	$Classe->emailaluno = $emailaluno;
	$Classe->obsaluno = $obsaluno;
	$Classe->criadopor = $criadopor;
	$Classe->idclasselicaotrimestre = $idclasselicaotrimestre;
	$Classe->idalunoclasselicaotrimestre = $idalunoclasselicaotrimestre;
	
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
     
   $result = $Classe->alterar($idaluno,$idalunoclasselicaotrimestre);
   if (!$result)
	{
	   echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?retorno=ALT_ERRO&op=A&id=".$idaluno."'</script>";
	}
	else
	{
  	    if ($fechar == 's')
	    {
	    	echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?retorno=ALT_OK'</script>";
		}
		else
		{
	    	echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?retorno=ALT_OK&op=A&id=".$idaluno."'</script>";
		}
	}
}


if ($operacao=='E')
{
	$id = $_REQUEST['idaluno'];
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



