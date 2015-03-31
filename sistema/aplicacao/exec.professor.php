<?php
//error_reporting(E_ALL);
//ini_set('display_errors','1');
	require_once('../classes/banco.class.php');
	require_once('../classes/professor.class.php');
		
   
	//print_r ($_REQUEST);
	//print_r ($_SESSION);
	//exit;
$NOMEFUNCAO = 'professor';
$NOMETABELA = 'professor';
$M_CADASTRADO_COM_SUCESSO = 'Cadastrado com sucesso';
$M_NAO_FOI_POSSIVEL_ALTERAR = 'Não foi possível alterar';
$M_NAO_FOI_POSSIVEL_CADASTRAR = 'Não foi possível cadastrar';



   $clConexao = new Conexao;
   $conn = $clConexao->conecta();
   
$Classe = new Professor(); // <-- Alterar o nome da professor
$Classe->conn = $conn;

$operacao = $_REQUEST['op'];
//$id = $_REQUEST['edtidprofessor'];
if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$idprofessor = $_REQUEST['edtidprofessor'];
	$nomeprofessor = $_REQUEST['edtnomeprofessor'];
	$telprofessor = $_REQUEST['edttelprofessor'];
	$obsprofessor = $_REQUEST['edtobsprofessor'];
	
	$criadopor = $_SESSION['id_usuario'];
	
	$Classe->idprofessor = $idprofessor;
	$Classe->professor = $nomeprofessor;
	$Classe->telprofessor = $telprofessor;
	$Classe->obsprofessor = $obsprofessor;
	$Classe->criadopor = $criadopor;
	
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
   //$idprofessor = $_REQUEST['edtidprofessor'];
   
   $result = $Classe->alterar($idprofessor);
   if (!$result)
	{
	   echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?retorno=ALT_ERRO&op=A&id=".$idprofessor."'</script>";
	}
	else
	{
  	    if ($fechar == 's')
	    {
	    	echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?retorno=ALT_OK'</script>";
		}
		else
		{
	    	echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?retorno=ALT_OK&op=A&id=".$idprofessor."'</script>";
		}
	}
}

if ($operacao=='E')
{
	$id = $_REQUEST['idprofessor'];
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



