<?php
//--------------------------------------------
//-- Arquivo Exec
//-- Desenvolvido por:
//-- Em:
//--------------------------------------------
//-- Include
 session_start();
$_SESSION = array();
require_once('classes/banco.class.php');
$banco = new Conexao;
$banco->conecta();

//--------------------------------------------
//--Chamada das Classes



//-----------------------------------------------
//--Recebe os parametros 

$login = $_POST['login'];
$senha = $_POST['senha'];
$senha = md5($senha);


//-----------------------------------------------
//--Operacoes

$sql ="SELECT * FROM usuario u 
INNER JOIN acesso a ON a.idacesso = u.idtipoacesso 
INNER JOIN igrejahasusuario iu ON iu.idusuario = u.idusuario 
INNER JOIN igreja i ON i.idigreja = iu.idigreja 
where  
u.login = '".$login."' 
and u.senha = '".$senha."' ";
//print $sql;
//exit;



$result = pg_query($sql);

$array = pg_fetch_array($result);
/*
print "<pre>";
print_r ($array);
exit;
*/
$_SESSION['id_usuario'] = $array['idusuario'];
$_SESSION['id_igreja'] = $array['idigreja'];
$_SESSION['igreja'] = $array['igreja']; 
$_SESSION['login'] = $array['login'];
$_SESSION['nome_usuario'] = $array['nomeusuario'];
$_SESSION['id_acesso'] = $array['idacesso'];
$_SESSION['desc_acesso'] = $array['descacesso'];


if (!empty($_SESSION['id_usuario'])) {
	//print_r ($_SESSION);
	//exit;
  header("Location:aplicacao/index.php");
}else{
session_destroy();
  header('Location:index.php?e=1');
}

?>