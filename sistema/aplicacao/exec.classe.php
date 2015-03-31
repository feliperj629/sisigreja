<?php
	require_once('../classes/banco.class.php');
	require_once('../classes/classe.class.php');
		
   
	//print_r ($_REQUEST);
	//exit;
$NOMEFUNCAO = 'classe';
$NOMETABELA = 'classe';
$M_CADASTRADO_COM_SUCESSO = 'Cadastrado com sucesso';
$M_NAO_FOI_POSSIVEL_ALTERAR = 'Não foi possível alterar';
$M_NAO_FOI_POSSIVEL_CADASTRAR = 'Não foi possível cadastrar';


   $clConexao = new Conexao;
   $conn = $clConexao->conecta();
   
$Classe = new Classe(); // <-- Alterar o nome da classe
$Classe->conn = $conn;

$operacao = $_REQUEST['op'];
$id = $_REQUEST['edtidclasse'];

if (($operacao=='I') || ($operacao=='A') || ($operacao=='IM'))
{
  
	$fechar = $_REQUEST['fechar'];
	$idclasse = $_REQUEST['edtidclasse'];
	$idclasselicaotrimestre = $_REQUEST['edtidclasselicaotrimestre'];
	$nomeclasse = $_REQUEST['edtnomeclasse'];
	$siglaclasse = $_REQUEST['edtsiglaclasse']; 
	$idtrimestre = $_REQUEST['cmboxtrimestre']; 
	$idlicao = $_REQUEST['cmboxlicao']; 
	$tipo = $_REQUEST['tipo']; 
	
	$Classe->idclasse = $idclasse;
	$Classe->idclasselicaotrimestre = $idclasselicaotrimestre;
	$Classe->classe = $nomeclasse;
	$Classe->siglaclasse = $siglaclasse;  // temos o campo siglaclasse na tabela também
	$Classe->idtrimestre = $idtrimestre;
	$Classe->idlicao = $idlicao;
}



if ($operacao=='IM')
{
   $result = $Classe->montaclasse();
   if (!$result)
	{
	   echo "<script language='javascript'>location.href='monta".$NOMETABELA.".php?retorno=INS_ERRO&op=A&id=".$id."'</script>";
	}
	else
	{
  	    if ($fechar == 's')
	    {
        	echo "<script language='javascript'>location.href='consebd.php?retorno=INS_OK'</script>";
		}
		else
		{
        	echo "<script language='javascript'>location.href='montaclassephp?retorno=INS_OK&op=A&id=".$id."'</script>";
		}
	}
}

if ($operacao=='I')
{
   $result = $Classe->incluir();
   if (!$result)
	{
	   echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?retorno=INS_ERRO&op=A&id=".$id."'</script>";
	}
	else
	{
  	    if ($fechar == 's')
	    {
        	echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?retorno=INS_OK'</script>";
		}
		else
		{
        	echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?retorno=INS_OK&op=A&id=".$id."'</script>";
		}
	}
}

if ($operacao=='A')
{
   $idclasse = $_REQUEST['edtidclasse'];
   //$result = $Classe->excluir($idclasse);
   $result = $Classe->alterar($idclasse);
   if (!$result)
	{
	   echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?retorno=ALT_ERRO&op=A&id=".$idclasse."'</script>";
	}
	else
	{
  	    if ($fechar == 's')
	    {
	    	echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?retorno=ALT_OK'</script>";
		}
		else
		{
	    	echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?retorno=ALT_OK&op=A&id=".$idclasse."'</script>";
		}
	}
}


if ($operacao=='EM')
{
//print_r ($_REQUEST);
//exit;
	$box=$_REQUEST['id_'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Classe->excluirmontaclasse($val);
			if (!$result)
			{
			   $conta_erros++;
			}
		}
	 
	if ($conta_erros==0)
	{
		echo "<script language='javascript'>location.href='consebd.php?retorno=DEL_OK'</script>";
 	}
	else
	{	
		echo "<script language='javascript'>location.href='consebd.php?retorno=DEL_ERRO'</script>";
	}
}

if ($operacao=='E')
{
	$box=$_REQUEST['id_'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Classe->excluir($val);
			if (!$result)
			{
			   $conta_erros++;
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



