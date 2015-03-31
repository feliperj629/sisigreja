<?php session_start();

require_once('../classes/banco.class.php');


$clConexao = new Conexao;
$conn = $clConexao->conecta();
//print_r ($_SESSION);
//exit;
$id =  $_SESSION['id_usuario'];

$nome_usuario = $_SESSION['nome_usuario'];
$perfil = $_SESSION['desc_acesso'];
$id_acesso = $_SESSION['id_acesso'];
//$linktes = "constesouraria.php";
//$linksec = "conscadastro.php";

/*print_r ($_SESSION);
echo $_SERVER['REQUEST_URI'];
*/
/*
$url = $_SERVER['SCRIPT_NAME'];
if(($url == "/sistema/aplicacao/conscadastro.php") && ($id_acesso==4))
{
	//header('Location: index.php?erro=1');
}*/



if($id_acesso == 5 ){
$tesouraria = "list-group-item  disabled";
$naoadm = "list-group-item  disabled";
//$linktes = "#";
}
if($id_acesso == 4 ){
$secretaria = "list-group-item  disabled";
$naoadm = "list-group-item  disabled";
//$linksec = "#";
}


if (empty($id)) {

  header("Location: ../index.php?erro=1");
}


?>