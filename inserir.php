<?php
	/* prepara o documento para comunicação com o JSON, as duas linhas a seguir são obrigatórias 
	  para que o PHP saiba que irá se comunicar com o JSON, elas sempre devem estar no ínicio da página */
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=utf-8"); 
?>
<?php

// Dados do servidor da Hostinger 

	$servidor = 'mysql.hostinger.com.br';
	$usuario  = 'u880088757_crtbd';
	$senha    = 'etec@147';
	$banco    = 'u880088757_crtbd';
	$email = $_GET['email'];
	$key = $_GET['senha'];
	$nome = $_GET['nome'];
	$erro;
	$fp = fopen("registro.txt","wt");
	$escreve = fwrite($fp,$email);
	fclose($fp);

	try {
		
		$conecta = new PDO("mysql:host=$servidor;dbname=$banco", $usuario , $senha);
		$consulta = $conecta->prepare('SELECT * FROM tb01_usuario where tb01_emailLogin = "' . $email . '"');
		$consulta->execute(array());
		$resultadoDaConsulta = $consulta->fetchAll();

		$StringJson = "[";

		if ( count($resultadoDaConsulta) ) {
 		$erro = "true";
		$StringJson .= '{"error":"' . $erro . '"}';
  		echo $StringJson . "]";
  }else{
  	$erro = "false";
		$StringJson .= '{"error":"' . $erro . '"}';
  		echo $StringJson . "]";
	
  	$inserir = $conecta->prepare('INSERT INTO tb01_usuario(tb01_emailLogin, tb01_tipo, tb01_senha, tb01_nome) VALUES ("' . $email . '",1,"'. $key .'","'. $nome .'")');
	$inserir->execute(array());
  }
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage(); // opcional, apenas para teste
}
?>