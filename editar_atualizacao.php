<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Crud com Formulário</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>

<form action="atualizar.php" method="POST" enctype="multipart/form-data">
	<fieldset>
		<legend>Atualização de usuários</legend>

		<?php
		
		$id = $_GET['id'];

		include 'conexao.php';

		$queryLinha = "SELECT * FROM tb_usuarios WHERE id='".$id."'";
		$linhas = mysqli_query($conexao_db,$queryLinha);
		if($linhas):
		foreach ($linhas as $linha):
			extract($linha);
			$id;
			utf8_encode($nome);
			utf8_encode($email);
			utf8_encode($observacao);
			utf8_encode($foto);
		endforeach;
	else:
		echo 'Erro ao trazer os resultados: '.mysqli_error($conexao_db);
	endif;

		?>
		<br>
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="text" name="nome" placeholder="Nome" value="<?php echo utf8_encode($nome); ?>"/><br>
		<input type="email" name="email" placeholder="Email" value="<?php echo utf8_encode($email); ?>" /><br>
		<textarea name="observacao" placeholder="Observação"><?php echo utf8_encode($observacao); ?></textarea><br>
		<?php echo "<img src='fotos/".utf8_encode($foto)."' width='200'><br><br>"; ?>
		<input type="file" name="foto" placeholder="Selecione o arquivo" /><br>
		<button type="submit">Atualizar</button><br><br>
		<a href="index.php"><< Voltar</a>
	</fieldset>
</form>


	
</body>
</html>
