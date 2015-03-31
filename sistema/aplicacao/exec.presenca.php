<?php 
//error_reporting(E_ALL);
//ini_set('display_errors','1');
require_once('../classes/banco.class.php');
require_once('../classes/presenca.class.php'); // <-- adiciona o arquivo da presenca
require_once('../classes/aula.class.php');

//print_r ($_REQUEST);
//exit;
$NOMEFUNCAO = 'presenca';
$NOMETABELA = 'presenca';
$M_CADASTRADO_COM_SUCESSO = 'Cadastrado com sucesso';
$M_NAO_FOI_POSSIVEL_ALTERAR = 'Não foi possível alterar';
$M_NAO_FOI_POSSIVEL_CADASTRAR = 'Não foi possível cadastrar';

$clConexao = new Conexao;
$conn = $clConexao->conecta();

$Presenca = new Presenca(); // <-- Alterar o nome da presenca
$Presenca->conn = $conn;

$Aula = new Aula(); 
$Aula->conn = $conn;
	

$operacao = $_REQUEST['op'];
$id = $_REQUEST['id'];
if (($operacao=='I') || ($operacao=='A') || ($operacao=='IA'))
{
  
	$idprofessor = $_REQUEST['cmboxprofessor'];
	$conteudo = $_REQUEST['edtconteudo'];

}



if ($operacao=='I')
{
$idaula = $_REQUEST['idaula'];
$idaluno = $_REQUEST['idaluno'];
$idprofessor = $_REQUEST['idprofessor'];
$idaluno_classe_licao_trimestre = $_REQUEST['idaluno_classe_licao_trimestre'];
$edtobs = $_REQUEST['edtobs'];
$edtstatus = $_REQUEST['edtstatus'];

//$Presenca->idaluno = $idaluno;
if(!empty($edtstatus)){
	$Presenca->idaula = $idaula;
	$Presenca->idprofessor = $idprofessor;
	$Presenca->idaluno_classe_licao_trimestre = $idaluno_classe_licao_trimestre;
	$Presenca->obs = $edtobs;
	$Presenca->status = $edtstatus;

	$result = $Presenca->incluir();

   if (!$result)
	{
	   echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?res=INS_ERRO&op=A&id=".$id."'</script>";
	}
	else
	{
       	echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?res=INS_OK&op=A&id=".$id."&idaula=".$idaula."&idprofessor=".$idprofessor."'</script>";
	}
}
}

if ($operacao=='IA')
{
	if(!empty($conteudo) && !empty($idprofessor)){
		$Aula->conteudo = $conteudo;
		$Aula->idprofessor = $idprofessor;	
		$result_id = $Aula->incluir();	
	}
   if (!$result_id)
	{
	   echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?res=N_I_AULA&op=A&id=".$id."'</script>";
	}
	else   
	{  
        echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?res=I_AULA&op=A&idaula=".$result_id."&id=".$id."&idprofessor=".$idprofessor."'</script>";
	}
}

if ($operacao=='IA')
{
   $result = $Presenca->incluir();
   if (!$result)
	{
	   echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?res=INS_ERRO&op=A&id=".$id."'</script>";
	}
	else
	{
  	    if ($fechar == 's')
	    {
        	echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?res=INS_OK'</script>";
		}
		else
		{
        	echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?res=INS_OK&op=A&id=".$id."'</script>";
		}
	}
}

if ($operacao=='A')
{
   $id = $_REQUEST['idpresenca'];
   $result = $Presenca->excluir($idpresenca);
   $result = $Presenca->incluir();
   if (!$result)
	{
	   echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?res=ALT_ERRO&op=A&id=".$idpresenca."'</script>";
	}
	else
	{
  	    if ($fechar == 's')
	    {
	    	echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?res=ALT_OK'</script>";
		}
		else
		{
	    	echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?res=ALT_OK&op=A&id=".$idpresenca."'</script>";
		}
	}
}

if ($operacao=='E')
{
	$id = $_REQUEST['idpresenca'];
	$conta_erros = 0;
    if (!empty($id)){
 		$result = $Presenca->excluir($id);
		if (!$result)
		{
		   $conta_erros++;
		}
	}
	else
	{
		$box=$_REQUEST['id_'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Presenca->excluir($val);
			if (!$result)
			{
			   $conta_erros++;
			}
		}
	} 
	if ($conta_erros==0)
	{
		echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?res=DEL_OK'</script>";
 	}
	else
	{	
		echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?res=DEL_ERRO'</script>";
	}
}

?>