<?php @session_start();


class Cadastro
{
  var $conn;
  
  var $id;
  var $nome;
  var $data_nas;
  var $id_sexo;
  var $id_estado_civil;
  var $id_escolaridade;
  var $cpf;
  var $rg;
  var $origem;
  var $id_cargo;
  var $id_igreja;
  var $data_bat;
  var $data_bat_esp;
  var $nascionalidade;
  var $naturalidade;
  var $profissao;
  var $telefone;
  var $celular;
  var $email;
  var $rua;
  var $numero;
  var $bairro;
  var $cidade;
  var $cep;
  var $uf;
  var $complemento;
  var $nome_pai;
  var $nome_mae;
  var $conjuge;
  var $n_filhos;
  var $id_recebimento;
  var $data_rec;
  var $igreja_ant;
  var $id_cargo_ant;
  var $tempo_cargo;
  var $obs;
  var $ativo;
  var $criado_por;
  
  
 
 
	function listaSexo($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select * from sexo";
	   	$sql.=" order by 1 ";
		$res = pg_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Selecione o Sexo</option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idsexo'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idsexo']."' ".$s." >".$row['sexo']." </option> ";
	    }

		$html .= '</select>';

		return $html;	
	}
	
	function listaEstadoCivil($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select * from estadocivil";
	   	$sql.=" order by 1 ";
		$res = pg_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Estado Civil</option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idestadocivil'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idestadocivil']."' ".$s." >".$row['estadocivil']." </option> ";
	    }

		$html .= '</select>';

		return $html;	
	}
	
	
	function listaEscolaridade($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select * from escolaridade";
	   	$sql.=" order by 1 ";
		$res = pg_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Escolha a Escolaridade</option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idescolaridade'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idescolaridade']."' ".$s." >".$row['escolaridade']." </option> ";
	    }

		$html .= '</select>';

		return $html;	
	}

	
	
	
	function listaCargo($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select * from cargo";
	   	$sql.=" order by 1 ";
		$res = pg_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Escolha a Cargo</option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idcargo'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idcargo']."' ".$s." >".$row['cargo']." </option> ";
	    }

		$html .= '</select>';

		return $html;	
	}

	
	
	
	function listaIgreja($nomecombo,$id,$refresh,$classes)
	{ 	$sql = "select * from igreja";
		if(!empty($id)){
		$sql.=" where idigreja = ".$id."";
	}
	   	$sql.=" order by 1 ";
		$res = pg_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Escolha a Igreja</option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idigreja'])
			{
			   $s = "selected";
			}
						
			if($row['id_igreja'] != 3){		   
				$html.="<option value='".$row['idigreja']."' ".$s." >".$row['igreja']." </option> ";
	        }		
		}		
		$html .= '</select>';
		return $html;	
	}

	
	
	
	function listaRecebimento($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select * from recebimento";
	   	$sql.=" order by 1 ";
		$res = pg_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Escolha a forma de recebimento</option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idrecebimento'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idrecebimento']."' ".$s." >".$row['recebimento']." </option> ";
	    }

		$html .= '</select>';

		return $html;	
	}
	
	function listaPessoa($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select idpessoa, nome from pessoa ";
	   	$sql.=" order by 2 ";
		$res = pg_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Escolha a Pessoa</option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idpessoa'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idpessoa']."' ".$s." >".$row['nome']." </option> ";
	    }

		$html .= '</select>';

		return $html;	
	}
	
	
	
	
	
	
	//CRUD
	
		function incluir()
	{
		$sql = "INSERT INTO pessoa  (nome,datanas,idsexo,idestadocivil,idescolaridade,cpf,rg,origem,idcargo,idigreja,databat,databatesp,nascionalidade
		,naturalidade,profissao,telefone,celular,email,rua,numero,bairro,cidade,cep,uf,complemento,nomepai,nomemae,conjuge,nfilhos,idrecebimento,datarec,igrejaant
		,idcargoant,ativo,tempocargo,obs,criadopor)
				values ( 
		UPPER('".$this->nome."'),
		".$this->data_nas.",
		'".$this->id_sexo."',
		'".$this->id_estado_civil."',
		'".$this->id_escolaridade."',
		'".$this->cpf."',
		'".$this->rg."',
		UPPER('".$this->origem."'),
		'".$this->id_cargo."',
		'".$this->id_igreja."',
		".$this->data_bat.",
		".$this->data_bat_esp.",
		UPPER('".$this->nascionalidade."'),
		UPPER('".$this->naturalidade."'),
		'".$this->profissao."',
		'".$this->telefone."',
		'".$this->celular."',
		LOWER('".$this->email."'),
		UPPER('".$this->rua."'),
		'".$this->numero."',
		UPPER('".$this->bairro."'),
		UPPER('".$this->cidade."'),
		'".$this->cep."',
		'".$this->uf."',
		UPPER('".$this->complemento."'),
		UPPER('".$this->nome_pai."'),
		UPPER('".$this->nome_mae."'),
		UPPER('".$this->conjuge."'),
		'".$this->n_filhos."',
		'".$this->id_recebimento."',
		".$this->data_rec.",
		'".$this->igreja_ant."',
		'".$this->id_cargo_ant."',
		'".$this->ativo."',
		'".$this->tempo_cargo."',
		UPPER('".$this->obs."'),
		'".$this->criado_por."'
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
	

  		$sql = "update pessoa set 
		idpessoa = '".$this->id."', 
		nome = UPPER('".$this->nome."'),
		datanas = ".$this->data_nas.",
		idsexo = '".$this->id_sexo."',
		idestadocivil = '".$this->id_estado_civil."',
		idescolaridade = '".$this->id_escolaridade."',
		cpf = '".$this->cpf."',
		rg = '".$this->rg."',
		origem = UPPER('".$this->origem."'),
		idcargo = '".$this->id_cargo."',
		idigreja = '".$this->id_igreja."',
		databat = ".$this->data_bat.",
		databatesp = ".$this->data_bat_esp.",
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
		complemento = UPPER('".$this->complemento."'),
		nomepai = UPPER('".$this->nome_pai."'),
		nomemae = UPPER('".$this->nome_mae."'),
		conjuge = UPPER('".$this->conjuge."'),
		nfilhos = '".$this->n_filhos."',
		idrecebimento = '".$this->id_recebimento."',
		datarec = ".$this->data_rec.",
		igrejaant = '".$this->igreja_ant."',
		idcargoant = '".$this->id_cargo_ant."',
		ativo = '".$this->ativo."',
		tempocargo = '".$this->tempo_cargo."',
		obs = UPPER('".$this->obs."'),
		criadopor = '".$this->criado_por."',
		datacriacao =  now()
		where idpessoa='".$id."' ";
		
		
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

	function excluir($id)
	{
	$idcheck = $_REQUEST['idcheck'];
	
		foreach ($idcheck as $idcheck=>$value) {
			$sql = "delete from pessoa where idpessoa= $value ";
			print $sql;
			exit;
		$resultado = pg_query($sql);
           
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
	//print "<pre>";
	//print_r ($row);
	//print "</pre>";
		   	$this->id = $row['idpessoa'];
		   	$this->nome = $row['nome'];
		   	$this->data_nas = $row['datanas'];
		   	$this->id_sexo = $row['idsexo'];
		   	$this->id_estado_civil = $row['idestadocivil'];
		   	$this->id_escolaridade = $row['idescolaridade'];
		   	$this->cpf = $row['cpf'];
		   	$this->rg = $row['rg'];
		   	$this->origem = $row['origem'];
		   	$this->id_cargo = $row['idcargo'];
		   	$this->id_igreja = $row['idigreja'];
		   	$this->data_bat = $row['databat'];
		   	$this->data_bat_esp = $row['databatesp'];
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
		   	$this->nome_pai = $row['nomepai'];
		   	$this->nome_mae = $row['nomemae'];
		   	$this->conjuge = $row['conjuge'];
		   	$this->n_filhos = $row['nfilhos'];
		   	$this->id_recebimento = $row['idrecebimento'];
		   	$this->data_rec = $row['datarec'];
		   	$this->igreja_ant = $row['igrejaant'];
		   	$this->id_cargo_ant = $row['idcargoant'];
		   	$this->tempo_cargo = $row['tempocargo'];
		   	$this->obs = $row['obs'];
		   	$this->ativo = $row['ativo'];
			
			//print $row['complemento'];
			//exit;
			
	}
	
	
		function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from pessoa where idpessoa = '.$id;
		//print $sql;
		$result = pg_query($sql);
		if (pg_num_rows($result)>0){
	    	$row = pg_fetch_array($result);
		   	$this->getDados($row);
			//print "<pre>";
			//print_r ($row);
			//print "</pre>";
			
			return 1;
		}
		else
		{
    		return 0;
		}
	}
	
	
}

?>