<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');
require_once('../classes/banco.class.php');
require_once('../classes/usuario.class.php');
require("../include/seguranca.php");

//print "<pre>";
//print_r ($_REQUEST);
//exit;


$NOMEFUNCAO = 'usuario';
$NOMETABELA = 'usuario';
$M_CADASTRADO_COM_SUCESSO = 'Cadastrado com sucesso';
$I_INSERIDO_COM_SUCESSO = 'Inserido com sucesso';
$M_NAO_FOI_POSSIVEL_ALTERAR = 'Não foi possível alterar';
$M_NAO_FOI_POSSIVEL_CADASTRAR = 'Não foi possível cadastrar';
$E_ITEM_EXCLUIDO_COM_SUCESSO = 'Item excluido com sucesso';


$clConexao = new Conexao;
$conn = $clConexao->conecta();

$usuario = new Usuario;
$usuario->banco = $banco;

$operacao = $_REQUEST['op'];
$criado_por = $_SESSION['id'];



$id = $_REQUEST['edtid'];
$nome = $_REQUEST['edtnome'];
$email = $_REQUEST['edtemail'];
$telefone = $_REQUEST['edttelefone'];
$celular = $_REQUEST['edtcelular'];
$login = $_REQUEST['edtlogin'];
$senhaatual = md5($_REQUEST['edtsenhaatual']);
$senhanova = md5($_REQUEST['edtsenhanova']);

$perfil = $_REQUEST['edtidperfil'];
$igreja = $_REQUEST['edtidigreja'];
//print $igreja;
//exit;


	$usuario->nome = $nome;
 	$usuario->email = $email;
 	$usuario->telefone = $telefone;
 	$usuario->celular = $celular;
 	$usuario->login = $login; 		
	$usuario->idtipoacesso = $perfil;
	$usuario->idigrejausuario = $igreja;
	
if ($operacao=='A')
{
	//Verificação de senha
	if((!empty($senhaatual)) && (!empty($id))){
	
		if((!empty($senhaatual)) && (!empty($senhanova))){				
				//Verificar se a senha é valida buscando do banco de dados
					$sql = 'select senha from usuario where idusuario = '.$id.'';
					$rs = pg_query($sql);
					$row = pg_fetch_array($rs);
					//print_r ($row);					
					$senhabd = $row[0];					
					
					if($senhabd == $senhaatual){			
						$usuario->senha = $senhanova;						
					}else{
						echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?op=A&res=SI&id=".$id."'</script>";
					}
		}
	}
}

if ($operacao=='I')
{
 $result = $usuario->incluir();
   if (!$result)
	{
	 //  echo "<script language= 'javascript'>alert('".$M_NAO_FOI_POSSIVEL_CADASTRAR."')</script>";	
	   echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?res=N'</script>";
	}
	else
	{
		//echo "<script language= 'javascript'>alert('".$I_INSERIDO_COM_SUCESSO."')</script>";	
		echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?res=I'</script>";
	}
}

//Alterar
if ($operacao=='A')
{	
   $result = $usuario->alterar($id);
   if (!$result)
	{
		echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?res=NA&op=A&id=".$id."'</script>";
	}
	else
	{
		echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?res=AI&op=A&id=".$id."'</script>";
	}
	
	
}
// EXCLUIR
if ($operacao=='E')
{

//print "AQUIIIII";
//print $codtestemunho;
//exit;

$id = $_REQUEST['idcheck'];

    if (!empty($id)){
 		$result = $usuario->excluir($id);
		
	}
	//echo "<script language= 'javascript'>alert('".$E_ITEM_EXCLUIDO_COM_SUCESSO."')</script>";	
	echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?es=E'</script>";

       
}

?>