<?php @session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');

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
 	var $idclasselicaotrimestre;
 	var $idalunoclasselicaotrimestre;
 
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
	
	
	function listaComboDatalist($nomecombo)
	{
	   	$sql = "select * from pessoa ";
	   	$sql.=" order by 1 ";
		$res = pg_query($sql);
			
		$html ='<input class="form-control" type="text" id="txt_'.$nomecombo.'" list="'.$nomecombo.'" />';
		$html.=	'<datalist id="'.$nomecombo.'">';
		while ($row = pg_fetch_array($res))
		{			
		   $html.="<option value='".$row[1]."'> ";
		   
	    }
		$html .= '</datalist>';

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
				);";
		if(!empty($this->idclasselicaotrimestre)){		
		$sql .= "INSERT INTO aluno_classe_licao_trimestre (idaluno, idclasse_licao_trimestre)
		values (
				(select currval('aluno_idaluno_seq')),
				'".$this->idclasselicaotrimestre."'
				);";
		}
		
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

	function alterar($id,$idalunoclasselicaotrimestre)
	{	
		
		
  		$sql = "update aluno set 
				aluno = '".$this->aluno."',
				telaluno = '".$this->telaluno."',
				email = '".$this->emailaluno."',
				obsaluno = '".$this->obsaluno."',
				criadopor = '".$this->criadopor."'
				where idaluno ='".$id."'; ";
				
		$sql .= "update aluno_classe_licao_trimestre set 
				idaluno = '".$this->idaluno."',
				idclasse_licao_trimestre = '".$this->idclasselicaotrimestre."'
				where idaluno_classe_licao_trimestre ='".$idalunoclasselicaotrimestre."' ";
		//print $sql;
		//exit;
		$resultado = pg_query($sql);
		if ($resultado){
	      return true;
		}
	}
	
	
	public function excluir($id)
	{
		
		$sql1 = "select * from aluno_classe_licao_trimestre where idaluno_classe_licao_trimestre = '".$id."' ";
		
		$result = pg_query($sql1);
		if (pg_num_rows($result)>0){
	    	$row = pg_fetch_array($result);		   	
			//print "<pre>";
			//print_r ($row);
			//exit;
			$idalunoclasselicaotrimestre = $row['idaluno_classe_licao_trimestre'];
			$idaluno = $row['idaluno'];
			
			$sql = "delete from aluno_classe_licao_trimestre where idaluno_classe_licao_trimestre = '".$idalunoclasselicaotrimestre."'; ";
			$sql .= " delete from aluno where idaluno = ".$idaluno;
			//print $sql;
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
		
		
	}
	
	function getDados($row)
	{
		   	$this->idaluno = $row['idaluno'];
		   	$this->aluno = $row['aluno'];
			$this->telaluno = $row['telaluno'];
			$this->emailaluno = $row['email'];
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