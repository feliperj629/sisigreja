<?php @session_start();

//error_reporting(E_ALL);
//ini_set('display_errors','1');
class Licao
{
	var $conn;
	var $idlicao;
	var $licao;
	
	public function incluir()
	{
 		$sql = "insert into licao (licao) values ('".$this->licao."')";
		//print $sql;
		//exit;
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

  	  $sql = "update licao set
	  licao = '".$this->licao."'	 
	  where idlicao='".$id."' ";
	//echo $sql;
	//exit;
    	
		
	  $resultado = pg_exec($this->conn,$sql);
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

		$sql = "delete from licao where idlicao = '".$id."' ";
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

	private function getDados($row)
	{

			$this->idlicao = $row['idlicao'];
		   	$this->licao= $row['licao'];
		 
	}



	public function listaCombo($nomecombo,$id,$refresh,$classes)
	{
 	$sql = "select * from licao order by licao ";
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 300px;' ".$classes." >";
		$html .= "<option value=''>Selecione a lição</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idlicao'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idlicao']."' ".$s." >".$row['licao']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from licao where idlicao = '.$id;
		
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