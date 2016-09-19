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
	$fp = fopen("registro.txt","wt");
	$escreve = fwrite($fp,$email);
	fclose($fp);

	try {
		
		$conecta = new PDO("mysql:host=$servidor;dbname=$banco", $usuario , $senha);
		$consulta = $conecta->prepare('SELECT * FROM tb08_dependentes WHERE tb08_emailLogin = "' . $email . '"');
		$consulta->execute(array());  
		$resultadoDaConsulta = $consulta->fetchAll();
 
		$StringJson = "[";
 
	if ( count($resultadoDaConsulta) ) {
		foreach($resultadoDaConsulta as $registro) {
 		$erro = "false";
			if ($StringJson != "[") {$StringJson .= ",";}
					$StringJson .= '{"tb08_nome_dependente":"'.$registro[tb08_nome_dependente].'",';
					$StringJson .= '"tb08_dataNascimento_dependente":"' . $registro[tb08_dataNascimento_dependente]  . '",';	
					$StringJson .= '"tb08_sexo_dependente":"'.$registro[tb08_sexo_dependente].'"}';

		}  
		echo $StringJson . "]"; // Exibe o vettor JSON
  }
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage(); // opcional, apenas para teste
}
?>
		