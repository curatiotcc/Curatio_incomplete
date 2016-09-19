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
	$erro;
	$fp = fopen("registro.txt","wt");
	$escreve = fwrite($fp,$email);
	fclose($fp);

	try {
		
		$conecta = new PDO("mysql:host=$servidor;dbname=$banco", $usuario , $senha);
		$consulta = $conecta->prepare('SELECT * FROM tb02_consulta_agendamento WHERE tb02_emailLogin = "' . $email . '"');
		$consulta->execute(array());  
		$resultadoDaConsulta = $consulta->fetchAll();
 
		$StringJson = "[";
 
	if ( count($resultadoDaConsulta) ) {
		foreach($resultadoDaConsulta as $registro) {
 		$erro = "false";
			if ($StringJson != "[") {$StringJson .= ",";}
					$StringJson .= '{"tb02_nome_paciente":"' . $registro[tb02_nome_paciente]  . '",';
					$StringJson .= '"tb02_especialidade":"' . $registro[tb02_especialidade]  . '",';	
					$StringJson .= '"tb02_data":"' . $registro[tb02_data]    . '",';
					$StringJson .= '"tb02_hora":"' . $registro[tb02_hora]    . '",';
					$StringJson .= '"tb02_situacao":"' . $registro[tb02_situacao]    . '",';
					$StringJson .= '"tb02_convenio":"' . $registro[tb02_convenio]    . '",';
					$StringJson .= '"tb02_medico_preferencial":"' . $registro[tb02_medico_preferencial]    . '",';
					$StringJson .= '"error":"' . $erro    . '"}';

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
		