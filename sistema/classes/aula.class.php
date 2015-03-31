<?php @session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');

class Aula
{

	var $conn;  
	var $id;
	var $conteudo;
 	var $idprofessor;
 	
	/*function listaCombo($nomecombo,$id,$refresh,$classes)
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
	*/
	
		
	//CRUD

		function incluir()
	{
		$sql = "INSERT INTO aula (conteudo, idprofessor)
			VALUES(
				'".$this->conteudo."',
				'".$this->idprofessor."'				
				)";
		
		//print $sql;
		//exit;
		$resultado = pg_query($sql);
		
		$sql2 = "select currval('public.aula_idaula_seq')";
		//print $sql2;
		//exit;
	   $result2 = pg_exec($this->conn,$sql2);
       $row2 = pg_fetch_array($result2);
	 //  print $row2[0];
	   //exit;
		if ($result2){
	    	return $row2[0];
	   	}
	   	else
	   	{
	    	return false;
	   	}

	}

	function alterar($id)
	{				
		
  		$sql = "update aula set 
				conteudo = '".$this->conteudo."',
				idprofessor = '".$this->idprofessor."'
				where idaula ='".$id."' ";
		print $sql;
		exit;
		$resultado = pg_query($sql);
		if ($resultado){
	      return true;
		}
	}
	
	
	/*function excluir($id)
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
	}*/
	
	function getDados($row)
	{
		   	$this->idaula = $row['idaula'];
		   	$this->conteudo = $row['conteudo'];
		   	$this->idprofessor = $row['idprofessor'];
	}
	
	
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from aula where idaula =' .$id;
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
	
	
	
}

?>