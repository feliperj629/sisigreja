<?php @session_start();

//error_reporting(E_ALL);
//ini_set('display_errors','1');
class Trimestre
{
	var $conn;
	var $idtrimestre;
	var $trimestre;
	var $conteudo;
	var $datainicio;
	var $datafim;
	var $ano;
  
	public function incluir()
	{
 		$sql = "insert into trimestre (trimestre,conteudo,datainicio,datafim,ano) values ('".$this->trimestre."','".$this->conteudo."','".$this->datainicio."','".$this->datafim."','".$this->ano."')";
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

  	  $sql = "update trimestre set
	  trimestre = '".$this->trimestre."',
	  conteudo = '".$this->conteudo."',
	  datainicio = '".$this->datainicio."',
	  datafim = '".$this->datafim."',
	  ano = '".$this->ano."'
	  where idtrimestre='".$id."' ";
		//echo $sql;
		
		
	  $resultado = pg_exec($this->conn,$sql);
	  //exit;
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

		$sql = "delete from trimestre where idtrimestre = '".$id."' ";
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

			$this->idtrimestre = $row['idtrimestre'];
		   	$this->trimestre= $row['trimestre'];
		   	$this->conteudo= $row['conteudo'];
		   	$this->datainicio= $row['datainicio'];
		   	$this->datafim= $row['datafim'];
		   	$this->ano= $row['ano'];
	}



	public function listaCombo($nomecombo,$id,$refresh,$classes)
	{
 	$sql = "select * from trimestre order by ano desc, trimestre desc ";
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 300px;' ".$classes.">";
		$html .= "<option value=''>Selecione o trimestre</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idtrimestre'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idtrimestre']."' ".$s." >".$row['trimestre']." - ".$row['ano']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from trimestre where idtrimestre = '.$id;
		
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