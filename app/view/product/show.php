<?php
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		if(isset($_GET['id'], $_GET['name'], $_GET['description'], $_GET['price'], $_GET['cash_discount'], $_GET['labor'])){
			$id = (int)$_GET['id'];
			$name = $_GET['name'];
			$description = $_GET['description'];
			$price = $_GET['price'];
			$cash_discount = $_GET['cash_discount'];
			$labor = $_GET['labor'];
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
		<p>id</p>
		<?= $id ?>
		<p>nome</p>
		<?= $name ?>
		<p>description</p>
		<?= $description ?>
		<p>preço</p>
		<?= $price ?>
		<p>desconto</p>
		<?= $cash_discount ?>
		<p>mão de obra</p>
		<?= $labor ?><br/>	
		<a href="index.php">Table de Peças</a>
	</div>
</body>
</html>