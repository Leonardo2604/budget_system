<?php
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		if(isset($_GET['id']) && isset($_GET['name']) && isset($_GET['email'])){
			$id = (int)$_GET['id'];
			$name = $_GET['name'];
			$email = $_GET['email'];
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Show user</title>
</head>
<body>
	<div>
		<p>Bem vindo <?= $name ?> o seu identificador é <?= $id ?> e o seu email é <?= $email ?></p>	
		<a href="index.php">Table users</a>
	</div>
</body>
</html>