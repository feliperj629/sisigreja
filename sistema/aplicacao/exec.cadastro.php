<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');

//include('security.inc');



require_once('../classes/banco.class.php');

require_once('../classes/cadastro.class.php');
require("../include/seguranca.php");


$NOMEFUNCAO = 'cadastro';
$NOMETABELA = 'cadastro';
$M_CADASTRADO_COM_SUCESSO = 'Cadastrado com sucesso';
$I_INSERIDO_COM_SUCESSO = 'Inserido com sucesso';
$M_NAO_FOI_POSSIVEL_ALTERAR = 'Não foi possível alterar';
$M_NAO_FOI_POSSIVEL_CADASTRAR = 'Não foi possível cadastrar';
$E_ITEM_EXCLUIDO_COM_SUCESSO = 'Item excluido com sucesso';


$clConexao = new Conexao;
$conn = $clConexao->conecta();

$Cadastro = new Cadastro;
$Cadastro->banco = $banco;

$operacao = $_REQUEST['op'];
/*
print "<pre>";
print_r ($_REQUEST);
print "</pre>";
exit;
*/

$id = $_REQUEST['id'];
$idnovo = $_REQUEST['idnovo'];

$nome = $_REQUEST['nome'];
$data_n = $_REQUEST['data_nas'];
$id_sexo = $_REQUEST['id_sexo'];
$id_estado_civil = $_REQUEST['id_estado_civil'];
$id_escolaridade = $_REQUEST['id_escolaridade'];
$cpf = $_REQUEST['cpf'];
$rg = $_REQUEST['rg'];
$origem = $_REQUEST['origem'];
$id_cargo = $_REQUEST['id_cargo'];
$id_igreja = $_REQUEST['id_igreja'];
$data_b = $_REQUEST['data_bat'];
$data_bat_e = $_REQUEST['data_bat_esp'];
$nascionalidade = $_REQUEST['nascionalidade'];
$naturalidade = $_REQUEST['naturalidade'];
$profissao = $_REQUEST['profissao'];
$telefone = $_REQUEST['telefone'];
$celular = $_REQUEST['celular'];
$email = $_REQUEST['email'];
$rua = $_REQUEST['rua'];
$numero = $_REQUEST['numero'];
$bairro = $_REQUEST['bairro'];
$cidade = $_REQUEST['cidade'];
$cep = $_REQUEST['cep'];
$uf = $_REQUEST['uf'];
$complemento = $_REQUEST['complemento'];
$nome_pai = $_REQUEST['nome_pai'];
$nome_mae = $_REQUEST['nome_mae'];
$conjuge = $_REQUEST['conjuge'];
$n_filhos = $_REQUEST['n_filhos'];
$id_recebimento = $_REQUEST['id_recebimento'];
$data_r = $_REQUEST['data_rec'];
$igreja_ant = $_REQUEST['igreja_ant'];
$id_cargo_ant = $_REQUEST['id_cargo_ant'];
$tempo_cargo = $_REQUEST['tempo_cargo'];
$obs = $_REQUEST['obs'];
$ativo = $_REQUEST['edtativo'];


if(empty($ativo)){
$ativo = "0";
}

// Atribui NULL ao campo data , pois o banco de dados nao aceita vazio!
$data_nas = "NULL"; 
if(!empty($data_n)){
$data_nas = "'".$data_n."'";
}
$data_bat = "NULL";
if(!empty($data_b)){
$data_bat = "'".$data_b."'";
}
$data_bat_esp = "NULL";
if(!empty($data_bat_e)){
$data_bat_esp = "'".$data_bat_e."'";
}
$data_rec = "NULL";
if(!empty($data_r)){
$data_rec = "'".$data_r."'";
}
$criado_por = $_SESSION['id_usuario'];
//print $_SESSION['id_usuario'];
//exit;

	



if (($operacao=='I') || ($operacao=='A'))
{
 	$Cadastro->id = $id;
 	$Cadastro->idnovo = $idnovo;
	
 	$Cadastro->nome = $nome;
 	$Cadastro->data_nas = $data_nas;
 	$Cadastro->id_sexo = $id_sexo;
 	$Cadastro->id_estado_civil = $id_estado_civil;
 	$Cadastro->id_escolaridade = $id_escolaridade;
 	$Cadastro->cpf = $cpf;
 	$Cadastro->rg = $rg;
 	$Cadastro->origem = $origem;
 	$Cadastro->id_cargo = $id_cargo;
 	$Cadastro->id_igreja = $id_igreja;
 	$Cadastro->data_bat = $data_bat;
 	$Cadastro->data_bat_esp = $data_bat_esp;
 	$Cadastro->nascionalidade = $nascionalidade;
 	$Cadastro->naturalidade = $naturalidade;
 	$Cadastro->profissao = $profissao;
 	$Cadastro->telefone = $telefone;
 	$Cadastro->celular = $celular;
 	$Cadastro->email = $email;
 	$Cadastro->rua = $rua;
 	$Cadastro->numero = $numero;
 	$Cadastro->bairro = $bairro;
 	$Cadastro->cidade = $cidade;
 	$Cadastro->cep = $cep;
 	$Cadastro->uf = $uf;
 	$Cadastro->complemento = $complemento;
 	$Cadastro->nome_pai = $nome_pai;
 	$Cadastro->nome_mae = $nome_mae;
 	$Cadastro->conjuge = $conjuge;
 	$Cadastro->n_filhos = $n_filhos;
 	$Cadastro->id_recebimento = $id_recebimento;
 	$Cadastro->data_rec = $data_rec;
 	$Cadastro->igreja_ant = $igreja_ant;
 	$Cadastro->id_cargo_ant = $id_cargo_ant;
 	$Cadastro->tempo_cargo = $tempo_cargo;
 	$Cadastro->obs = $obs;
 	$Cadastro->ativo = $ativo;
	$Cadastro->criado_por = $criado_por;
	
	
}

if ($operacao=='I')
{
 //print "teste";
	//exit;
 $result = $Cadastro->incluir();
   if (!$result)
	{
	  // echo "<script language= 'javascript'>alert('".$M_NAO_FOI_POSSIVEL_CADASTRAR."')</script>";	
	   echo "<script language='javascript'>location.href='conscadastro.php?res=N'</script>";
	}
	else
	{
	  //echo "<script language= 'javascript'>alert('".$I_INSERIDO_COM_SUCESSO."')</script>";	
        echo "<script language='javascript'>location.href='conscadastro.php?res=I'</script>";
	}
}

if ($operacao=='A')
{
	
   $result = $Cadastro->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('".$M_NAO_FOI_POSSIVEL_ALTERAR."')</script>";	
	   echo "<script language='javascript'>location.href='cad".$NOMETABELA.".php?res=NA&op=A&id=".$id."'</script>";
	}
	else
	{
	//echo "<script language= 'javascript'>alert('".$I_INSERIDO_COM_SUCESSO."')</script>";	
    echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?res=AI'</script>";
	}
	
	
}

// EXCLUIR
if ($operacao=='E')
{
$id = $_REQUEST['idcheck'];

    if (!empty($id)){
 		$result = $Cadastro->excluir($id);
		
	}
	//echo "<script language= 'javascript'>alert('".$E_ITEM_EXCLUIDO_COM_SUCESSO."')</script>";	
	echo "<script language='javascript'>location.href='cons".$NOMETABELA.".php?res=E'</script>";

       
}

?>