<?php include 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Crud com MYSQLI e Formulário </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
<form action="enviar.php" method="POST" enctype="multipart/form-data">
	<fieldset>
		<legend>Cadastro de usuários</legend>

		<?php 
			//ESCONDE MENSAGENS PHP
			ini_set('display_errors', 0 );
			error_reporting(0);

			//VERIFICAÇÃO 
			if($_GET['enviado'] == 'ok'){
				echo 'Usuário cadastrado!';
			}else if($_GET['enviado'] == 'nok'){
				echo 'erro ao cadastrar usuário';
			}else if($_GET['campos'] == 'nok'){
				echo 'Todos os campos devem ser preenchidos';
			}else if($_GET['formatoImg'] == 'nok'){
				echo "Formato de imagem inválido";
			}else if($_GET['enviadoPasta'] == 'nok'){
				echo "Erro ao enviar o arquivo";
			}else if($_GET['tamanhoFoto'] == 'nok'){
				echo 'O tamanho do arquivo enviado é maior que o limite!';
			}else{
				echo '';
			}

		?>
		<br>
		<input type="text" name="nome" placeholder="Nome" /><br>
		<input type="email" name="email" placeholder="E-mail"><br>
		<textarea name="observacao" placeholder="Observação"></textarea><br>
		<input type="file" name="foto" placeholder="Selecione o arquivo" /> <br>
		<button type="submit">Enviar</button>
	</fieldset>
</form>

<hr>

<?php
	//MENSAGEM DELETADO COM SUCESSO
	if($_GET['deletado'] == 'ok'){
		echo 'Deletado com sucesso';
	}else if($_GET['deletado'] == 'nok'){
		echo "Erro ao deletar";
	}else{}

	//MENSAGEM DE ATUALIZADO COM SUCESSO
	if($_GET['atualizado'] == "ok"){ 
	echo "Atualizado com sucesso!";
	}else if($_GET['atualizado'] == "nok"){
		echo "Erro ao atualizar.";
	}else{}
?>

<!-- SELECIONAR DO DB -->
<form action="index.php" method="GET">
	<input type="text" name="input_valor" placeholder="O que você procura?" />
	<button type="submit">Buscar</button>
</form>

<?php
	//PEGANDO VALOR DO CAMPO BUSCA
	$valor = utf8_decode($_GET['input_valor']);
	echo "Você procurou por: <strong>" . utf8_encode($valor) . "</strong><br /><br />";

	//SELECIONAR
	$selecao = "SELECT * FROM tb_usuarios WHERE
	nome LIKE '".$valor."%' OR
	email LIKE '".$valor."%' OR
	observacao LIKE '%".$valor."%' OR
	foto LIKE '".$valor."%' ORDER BY id desc";

	$linhas = mysqli_query($conexao_db, $selecao);
	if($linhas):
		foreach ($linhas as $linha):
			extract($linha);
			echo 'ID: '.$id.'<br>';
			echo 'Nome: '.utf8_encode($nome).'<br>';
			echo 'E-mail: '.utf8_encode($email).'<br>';
			echo 'Obs: '.utf8_encode($observacao).'<br>';
			echo "<img src='fotos/".utf8_encode($foto)."' width='200'><br>";
			echo "<a href='editar_atualizacao.php?&id=".$id."'>Atualizar </a>";
			echo "<a href='deletar.php?&id=".$id."'>Deletar</a><br><br>";
		endforeach;
	else:
		echo 'Erro ao buscar: '.mysqli_erro($conexao_db);
	endif;
?>	
</body>
</html>
