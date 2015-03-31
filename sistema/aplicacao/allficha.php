<?php session_start();
require("../include/seguranca.php");
require_once('../classes/relatorio.class.php');
require_once('../classes/banco.class.php');

$clConexao = new Conexao;
$conn = $clConexao->conecta();

$pdf = new Relatorio('L');

$pdf->nomefonte = 'Arial';
$pdf->tamanhofonte = '8';
$pdf->orientacao = 'L';
$pdf->borda = '1';
$pdf->titulo = 'Carteirinhas ';
$pdf->descricao="";
//print_r ($_SESSION);
//exit;
$id_igreja = $_SESSION['id_igreja'];
/*
if($id_igreja == 3){
$id_igreja = 1;
}
*/
$pdf->AliasNbPages();
	
	$pdf->montaCabeca('');

	//$sql = "SELECT * FROM tb_pessoa where id_igreja = ".$id_igreja." order by 1";
	$sql = "SELECT pessoa.idpessoa, pessoa.nome, pessoa.idcargo, pessoa.idrecebimento, pessoa.datanas, pessoa.databat, pessoa.naturalidade,
pessoa.idestadocivil, pessoa.cpf, pessoa.rg, pessoa.idigreja, pessoa.datarec,  igreja.igreja as igreja, cargo.cargo as cargos, estadocivil.estadocivil,
 pessoa.ativo 
FROM pessoa	
left join igreja on pessoa.idigreja = igreja.idigreja	
left join cargo on pessoa.idcargo = cargo.idcargo	
left join estadocivil on pessoa.idestadocivil = estadocivil.idestadocivil	
order by 1 ";
	

	$pdf->SetFont('Arial','B',10);
	$pdf->SetWidths(array(15,75,30,20,20,20,30,25,25,25));
	$pdf->SetAligns(array("C","L","C","C","C","C","C","C","C","C"));
	
	$pdf->Row(array('Cod','Nome','Cargo','Data Rec','Nasc.','Batismo','Natural','E.Civil','CPF','RG'),'N');
	$pdf->SetFont('Arial','',8);

	$res = pg_query($sql);
	
	
	
	
	while ($row = pg_fetch_array($res))
	{	
		if($row[ativo]==0){
		$pdf->SetTextColor(255,0,0);
		}
		else{$pdf->SetTextColor(0,0,0);}
				$data_nas = $row['datanas'];
				if(!empty($data_nas)){
					$DFm = explode("-",$data_nas);
					$data_nas = $DFm[2].'/'.$DFm[1].'/'.$DFm[0];
					
					if($data_nas == 0){
					$data_nas = "";
					}
					}
	
	$data_rec = $row['datarec'];
	if(!empty($data_rec)){
					$DFm = explode("-",$data_rec);
					$data_rec = $DFm[2].'/'.$DFm[1].'/'.$DFm[0];
					if($data_rec == 0){
					$data_rec = "";
					}
					}
					
	$data_bat = $row['databat'];
	if(!empty($data_bat)){
					$DFm = explode("-",$data_bat);
					$data_bat = $DFm[2].'/'.$DFm[1].'/'.$DFm[0];
					if($data_bat == 0){
					$data_bat = "";
					}
					}
					
				
				$cpf = $row['cpf'];
				if($cpf == 0){
					$cpf = "";
					}
				$rg = $row['rg'];
				if($rg == 0){
					$rg = "";
					}
			//Funcao Criar Codigo de membro com CV+4 digitos		
			$cod = "CV".substr('0000',0,4-strlen($row['0'])).$row['0']; 		
				
			$pdf->Row(array(
				utf8_decode($cod),
				utf8_decode(strtoupper($row['nome'])),
				utf8_decode(strtoupper($row['cargos'])),
				utf8_decode($data_rec),
				utf8_decode($data_nas),
				utf8_decode($data_bat),
				utf8_decode(strtoupper($row['naturalidade'])),
				utf8_decode(strtoupper($row['estadocivil'])),
				utf8_decode($cpf),
				utf8_decode($rg),
				/*utf8_decode($row['origem']),
				utf8_decode($row['id_cargo']),
				utf8_decode($row['data_bat']."-".$row['data_bat_esp']),
				utf8_decode($row['naturalidade']),
				utf8_decode($row['profissao']),
				utf8_decode($row['telefone']),
				utf8_decode($row['celular']),
				utf8_decode($row['rua'].$row['numero'].$row['bairro'].$row['cidade'].$row['cep']),
			*/
				),'S');
	
	}
	
	
	
	$pdf->Output();
?>

