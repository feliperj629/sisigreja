<?php @session_start();


class Tesouraria
{
	var $conn;
	var $id;
	
	var $idtipoentrada;	
	var $descentrada;
	var $valorentrada;
	var $dataentrada;	
	
	var $idtiposaida;
	var $descsaida;
	var $valorsaida;
	var $datasaida;
 
	var $criadopor;
	var $idpessoa;
	var $datacriacao;
	
	function listaTipoEntrada($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select * from tipoentrada ";
	   	$sql.=" order by 1 ";
		$res = pg_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Tipo Entrada</option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row[0])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row[0]."' ".$s." >".$row[1]." </option> ";
	    }

		$html .= '</select>';

		return $html;	
	}
	
	function listaTipoSaida($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select * from tiposaida ";
	   	$sql.=" order by 1 ";
		$res = pg_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Tipo Saída</option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row[0])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row[0]."' ".$s." >".$row[1]." </option> ";
	    }

		$html .= '</select>';

		return $html;	
	}
	
	//CRUD

	function incluir()
	{
 		$sql = "INSERT INTO movimentacao (idtipoentrada, descentrada,
				valorentrada, dataentrada, criadopor,  idpessoa,  status)
				VALUES (
				'".$this->idtipoentrada."',
				'".$this->descentrada."',
				'".$this->valorentrada."',
				'".$this->dataentrada."',
				'".$this->criadopor."',
				".$this->idpessoa.",
				1
				)";
		
		//print $sql;
		//exit;
		$resultado = pg_query($sql);
		if ($resultado){
	    	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
		function incluirSaida()
	{

 		$sql = "INSERT INTO movimentacao  (idtiposaida, descsaida, valorsaida, datasaida, criadopor, status ) 
				values ('".$this->idtiposaida."', 
				 '".$this->descsaida."', 
				'".$this->valorsaida."', 
				'".$this->datasaida."', 
				'".$this->criadopor."',
				'1'
				)";
		
		//print $sql;
		//exit;
		$resultado = pg_query($sql);
		if ($resultado){
	    	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}

	}

	function alteraEntrada($id)
	{
		$sql = "update movimentacao  set 
				idtipoentrada = '".$this->idtipoentrada."', 
				descentrada = '".$this->descentrada."', 
				valorentrada = '".$this->valorentrada."', 
				dataentrada = '".$this->dataentrada."', 
				idpessoa = '".$this->idpessoa."', 
				criadopor = '".$this->criadopor."'
				where idmovimentacao= ".$id;
		
		//print $sql;
		//exit;
	  
	   $resultado = pg_query($sql);
	   if ($resultado){
	      return true;
	   }
	   else
	   {
	      return false;
	   }

	}
	
	function alteraSaida($id)
	{
		$sql = "update movimentacao  set 
				idtiposaida = '".$this->idtiposaida."', 
				descsaida = '".$this->descsaida."', 
				valorsaida = '".$this->valorsaida."', 
				datasaida = '".$this->datasaida."', 
				criadopor = '".$this->criadopor."'
				where idmovimentacao='".$id."' ";
		
		//print $sql;
		//exit;
	  
	   $resultado = pg_query($sql);
	   if ($resultado){
	      return true;
	   }
	   else
	   {
	      return false;
	   }
	}

	function alterarexcluir($id)
	{	
		$idcheck = $_REQUEST['idcheckentrada'];
		if(empty($idcheck)){
		$idcheck = $_REQUEST['idchecksaida'];
		}	
		foreach ($idcheck as $idcheck=>$value) {
				$sql = "update movimentacao  set 
				status = 0
				where idmovimentacao = $value ";
				//print $sql;
				//exit;
				$resultado = pg_query($sql);
			}
			if ($resultado){
				return true;
			}
			else
			{
				return false;
			}
	}
	
	function excluir($id)
	{
	$idcheck = $_REQUEST['idcheckentrada'];
		foreach ($idcheck as $idcheck=>$value) {
			$sql = "delete from movimentacao where idmovimentacao = $value ";
			//print $sql;
			//exit;
			$resultado = pg_query($sql);
        }
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
			
	function getDados($row)
	{
		   	$this->id = $row['idmovimentacao'];
		   	$this->idtipoentrada = $row['idtipoentrada'];
		   	$this->descentrada = $row['descentrada'];
		   	$this->valorentrada = $row['valorentrada'];
		   	$this->dataentrada = $row['dataentrada'];
		   	$this->idpessoa = $row['idpessoa'];
			
			$this->idtiposaida = $row['idtiposaida'];
		   	$this->descsaida = $row['descsaida'];
		   	$this->valorsaida = $row['valorsaida'];
		   	$this->datasaida = $row['datasaida'];
		   	$this->status = $row['status'];
					
			//print_r ($row);
			//exit;
			
	}
	
	
		function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from movimentacao where idmovimentacao =' .$id;
		//print $sql;
		//exit;
		$result = pg_query($sql);
		if (pg_num_rows($result)>0){
	    	$row = pg_fetch_array($result);
		   	$this->getDados($row);
			//print "<pre>";
			//print_r ($row);
			//exit;
			return 1;
		}
		else
		{
    		return 0;
		}
	}
	
	
	
	
function saldo()
{
	$sql = "SELECT * FROM movimentacao where status = 1 ";
	$rs = pg_query($sql);
	while($row = pg_fetch_array($rs))
	{
		$totalent += $row['valorentrada'];
		$totalsai += $row['valorsaida'];
	}
	
	$total = $totalent - $totalsai;

	$_SESSION['saldo'] = $total;

	if($total < 0){
		$classdiv = 'alert-danger';
	}else{$classdiv = 'alert-default';}


	$div ='<div class="col-md-offset-7 '.$classdiv.'" align="right"  role="alert">
				<h4> Saldo em Caixa: R$ '.number_format($total,2,",",".").'</h4>
			</div>';

	return $div;
}
	
	
	
}

?>