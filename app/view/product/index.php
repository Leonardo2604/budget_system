<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<title>Profile</title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>Id</th>
				<th>Nome</th>
				<th>Descrição</th>
				<th>Preço</th>
				<th>Desconto</th>
				<th>Mão de Obra</th>
				<th>Ver</th>
				<th>Atualizar</th>
				<th>Apagar</th>
			</tr>
		</thead>
		<tbody>
			<?php
				require('../../../db/connection.php');
				$connection = connect_db();
				if($connection){
					$results = $connection->query("SELECT * FROM `products`");
					while($result = $results->fetch_assoc()){
						echo '<tr>
						      	<td>'.$result['id'].'</td>
						      	<td>'.$result['name'].'</td>
						      	<td>'.$result['description'].'</td>
						      	<td>'.$result['price'].'</td>
						      	<td>'.$result['cash_discount'].'</td>
						      	<td>'.$result['labor'].'</td>
						      	<td><a href="/budget_system/controller/product/product_controller.php?action=show&id='.$result['id'].'">show</a></td>
						      	<td><a href="cadaster.php?id='.$result['id'].'">update</a></td>
						      	<td><a href="'.$_SERVER["PHP_SELF"].'?id='.$result['id'].'&delete=true">delete</a></td>
						      </tr>';
					}
					$connection->close();
				}else{
					echo '<p>Lamentamos o ocorrido, já estamos fazendo todo o possivel para que o sistema volte ao normal o quanto antes </p>';
				}
			?>
		</tbody>
	</table>
	<?php if (isset($_GET['delete']) && isset($_GET['id']) && is_numeric($_GET['id']) && !empty($_GET['id'])){ ?>
			<div class="container_delete">
				<p>you have sure?</p>
				<a href="/budget_system/controller/product/product_controller.php?action=delete&id=<?=(int)$_GET["id"]?>">yes</a>
				<a href="index.php">no</a>
			</div>
	<?php } ?>
	<a href="cadaster.php">Register new user</a>

</body>
</html>