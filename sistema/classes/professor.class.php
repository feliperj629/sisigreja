<?php @session_start();


class Professor
{

	var $conn;  
	var $id;
	var $idprofessor;
	var $professor;
 	var $telprofessor;
 	var $obsprofessor;
 	var $criadopor;
 
	function listaCombo($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select * from professor ";
	   	$sql.=" order by 1 ";
		$res = pg_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''> Selecione um Professor </option>";
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
		
		$sql = "INSERT INTO professor (professor, telprofessor, obsprofessor, criadopor)
		values (
				'".$this->professor."',
				'".$this->telprofessor."',
				'".$this->obsprofessor."',
				'".$this->criadopor."'
				)";
		
		//print $sql;
		//z'exit;
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
		
  		$sql = "update professor set 
				professor = '".$this->professor."',
				telprofessor = '".$this->telprofessor."',
				obsprofessor = '".$this->obsprofessor."',
				criadopor = '".$this->criadopor."'
				where idprofessor ='".$id."' ";
		//print $sql;
		//exit;
		$resultado = pg_query($sql);
		if ($resultado){
	      return true;
		}
	}
	
	
	public function excluir($id)
	{
		$sql = "delete from professor where idprofessor = '".$id."' ";
	   //	print $sql;
		//exit;
		$resultado = @pg_exec($this->conn,$sql);
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
		   	$this->idprofessor = $row['idprofessor'];
		   	$this->professor = $row['professor'];
			$this->telprofessor = $row['telprofessor'];
		   	$this->obsprofessor = $row['obsprofessor'];
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
	   	$sql = 'select * from professor 
				where  idprofessor =' .$id;
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