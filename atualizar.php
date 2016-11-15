<?php 
include 'conexao.php';

$id = $_POST['id'];
$nome = utf8_decode($_POST['nome']);
$email = utf8_decode($_POST['email']);
$observacao = utf8_decode($_POST['observacao']);
//$foto = utf8_decode($_POST['foto']);
$foto = utf8_decode($_FILES["foto"]["name"]);
$type = $_FILES["foto"]["type"];
$size = $_FILES["foto"]["size"];
$temp = $_FILES["foto"]["tmp_name"];
$error = $_FILES["foto"]["error"];

//SELECIONAR
	$selecao = "SELECT * FROM tb_usuarios WHERE	id = ".$id."";
	$linhas = mysqli_query($conexao_db, $selecao);
	if($linhas):
		foreach ($linhas as $linha):
			extract($linha);
			$foto_db = utf8_encode($foto);
		endforeach;
	else:
		echo 'Erro ao indentificar a foto: '.mysqli_erro($conexao_db);
	endif;

	//unlink("fotos/$foto_db");

	if ($error > 0){
		die("É necessário enviar uma foto! Código do erro: $error.");
	}else{

		$foto = $_FILES['foto']['name'];

		$caracteresEspeciais = array("À","Á","Â","Ã","Ä","Å","Æ","Ç","È","É","Ê","Ë","Ì","Í","Î","Ï","Ð","Ñ","Ò","Ó","Ô","Õ","Ö","Ø","Ù","Ú","Û","Ü","ü","Ý","Þ","ß","à","á","â","ã","ä","å","æ","ç","è","é","ê","ë","ì","í","î","ï","ð","ñ","ò","ó","ô","õ","ö","ø","ù","ú","û","ý","ý","þ","ÿ","Ŕ","ŕ","\"","!","@","#","$","%","&","*","(",")","_","-","+","=","{","[","}","]","/","?",";",":",",","\\","\'","<",">"," ","~","´","`","¨");
		$caracteresEspeciaisAlt = array("a","a","a","a","a","a","a","c","e","e","e","e","i","i","i","i","d","n","o","o","o","o","o","o","u","u","u","u","u","y","b","s","a","a","a","a","a","a","a","c","e","e","e","e","i","i","i","i","d","n","o","o","o","o","o","o","u","u","u","y","y","b","y","R","r","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","_","-","-","-","-");
		$foto = str_replace($caracteresEspeciais, $caracteresEspeciaisAlt, $foto);
		$foto = strtolower($foto);

		$tiposPermitidos= array('image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/png');
		// Tamanho máximo (em bytes)
		$tamanhoPermitido = 1024 * 3000; // 3000 Kb

		if (array_search($type, $tiposPermitidos) === false) {

		  die("Envie apenas imagens GIF, JPEG, PJPEG e PNG");
		
		}else if ($size > $tamanhoPermitido) {  

			header("location: index.php?tamanhoFoto=nok");

		}else{
			unlink("fotos/$foto_db");
			if(file_exists("fotos/$foto")){
				$a = 1;
				while(file_exists("fotos/[$a]$foto")){
					$a++;
				}

				$foto = "[".$a."]".$foto;
			}

			if(!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['observacao'])){
				if($foto_db){
					unlink("fotos/$foto_db");
				}
				move_uploaded_file($temp,"fotos/".$foto);
				
				$nome = utf8_decode($_POST['nome']);
				$email = utf8_decode($_POST['email']);
				$observacao = utf8_decode($_POST['observacao']);

				//ATUALIZAR
				$queryAtualizar = "UPDATE tb_usuarios SET nome='".$nome."', email='".$email."', observacao='".$observacao."', foto='".$foto."' WHERE id='".$id."' ";
				$atualizar = mysqli_query($conexao_db, $queryAtualizar);

				if($atualizar):
					mysqli_close($conexao_db);
					header("location: index.php?atualizado=ok");
				else:
					mysqli_close($conexao_db);
					header("location: index.php?atualizado=nok");
				endif;
			}else{
				mysqli_close($conexao_db);
				header("location: index.php?campos=nok");
			}
		}	
	}
?>
