<?php @session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');
class ClasseLicaoTrimestre
{
	var $conn;
	var $idclasselicaotrimestre;
	var $idclasse;
	var $classe;
	var $siglaclasse;
	var $idlicao;
	var $idtrimestre;
  
	/*public function incluir()
	{
		//$sql = " BEGIN; ";
	
 		$sql = " insert into classe (classe,siglaclasse) values ('".$this->classe."','".$this->siglaclasse."'); ";
		
 		$sql .= " insert into classe_licao_trimestre (idclasse,idlicao,idtrimestre) 
					values ((select currval('classe_idclasse_seq')),'".$this->idlicao."','".$this->idtrimestre."'); ";
						
		//PRINT $sql;
		//exit;
		$resultado = pg_exec($this->conn,$sql);

       	if ($resultado){
	    	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}*/

	public function alterar($id)
	{

  	  $sql = "update classe set classe = '".$this->classe."',siglaclasse = '".$this->siglaclasse."' where idclasse='".$id."' ";
		//echo $sql;
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
/*
	public function excluir($id)
	{

		$sql = "delete from classe where idclasse = '".$id."' ";
		print $sql;
		exit;
	   	$resultado = @pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	*/

	

/*
	public function listaCombo($nomecombo,$id,$refresh,$classes)
	{
 	$sql = "select * from classe order by classe ";
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 300px;'>";
		$html .= "<option value=''>Selecione o classe</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idclasse'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idclasse']."' ".$s." >".$row['classe']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	*/
	
	private function getDados($row)
	{

			$this->idclasselicaotrimestre = $row['idclasse_licao_trimestre'];
			$this->idclasse = $row['idclasse'];
		   	$this->idlicao= $row['idlicao'];
		   	//$this->licao= $row['licao'];
		   	$this->idtrimestre= $row['idtrimestre'];
		   	$this->classe= $row['classe'];
		   	$this->siglaclasse= $row['siglaclasse'];
		   	$this->idtrimestre= $row['idtrimestre'];
		   	
	}

	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select clt.*,c.classe,c.siglaclasse,l.licao,t.trimestre,t.ano from classe_licao_trimestre clt
				INNER JOIN classe c on clt.idclasse = c.idclasse
				INNER JOIN licao l on clt.idlicao = l.idlicao
				INNER JOIN trimestre t on clt.idtrimestre = t.idtrimestre
				where c.idclasse = '.$id;
		$sql .= ' order by trimestre,ano ';
		//print $sql;
		
		$result = pg_exec($this->conn,$sql);
		if (pg_num_rows($result)>0){
	    	$row = pg_fetch_array($result);
		   	$this->getDados($row);
			return 1;
		}
		else
		{
    		return 0;
		}
	}


}

?>