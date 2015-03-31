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
	var $id_igreja_usuario;
	var $id_tipo_acesso;
 
	function listaUsuario($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "select * from tb_usuario ";
	   	$sql.=" order by 1 ";
		$res = mysql_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''> Nome </option>";
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
	
	
	function listaPerfil($nomecombo,$id,$refresh,$classes)
	{
	   	$sql = "SELECT * FROM tb_acesso";
	   	$sql.=" ORDER BY 2 ";
		$res = mysql_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''> Escolha o tipo de perfil </option>";
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
	
	function listaIgreja($nomecombo,$id,$refresh,$classes)
	{
		$sql = "select * from igreja";
	   	$sql.=" order by 1 ";
		$res = mysql_query($sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s." ".$classes.">";
		$html.="<option value = ''>Escolha a Igreja</option>";
		while ($row = mysql_fetch_array($res))
		{
			$s = '';
			if ($id == $row['id_igreja'])
			{
			   $s = "selected";
			}
				$html.="<option value='".$row['id_igreja']."' ".$s." >".$row['igreja']." </option> ";
	        	
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
		
		$id_tipo_acesso	= $this->id_tipo_acesso;	
		$id_igreja_usuario	= $this->id_igreja_usuario;	
		

 		$sql = "INSERT INTO tb_usuario set 
				nome_usuario = '".$this->nome."',
				login = '".$this->login."',
				senha = '".md5($this->senha)."',
				telefone = '".$this->telefone."',
				celular = '".$this->celular."',
				email = '".$this->email."',
				where id_usuario='".$id."' ";
		
		print $sql;
		exit;
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
  		$sql = "update tb_usuario set 
				nome_usuario = '".$this->nome."',
				login = '".$this->login."',
				senha = '".$this->senha."',
				telefone = '".$this->telefone."',
				id_tipo_acesso = '".$this->id_tipo_acesso."',
				celular = '".$this->celular."',
				email = '".$this->email."'
				where id_usuario='".$id."' ";
		print $this->id_igreja_usuario;
		exit;
		$resultado1 = mysql_query($sql);
		
		
	   if((!empty($id)) && (!empty($this->id_igreja_usuario))){
			$sql = "update igreja_usuario set 
				id_igreja_usuario = '".$this->id_igreja_usuario."'			
				where usuario='".$id."' ";
		print $sql;
		exit;
		$resultado = mysql_query($sql);
	   }
	   echo "ainda nao";
	   exit;
	   
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
			$sql = "delete from tb_usuario where id= $value ";
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
		   	$this->id_usuario = $row['id_usuario'];
		   	$this->nome_usuario = $row['nome_usuario'];
			$this->login = $row['login'];
		   	$this->senha = $row['senha'];
		   	$this->telefone = $row['telefone'];
		   	$this->celular = $row['celular'];
		   	$this->email = $row['email'];
		   	$this->id_tipo_acesso = $row['id_tipo_acesso'];
		   	$this->id_igreja_usuario = $row['id_igreja_usuario'];
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
	   	$sql = 'select * from tb_usuario u,igreja_usuario iu,igreja i 		
		where iu.usuario = u.id_usuario
		and	i.id_igreja = iu.id_igreja_usuario	
		and id_usuario =' .$id;
		//print $sql;
		//exit;
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