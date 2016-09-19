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
	$erro;
	$erro2;
	$fp = fopen("registro.txt","wt");
	$escreve = fwrite($fp,$email);
	fclose($fp);

	try {
		
		$conecta = new PDO("mysql:host=$servidor;dbname=$banco", $usuario , $senha);
		$consulta = $conecta->prepare('SELECT * FROM tb01_usuario where tb01_emailLogin = "' . $email . '" and tb01_senha = "'. $key .'"');
		$consulta->execute(array());  
		$resultadoDaConsulta = $consulta->fetchAll();
 
		$StringJson = "[";
 
	if ( count($resultadoDaConsulta) ) {
		foreach($resultadoDaConsulta as $registro) {
 		$erro = "false";
			if ($StringJson != "[") {$StringJson .= ",";}
			$StringJson .= '{"tb01_emailLogin":"' . $registro[tb01_emailLogin]  . '",';
			$StringJson .= '"tb01_tipo":"' . $registro[tb01_tipo]  . '",';	
			$StringJson .= '"tb01_senha":"' . $registro[tb01_senha]    . '",';
			$StringJson .= '"error":"' . $erro    . '",';		
			$StringJson .= '"tb01_nome":"' . $registro[tb01_nome] . '"}';			
		}  
		echo $StringJson . "]"; // Exibe o vettor JSON
  }else{
  	$erro = "true";
  	$StringJson .= '{"error":"' . $erro . '"}';
  	echo $StringJson . "]";
  }
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage(); // opcional, apenas para teste
}
?>
		