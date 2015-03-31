<?php


print_r $_REQUEST;
// Cria uma variável que terá os dados do erro
$erro = false;

// Verifica se o POST tem algum valor
if ( !isset( $_POST ) || empty( $_POST ) ) {
	$erro = 'Nada foi postado.';
}


// Verifica se $email realmente existe e se é um email. 
// Também verifica se não existe nenhum erro anterior
if ( ( ! isset( $emailremetente ) || ! filter_var( $emailremetente, FILTER_VALIDATE_EMAIL ) ) && !$erro ) {
	$erro = 'Envie um email válido.';
}

// Cria as variáveis dinamicamente
foreach ( $_POST as $chave => $valor ) {
	// Remove todas as tags HTML
	// Remove os espaços em branco do valor
	$$chave = trim( strip_tags( $valor ) );
	
	// Verifica se tem algum valor nulo
	if ( empty ( $valor ) ) {
		$erro = 'Existem campos em branco.';
	}
}



// Passando os dados obtidos pelo formulário para as variáveis abaixo
$nomeremetente     = $_POST['nomeremetente'];
$emailremetente    = trim($_POST['emailremetente']);
$emaildestinatario = 'feliperj629@gmail.com'; // Digite seu e-mail aqui, lembrando que o e-mail deve estar em seu servidor web
$telefone      	   = $_POST['telefone'];
$assunto          = $_POST['assunto'];
$mensagem          = $_POST['mensagem'];
 
 
/* Montando a mensagem a ser enviada no corpo do e-mail. */
$mensagemHTML = '<P>FORMULARIO PREENCHIDO NO SITE www.chamaviva.net.br</P>
<p><b>Nome:</b> '.$nomeremetente.'
<p><b>E-Mail:</b> '.$emailremetente.'
<p><b>Telefone:</b> '.$telefone.'
<p><b>Assunto:</b> '.$assunto.'
<p><b>Mensagem:</b> '.$mensagem.'</p>
<hr>';


// O remetente deve ser um e-mail do seu domínio conforme determina a RFC 822.
// O return-path deve ser ser o mesmo e-mail do remetente.
$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: $emailremetente\r\n"; // remetente
$headers .= "Return-Path: $emaildestinatario \r\n"; // return-path
$envio = mail($emaildestinatario, $assunto, $mensagemHTML, $headers); 
 
 if($envio){
      
        echo"<script type='text/javascript'>";

                echo "alert('Enviado com sucesso');";

        echo "</script>";
        echo "<script>location.href='index.php'</script>"; // Página que será redirecionada


        }else{

        echo"<script type='text/javascript'>";

                echo "alert('Atenção, ERRO ao enviar.');";

        echo "</script>";

        }

?>
