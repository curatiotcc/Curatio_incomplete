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
	$nomedep = $_GET['nomedep'];
	$datnasc = $_GET['datnasc'];
	$sexdep = $_GET['sexdep'];
	$fp = fopen("registro.txt","wt");
	$escreve = fwrite($fp,$email);
	fclose($fp);

	try {
		
		$conecta = new PDO("mysql:host=$servidor;dbname=$banco", $usuario , $senha);
		$inserir = $conecta->prepare('INSERT INTO tb08_dependentes
(tb08_emailLogin, tb08_nome_dependente, tb08_dataNascimento_dependente, tb08_sexo_dependente) VALUES ("' . $email . '","'. $nomedep .'","'. $datnasc .'","'. $sexdep .'")');
		$inserir->execute(array());
  }
 catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage(); // opcional, apenas para teste
}
?>