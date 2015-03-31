<?php @session_start();


class Tesouraria
{
  var $conn;
  
  var $id;
 
	function listaTipoEntrada($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select * from tipo_entrada ";
	   	$sql.=" order by 1 ";
		$res = mysql_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Tipo Entrada</option>";
		while ($row = mysql_fetch_array($res))
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
	print <"pre">;
	print "TESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTE";
	print "TESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTE";
	print "TESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTETESTE";
	exit;
	   	$sql = "SELECT * FROM  tipo_saida  ";
	   	$sql.=" order by 1 ";
		$res = mysql_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Tipo Saída</option>";
		while ($row = mysql_fetch_array($res))
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
		$id_tipo	= $this->id_tipo;	
		$id_pessoa	= $this->id;	
		$desc_entrada	= $this->desc_entrada;
		$valor_entrada	= $this->valor_entrada;
		$data_entrada	= $this->data_entrada;	
		
		$criado_por = $this->criado_por;
	print_r ($_REQUEST);
	exit;
 		$sql = "INSERT INTO `u618836331_deus`.`tes_entrada` (`id_tipo`, `desc_entrada`,
				`valor_entrada`, `data_entrada`, `criado_por`, `data_criacao`, `id_pessoa`)
				VALUES ('$id_tipo', '$desc_entrada', '$valor_entrada', '$data_entrada', '$criado_por', now(), '$id_pessoa' )
				 ";
		
		//print $sql;
		//exit;
		$resultado = mysql_query($sql);
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
  		$sql = "update tb_pessoa set 
		id = '".$this->id."', 
		nome = UPPER('".$this->nome."'),
		data_nas = '".$this->data_nas."',
		id_sexo = '".$this->id_sexo."',
		id_estado_civil = '".$this->id_estado_civil."',
		id_escolaridade = '".$this->id_escolaridade."',
		cpf = '".$this->cpf."',
		rg = '".$this->rg."',
		origem = UPPER('".$this->origem."'),
		id_cargo = '".$this->id_cargo."',
		id_igreja = '".$this->id_igreja."',
		data_bat = '".$this->data_bat."',
		data_bat_esp = '".$this->data_bat_esp."',
		nascionalidade = UPPER('".$this->nascionalidade."'),
		naturalidade = UPPER('".$this->naturalidade."'),
		profissao = '".$this->profissao."',
		telefone = '".$this->telefone."',
		celular = '".$this->celular."',
		email = LOWER('".$this->email."'),
		rua = UPPER('".$this->rua."'),
		numero = '".$this->numero."',
		bairro = UPPER('".$this->bairro."'),
		cidade = UPPER('".$this->cidade."'),
		cep = '".$this->cep."',
		uf = '".$this->uf."',
		nome_pai = UPPER('".$this->nome_pai."'),
		nome_mae = UPPER('".$this->nome_mae."'),
		conjuge = UPPER('".$this->conjuge."'),
		n_filhos = '".$this->n_filhos."',
		id_recebimento = '".$this->id_recebimento."',
		data_rec = '".$this->data_rec."',
		igreja_ant = '".$this->igreja_ant."',
		id_cargo_ant = '".$this->id_cargo_ant."',
		tempo_cargo = '".$this->tempo_cargo."',
		obs = UPPER('".$this->obs."'),
		criado_por = '".$this->criado_por."',
		data_criacao =  now()
		where id='".$id."' ";
		
		//print $sql;
		//exit;
	  
	   $resultado = mysql_query($sql);
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
	$idcheck = $_REQUEST['idcheck'];
	
		foreach ($idcheck as $idcheck=>$value) {
			$sql = "delete from tb_pessoa where id= $value ";
			//print $sql;
			//exit;
			$resultado = mysql_query($sql);
           
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
		   	$this->id = $row['id'];
		   	$this->nome = $row['nome'];
		   	$this->data_nas = $row['data_nas'];
		   	$this->id_sexo = $row['id_sexo'];
		   	$this->id_estado_civil = $row['id_estado_civil'];
		   	$this->id_escolaridade = $row['id_escolaridade'];
		   	$this->cpf = $row['cpf'];
		   	$this->rg = $row['rg'];
		   	$this->origem = $row['origem'];
		   	$this->id_cargo = $row['id_cargo'];
		   	$this->id_igreja = $row['id_igreja'];
		   	$this->data_bat = $row['data_bat'];
		   	$this->data_bat_esp = $row['data_bat_esp'];
		   	$this->nascionalidade = $row['nascionalidade'];
		   	$this->naturalidade = $row['naturalidade'];
		   	$this->profissao = $row['profissao'];
		   	$this->telefone = $row['telefone'];
		   	$this->celular = $row['celular'];
		   	$this->email = $row['email'];
		   	$this->rua = $row['rua'];
		   	$this->numero = $row['numero'];
		   	$this->bairro = $row['bairro'];
		   	$this->cidade = $row['cidade'];
		   	$this->cep = $row['cep'];
		   	$this->uf = $row['uf'];
		   	$this->complemento = $row['complemento'];
		   	$this->nome_pai = $row['nome_pai'];
		   	$this->nome_mae = $row['nome_mae'];
		   	$this->conjuge = $row['conjuge'];
		   	$this->n_filhos = $row['n_filhos'];
		   	$this->id_recebimento = $row['id_recebimento'];
		   	$this->data_rec = $row['data_rec'];
		   	$this->igreja_ant = $row['igreja_ant'];
		   	$this->id_cargo_ant = $row['id_cargo_ant'];
		   	$this->tempo_cargo = $row['tempo_cargo'];
		   	$this->obs = $row['obs'];
			
			//print $row['nome'];
			//exit;
			
	}
	
	
		function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from tb_pessoa where id = '.$id;
		//print $sql;
		$result = mysql_query($sql);
		if (mysql_num_rows($result)>0){
	    	$row = mysql_fetch_array($result);
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