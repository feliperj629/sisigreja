<?php @session_start();


class Aluno
{

	var $conn;  
	var $id;
	var $idaluno;
	var $aluno;
 	var $telaluno;
 	var $emailaluno;
 	var $obsaluno;
 	var $criadopor;
 
	function listaCombo($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select * from aluno ";
	   	$sql.=" order by 1 ";
		$res = pg_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''> Selecione um aluno </option>";
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
		
		$sql = "INSERT INTO aluno (aluno, telaluno, email, obsaluno, criadopor)
		values (
				'".$this->aluno."',
				'".$this->telaluno."',
				'".$this->emailaluno."',
				'".$this->obsaluno."',
				'".$this->criadopor."'
				)";
		
		print $sql;
		exit;
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
		
  		$sql = "update aluno set 
				aluno = '".$this->aluno."',
				telaluno = '".$this->telaluno."',
				email = '".$this->emailaluno."',
				obsaluno = '".$this->obsaluno."',
				criadopor = '".$this->criadopor."'
				where idaluno ='".$id."' ";
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
			$sql = "delete from aluno where idaluno = $value ";
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
		   	$this->idaluno = $row['idaluno'];
		   	$this->aluno = $row['aluno'];
			$this->telaluno = $row['telaluno'];
		   	$this->obsaluno = $row['obsaluno'];
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
	   	$sql = 'select * from aluno 
				where  idaluno =' .$id;
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