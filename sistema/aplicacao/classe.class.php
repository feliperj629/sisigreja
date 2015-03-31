<?php @session_start();
class Classe
{
	var $conn;
	var $idclasse;
	var $classe;
	var $siglaclasse;
  
	public function incluir()
	{
 		$sql = "insert into classe (classe,siglaclasse) values ('".$this->classe."','".$this->siglaclasse."')";

		$resultado = pg_exec($this->conn,$sql);

       	if ($resultado){
	    	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}

	public function alterar($id)
	{

  	  $sql = "update classe set classe = '".$this->classe."',siglaclasse = '".$this->siglaclasse."' where idclasse='".$id."' ";
	   //echo $sql;
	   $resultado = @pg_exec($this->conn,$sql);
       if ($resultado){
	      return true;
	   }
	   else
	   {
	      return false;
	   }
	}

	public function excluir($id)
	{

		$sql = "delete from classe where idclasse = '".$id."' ";
	   	$resultado = @pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}

	private function getDados($row)
	{

			 	$this->idclasse = $row['idclasse'];
		   	$this->classe= $row['classe'];
		   	$this->siglaclasse= $row['siglaclasse'];
	}



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
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from classe where idclasse = '.$id;
		
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