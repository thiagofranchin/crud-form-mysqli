<?php
//HOME
const HOST = 'localhost';
const USER = 'root';
const PASS = '';
const DBSA = 'db_crud';

//CONEXÃO
@$conexao_db = mysqli_connect(HOST,USER,PASS,DBSA);
if($conexao_db):
	//echo 'Conectado!'; 
else:
	echo 'Não conectado: '.mysqli_connect_error();
endif;
?>
