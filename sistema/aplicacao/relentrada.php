<?php session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');


require_once('../classes/relatorio.class.php');
require_once('../classes/banco.class.php');

$clConexao = new Conexao;
$conn = $clConexao->conecta();

$pdf = new Relatorio('P');

$pdf->nomefonte = 'Arial';
$pdf->tamanhofonte = '8';
$pdf->orientacao = 'P';
$pdf->borda = '1';
$pdf->titulo = 'Relatorio de entrada no mês';
$pdf->descricao="";

$pdf->AliasNbPages();
	
	$pdf->montaCabeca('');
	
$sql = "SELECT t.*,te.tipoentrada,p.nome 
FROM movimentacao t 
left join tipoentrada te on te.idtipoentrada = t.idtipoentrada 
left join pessoa p on p.idpessoa = t.idpessoa 
where valorentrada is not null
and status = 1
ORDER BY dataentrada ";

	$pdf->SetFont('Arial','B',10);
	$pdf->SetWidths(array(30,30,50,30,48));
	$pdf->SetAligns(array("L","C","L","R","L"));
	
	$pdf->Row(array('Tipo de Entrada','Data Entrada','Nome ','Valor R$ ','Descrição'),'N');
	$pdf->SetFont('Arial','',8);

	$res = pg_query($sql);	
	$nome_pessoa = "NOME NÃƒO CADASTRADO";
while ($row = pg_fetch_array($res))
{
	$data_ent = $row['dataentrada'];
	if(!empty($data_ent)){
		$DFm = explode("-",$data_ent);
		$data_entrada = $DFm[2].'/'.$DFm[1].'/'.$DFm[0];
	}	
	$tipoentrada =  $row['tipoentrada'];				
				
	$nome_pessoa =  $row['nome'];	
					
			$pdf->Row(array(
				utf8_decode($tipoentrada),
				utf8_decode($data_entrada),
				utf8_decode($nome_pessoa),
				number_format($row['valorentrada'],2,',','.'),
				utf8_decode($row['descentrada']),
				),'S');
	$totalentrada += $row['valorentrada'];
}
	
	$pdf->ln(5);
	/*Saidas Caixa*/
	
	
$sql = "SELECT ts.*,t.tiposaida,p.nome 
FROM movimentacao ts
INNER join tiposaida t on ts.idtiposaida = t.idtiposaida
LEFT join pessoa p on p.idpessoa = ts.idpessoa
where valorsaida is not null
and status = 1
ORDER BY datasaida DESC ";
	
	$pdf->SetFont('Arial','B',10);
	$pdf->SetWidths(array(30,30,60,68));
	$pdf->SetAligns(array("L","C","R","L"));
	
	$pdf->Row(array('Tipo de Saida','Data saida','Valor R$ ','Descrição'),'N');
	$pdf->SetFont('Arial','',8);

	$res = pg_query($sql);
	$c=0;

	while ($row = pg_fetch_array($res))
	{
	
		$data_saida = $row['datasaida'];
				if(!empty($data_saida)){
					$DFm = explode("-",$data_saida);
					$data_saida = $DFm[2].'/'.$DFm[1].'/'.$DFm[0];
					}
					
				$tipo_saida =  $row['tiposaida'];	
		$pdf->Row(array(
				utf8_decode($tipo_saida),
				utf8_decode($data_saida),
				number_format($row['valorsaida'],2,',','.'),
				utf8_decode($row['descsaida']),
				),'S');
				
	$totalsaida += $row['valorsaida'];
	}
	
	$total = $totalentrada - $totalsaida;
	
		
	
	
	$pdf->Output();
?>

