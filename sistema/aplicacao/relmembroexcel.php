<?php
$NOMEFUNCAO = 'Relatorio de Membros';
$NOMERELATORIO = 'relmembro';

require("../include/seguranca.php");
require_once('../classes/relatorio.class.php');
require_once('../classes/banco.class.php');

/*
require_once('classes/conexao.class.php');
require_once('classes/cadeiaprodutiva.class.php');
*/

$clConexao = new Conexao;
$conn = $clConexao->conecta();

//$idcadeiaprodutiva = $_REQUEST['idcadeiaprodutiva'];
/*
$CadeiaProdutiva = new CadeiaProdutiva();
$CadeiaProdutiva->conn = $conn;
$CadeiaProdutiva->getById($idcadeiaprodutiva);
*/
//$cadeiaprodutiva = $CadeiaProdutiva->cadeiaprodutiva;

$NOMERELATORIO = 'carteira'.$cadeiaprodutiva;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$NOMERELATORIO.'.xlsx"');
header('Cache-Control: max-age=0');


$sql = "SELECT pessoa.idpessoa, pessoa.nome, pessoa.idcargo, pessoa.idrecebimento, pessoa.datanas, pessoa.databat, pessoa.naturalidade,
pessoa.idestadocivil, pessoa.cpf, pessoa.rg, pessoa.idigreja, pessoa.datarec,  igreja.igreja as igreja, cargo.cargo as cargos, estadocivil.estadocivil 
FROM pessoa	
left join igreja on pessoa.idigreja = igreja.idigreja	
left join cargo on pessoa.idcargo = cargo.idcargo	
left join estadocivil on pessoa.idestadocivil = estadocivil.idestadocivil	
order by 1 ";

$res = pg_query($sql);
//echo $sql;
//exit;

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
//date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once '../PHPExcel_1.8.0/Classes/PHPExcel.php';


// Create new PHPExcel object
//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
//echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Ministério Chama Viva")
							 ->setLastModifiedBy("Igreja")
							 ->setTitle($NOMEFUNCAO)
							 ->setSubject($NOMEFUNCAO)
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory("");

// Add some data
//echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->getActiveSheet()->setTitle($NOMEFUNCAO);
$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','NOME');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1',utf8_encode('FUNÇÃO'));
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','MEMBRO DESDE');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','DATA NASCIMENTO');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','REGISTRO Nº');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','CONGREGAÇÃO');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','BATISMO');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','NATURALIDADE');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1','ESTADO CIVIL');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1','RG');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1','CPF');
$c=1;

while ($row = pg_fetch_array($res))
{
//print_r ($row); 
//exit;
$cod = "CV".substr('0000',0,4-strlen($row['idpessoa'])).$row['idpessoa']; 		

$data_n = $row['datanas'];			
			$data_nas = implode("/",array_reverse(explode("-",$data_n)));
			if($data_nas == 0){
			$data_nas = "";
			}	
			$data_r = $row['datarec'];			
			$data_rec = implode("/",array_reverse(explode("-",$data_r)));
			if($data_rec == 0){
			$data_rec = "";
			}	
			$data_b = $row['databat'];			
			$data_bat = implode("/",array_reverse(explode("-",$data_b)));
			if($data_bat == 0){
			$data_bat = "";
			}
	$cadeiaprodutiva = $row[1];
	$cel_A = 'A'.($c+1);
	$cel_B = 'B'.($c+1);
	$cel_C = 'C'.($c+1);
	$cel_D = 'D'.($c+1);
	$cel_E = 'E'.($c+1);
	$cel_F = 'F'.($c+1);
	$cel_G = 'G'.($c+1);
	$cel_H = 'H'.($c+1);
	$cel_I = 'I'.($c+1);
	$cel_J = 'J'.($c+1);
	$cel_K = 'K'.($c+1);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_A,' '.$row['nome']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_B,' '.$row['cargos']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_C,' '.$data_rec);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_D,' '.$data_nas);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_E,' '.$cod);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_F,' '.$row['igreja']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_G,' '.$data_bat);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_H,' '.$row['naturalidade']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_I,' '.$row['estadocivil']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_J,' '.$row['rg']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel_K,' '.$row['cpf']);

	$c++;
}
$titulo = $cadeiaprodutiva;
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setTitle($titulo);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('php://output');

?>