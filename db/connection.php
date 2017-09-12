<?php
function connect_db( $server = "localhost", $user_db = "root", $password_db = "", $name_db = "budget_system" )
{
	$connection = new mysqli($server, $user_db, $password_db, $name_db);

	if ($connection->connect_errno) 
	{
		printf("Falha ao conectar com o banco de dados: %s\n", mysqli_connect_error());
		exit();
	}else
	{
		return $connection;
	}
}
?>
