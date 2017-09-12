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
				<th>id</th>
				<th>name</th>
				<th>e-mail</th>
				<th>show</th>
				<th>update</th>
				<th>delete</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$connection = new mysqli('localhost','root','','budget_system');
				if($connection){
					$results = $connection->query("SELECT * FROM `users`");
					while($result = $results->fetch_assoc()){
						echo '<tr>
						      	<td>'.$result['id'].'</td><!-- puxar id da tabela -->
						      	<td>'.$result['name'].'</td><!-- puxar name da tabela -->
						      	<td>'.$result['email'].'</td><!-- puxar email da tabela -->
						      	<td><a href="/budget_system/controller/user/user_controller.php?action=show&id='.$result['id'].'">show</a></td><!-- ver name da tabela -->
						      	<td><a href="/budget_system/app/view/pages/cadaster/?id='.$result['id'].'">update</a></td><!-- atualiza name da tabela -->
						      	<td><a href="'.$_SERVER["PHP_SELF"].'?id='.$result['id'].'&delete=true">delete</a></td><!-- deleta name da tabela -->
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
				<a href="/budget_system/controller/user/user_controller.php?action=delete&id=<?=(int)$_GET["id"]?>">yes</a>
				<a href="index.php">no</a>
			</div>
	<?php } ?>
	<a href="/budget_system/app/view/pages/cadaster/">Novo usuario</a>

</body>
</html>