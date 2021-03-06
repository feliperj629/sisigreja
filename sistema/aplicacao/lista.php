<?php 
session_start();

require("../include/seguranca.php");
require_once('../classes/cadastro.class.php');
require_once('../classes/banco.class.php');


   $clConexao = new Conexao;
   $conn = $clConexao->conecta();
   
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">

	<title>Listar Membros</title>
	<link rel="stylesheet" type="text/css" href="../tabela/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="../tabela/css/shCore.css">
	<link rel="stylesheet" type="text/css" href="../tabela/css/demo.css">
	<style type="text/css" class="init">

	th, td { white-space: nowrap; }
	div.dataTables_wrapper {
		width: 1000px;
		margin: 0 auto;
	}

	</style>
	<script type="text/javascript" language="javascript" src="../tabela/js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="../tabela/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="../tabela/js/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="../tabela/js/demo.js"></script>
	<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {
	$('#example').dataTable( {
		"scrollX": true
	} );
} );

	</script>
</head>


<body class="dt-example">
 <?php
	//query SQL
	$strSQL = "SELECT pessoa.*,escolaridade.escolaridade as escolaridade, estadocivil.estadocivil as estadocivil,  igreja.igreja as igreja,
	sexo.sexo as sexo, cargo.cargo as cargos, recebimento.recebimento as recebimento, c2.cargo as cargo_anterior, usuario.nomeusuario as usuario
	FROM pessoa
	left join escolaridade on pessoa.idescolaridade = escolaridade.idescolaridade
	left join estadocivil on pessoa.idestadocivil = estadocivil.idestadocivil
	left join igreja on pessoa.idigreja = igreja.idigreja
	left join sexo on pessoa.idsexo = sexo.idsexo
	left join cargo on pessoa.idcargo = cargo.idcargo
	left join recebimento on pessoa.idrecebimento = recebimento.idrecebimento
	left join cargo c2 on pessoa.idcargoant = c2.idcargo
	left join usuario on pessoa.criadopor = usuario.idusuario
	order by 1
	";
	 //print $strSQL;
	// Executa a query (o recordset $rs cont�m o resultado da query)
	$rs = pg_query($strSQL);
	//print $rs;
	?>
	<div class="container">
		<section>
			<h1>Membros <span>Cadastrados</span></h1>
			<table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Id</th>
						<th>Nome</th>
						<th>Data de nascimento</th>
						<th>Sexo</th>
						<th>Estado Civil</th>
						<th>Escolaridade</th>
						<th>CPF</th>
						<th>RG</th>
						<th>Origem</th>
						<th>Cargo</th>
						<th>Igreja</th>
						<th>Data Batismo</th>
						<th>Data Batismo Esp</th>
						<th>Nascionalidade</th>
						<th>Naturalidade</th>
						<th>profissão</th>
						<th>Telefone</th>
						<th>Celular</th>
						<th>E-mail</th>
						<th>Rua</th>
						<th>Nº</th>
						<th>Bairro</th>
						<th>Cidade</th>
						<th>CEP</th>
						<th>UF</th>
						<th>Complemento</th>			
						<th>Nome do Pai</th>
						<th>Nome da Mãe</th>
						<th>Conjuge</th>
						<th>NºFilhos</th>
						<th>Recebimento</th>
						<th>Data Recebimento</th>
						<th>Igreja Anterior</th>
						<th>Cargo Anterior</th>
						<th>tempo_cargo</th>
						<th>Obs</th>
						<th>criado_por</th>
						<th>data_criacao</th>
					</tr>
				</thead>

				<tbody>
				<?php 
	  // Loop pelo recordset $rs
	// Cada linha vai para um array ($row) usando pg_fetch_array
	while($row = pg_fetch_array($rs)) {
	
	$nome_estado = strtoupper($row['estadocivil']);
	$nome_escolaridade = strtoupper($row['escolaridade']);
	$nome_igreja =  $row['igreja'];
	$nome_sexo = $row['sexo'];
	$nome_cargos = $row['cargos'];
	$nome_cargos_ant = $row['cargo_anterior'];
	$nome_recebimento = $row['recebimento'];
	$usuario = $row['usuario'];
	
	$data_nas = date('d/m/Y',strtotime($row['data_nas']));
	$data_bat = date('d/m/Y',strtotime($row['data_bat']));
	$data_bat_esp = date('d/m/Y',strtotime($row['data_bat_esp']));
	$data_rec = date('d/m/Y',strtotime($row['datarec']));
			
	$data_criacao = date('d/m/Y H:i:s', strtotime($row['datacriacao']));
	
		
	?>	
				
					<tr>
							<td><input type="checkbox" value="<?php print $row; ?>" name="marcar[]" /></td>
							<td><?php print $row[0] ?></td>
							<td><a href="cadastro.php?op=A&id=<?php echo $row['0']; ?>">  <?php print $row[1] ?></a></td>
							<td><?php print $data_nas; ?></td>
							<td><?php print $nome_sexo; ?></td>
							<td><?php print $nome_estado; ?></td>			
							<td><?php print $nome_escolaridade; ?></td>
							<td><?php print $row[6] ?></td>
							<td><?php print $row[7] ?></td>
							<td><?php print $row[8] ?></td>
							<td><?php print $nome_cargos; ?></td>
							<td><?php print $nome_igreja;   ?></td>
							<td><?php print $data_bat; ?></td>
							<td><?php print $data_bat_esp; ?></td>
							<td><?php print $row[13] ?></td>
							<td><?php print $row[14] ?></td>
							<td><?php print $row[15] ?></td>
							<td><?php print $row[16] ?></td>
							<td><?php print $row[17] ?></td>
							<td><?php print $row[18] ?></td>
							<td><?php print $row[19] ?></td>
							<td><?php print $row[20] ?></td>
							<td><?php print $row[21] ?></td>
							<td><?php print $row[22] ?></td>
							<td><?php print $row[23] ?></td>
							<td><?php print $row[24] ?></td>
							<td><?php print $row[25] ?></td>			
							<td><?php print $row[26] ?></td>
							<td><?php print $row[27] ?></td>
							<td><?php print $row[28] ?></td>
							<td><?php print $row[29] ?></td>
							<td><?php print $nome_recebimento; ?></td>
							<td><?php print $data_rec; ?></td>
							<td><?php print $row[32] ?></td>
							<td><?php print $nome_cargos_ant; ?></td>
							<td><?php print $row[34] ?></td>
							<td><?php print $row[35] ?></td>
							<td><?php print $usuario; ?></td>
							<td><?php print $data_criacao; ?></td>
					</tr>
					
				<?php
					  }
					// Encerra a conex�o
					pg_close();
				?>
					
				
					
					
				</tbody>
			</table>

		
</body>
</html>