<?php
require_once('../classes/banco.class.php');

function saldo()
{
$_SESSION['sqlentrada'] = $sqlentrada = "SELECT * FROM tes_entrada";
$rsentrada = mysql_query($sqlentrada);
while($row = mysql_fetch_array($rsentrada)) {
	$totalent += $row['valor_entrada'];
}

$_SESSION['sqlsaida'] = $sqlsaida 	= "SELECT * FROM tes_saida";
$rssaida = mysql_query($sqlsaida);
while($row = mysql_fetch_array($rssaida)) {
	$totalsai += $row['valor_saida'];
}
$total = $totalent - $totalsai;


print "</br>";
print "Entrada     : " .number_format($totalent,2,',','.');
print "</br>";
print "Saida        : " .number_format($totalsai,2,',','.');
print "</br>";
print "______________";
print "</br>";
print "Total         : ".number_format($total,2,',','.');

}



?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
		<div align="right" class="alert alert-info" role="alert">
			<h3> <?php print saldo(); ?></h3>
		</div>
	
</body>
</html>