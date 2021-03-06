<?php @session_start();


class Usuario
{
	var $conn;  
	var $id;
	var $nome;
 	var $email;
 	var $telefone;
 	var $celular;
 	var $login; 	
	var $senha;
	var $idigreja;
	var $idtipoacesso;
	var $idigrejausuario;
 
	function listaUsuario($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select * from usuario ";
	   	$sql.=" order by 1 ";
		$res = pg_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''> Nome </option>";
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
	
	
	function listaPerfil($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "SELECT * FROM acesso";
	   	$sql.=" ORDER BY 2 ";
		$res = pg_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''> Escolha o tipo de perfil </option>";
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
	
	function listaIgreja($nomecombo,$id,$refresh,$classes)
	{
		$sql = "select * from igreja";
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
				$html.="<option value='".$row['idigreja']."' ".$s." >".$row['igreja']." </option> ";
	        	
		}

		$html .= '</select>';

		return $html;	
	}
	
	
	
	
	//CRUD

		function incluir()
	{
		
		$login	= $this->login_usuario;
		$senha	= $this->senha_usuario;
		$nome = $this->nome_usuario;
		$telefone = $this->telefone;
		$celular = $this->celular;
		$email = $this->email;
		$criado_por = $this->criado_por;		
		
		//$idtipoacesso	= $this->idtipoacesso;	
		//$idigrejausuario	= $this->idigrejausuario;	
		

 		$sql = "INSERT INTO usuario set 
				nomeusuario = '".$this->nome."',
				login = '".$this->login."',
				senha = '".$this->senha."',
				telefone = '".$this->telefone."',
				celular = '".$this->celular."',
				email = '".$this->email."',
				where id_usuario='".$id."' ";
		
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
		//$idigrejausuario	= $this->idigrejausuario;	
		$sql .= "BEGIN ; ";
		
  		$sql .= " update usuario set 
				nomeusuario = '".$this->nome."',
				login = '".$this->login."',
				senha = '".$this->senha."',
				telefone = '".$this->telefone."',
				idtipoacesso = '".$this->idtipoacesso."',
				celular = '".$this->celular."',
				email = '".$this->email."'
				where idusuario='".$id."'; ";
				
		$sql .= " update igrejahasusuario set 
				idigreja = '".$this->idigrejausuario."'			
				where idusuario='".$id."'; ";			
		
		//print $sql;
		//exit;
		
		$resultado = pg_query($sql);
	
	  
	   
	   if ($resultado){
		$sqlOK = "COMMIT;";	
		//print $sqlOK;
		//exit;
	      $resultadoCOMMIT = pg_query($sqlOK);
			if($resultadoCOMMIT){
				return true;
			}
	   }else{
	   $sqlerro = "ROLLBACK;";
		//print $sqlerro;	
		//exit;		
		
			$resultERRO = pg_query($sqlerro);
			if($resultERRO){
				return false;
			}
	   }
	  

	}

	function excluir($id)
	{
	$idcheck = $_REQUEST['idcheck'];
	
		foreach ($idcheck as $idcheck=>$value) {
			$sql = "delete from usuario where idusuario= $value ";
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
		   	$this->id_usuario = $row['idusuario'];
		   	$this->nome_usuario = $row['nomeusuario'];
			$this->login = $row['login'];
		   	$this->senha = $row['senha'];
		   	$this->telefone = $row['telefone'];
		   	$this->celular = $row['celular'];
		   	$this->email = $row['email'];
		   	$this->id_tipo_acesso = $row['idtipoacesso'];
		   	$this->id_igreja_usuario = $row['idigreja'];
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
	   	$sql = 'select *  from usuario u
				INNER JOIN igrejahasusuario iu on iu.idusuario = u.idusuario
				INNER JOIN igreja i on iu.idigreja = i.idigreja
				where iu.idusuario = ' .$id;
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