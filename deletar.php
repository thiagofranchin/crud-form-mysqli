<?php 
	include 'conexao.php';
	
	$id = $_GET['id'];

	//DELETAR 
	$queryDeletarArq = "SELECT * FROM tb_usuarios WHERE id='".$id."'";
	$deletarArq = mysqli_query($conexao_db, $queryDeletarArq);
	if($deletarArq):
		foreach ($deletarArq as $del):
			extract($del);			
			$foto_db = $foto;						
		endforeach;
		
		unlink("fotos/$foto_db");
		
		$queryDeletar = "DELETE FROM tb_usuarios WHERE id='".$id."'";
		$deletar = mysqli_query($conexao_db, $queryDeletar);
		
		mysqli_close($conexao_db);
		header("location: index.php?deletado=ok");
	else:
		mysqli_close($conexao_db);
		header("location: index.php?deletado=nok");
	endif;
	
?>