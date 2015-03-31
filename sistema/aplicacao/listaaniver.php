<?php session_start();
require("../include/seguranca.php");
require_once('../classes/relatorio.class.php');
require_once('../classes/banco.class.php');

$clConexao = new Conexao;
$conn = $clConexao->conecta();

$pdf = new Relatorio('P');

$pdf->nomefonte = 'Arial';
$pdf->tamanhofonte = '8';
$pdf->orientacao = 'P';
$pdf->borda = '1';
$pdf->titulo = 'Lista de Aviversariantes ';
$pdf->descricao="";
//print_r ($_SESSION);
//exit;
$id_igreja = $_SESSION['id_igreja'];

if($id_igreja == 3){
$id_igreja = 1;
}

$pdf->AliasNbPages();
	
	$pdf->montaCabeca('');

	//$sql = "SELECT * FROM tb_pessoa where id_igreja = ".$id_igreja." order by 1";
	$sql = "
select c.cargo, nome, datanas, p.celular ,p.telefone ,p.email from pessoa p
inner join cargo c on c.idcargo = p.idcargo
where idigreja = ".$id_igreja." 
order by
  extract(month from p.datanas),
  extract(day from   p.datanas), c.idcargo, p.nome ";
	//print $sql;

	$pdf->SetFont('Arial','B',10);
	$pdf->SetWidths(array(28,60,25,30,46));
	$pdf->SetAligns(array("C","L","C","C","C","C","C","C","C","C"));
	
	$pdf->Row(array('Cargo','Nome','Data Nascimento','Telefones','Email'),'N');
	$pdf->SetFont('Arial','',8);

	$res = pg_query($sql);
	
	
	
	
	while ($row = pg_fetch_array($res))
	{	
		$data_cor = date('m',strtotime($row['datanas']));
		if($data_cor % 2 == 0){
		$pdf->SetTextColor(255,0,0);
		}
		else{$pdf->SetTextColor(0,0,0);}
		
			$data_nas = date('d/m/Y',strtotime($row['datanas']));
				
			$pdf->Row(array(
				
				utf8_decode(strtoupper($row['cargo'])),
				utf8_decode(strtoupper($row['nome'])),
				$data_nas,
				$row['telefone'] .' '. $row['celular'],
				$row['email']
				
				),'S');
	
	}
	
	
	
	$pdf->Output();
?>

