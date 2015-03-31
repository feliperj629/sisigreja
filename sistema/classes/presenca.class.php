<?php @session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');

class Presenca
{

	var $conn;  
	var $id;
	var $idaula;
 	var $idaluno_classe_licao_trimestre;
 	var $status;
 	var $obs;
	
 
	function listaCombo($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select * from presenca ";
	   	$sql.=" order by 1 ";
		$res = pg_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''> Selecione um presenca </option>";
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
		
		$sql = "INSERT INTO presenca (idaula, idaluno_classe_licao_trimestre, status, obs)
			values (
				'".$this->idaula."',
				'".$this->idaluno_classe_licao_trimestre."',
				'".$this->status."',
				'".$this->obs."'
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

	function alterar($id)
	{				
		$id_igreja_usuario	= $this->id_igreja_usuario;	
		
  		$sql = "update presenca set 
				presenca = '".$this->presenca."',
				telpresenca = '".$this->telpresenca."',
				obspresenca = '".$this->obspresenca."',
				criadopor = '".$this->criadopor."'
				where idpresenca ='".$id."' ";
		print $sql;
		exit;
		$resultado = pg_query($sql);
		if ($resultado){
	      return true;
		}
	}
	
	
	function excluir($id)
	{
	$idcheck = $_REQUEST['idcheck'];
	
		foreach ($idcheck as $idcheck=>$value) {
			$sql = "delete from presenca where idpresenca = $value ";
			print $sql;
			exit;
			//$resultado = pg_query($sql);           
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
		   	$this->id = $row['idpresencao'];
		   	$this->idaula = $row['idaula'];
			$this->idaluno_classe_licao_trimestre = $row['idaluno_classe_licao_trimestre'];
		   	$this->data = $row['data'];
		   	$this->status = $row['status'];
		   	$this->obs = $row['obs'];
		/*
		 	print "<pre>";
			print_r ($row);
			print "</pre>";
			exit;
		*/
			
	}
	
	
function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
$sql = 'select * from presenca 
		where idaula = '.$id;
		print $sql;
		exit;
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
	
	
	
}

?>