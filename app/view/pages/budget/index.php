<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<title>Store</title>
	<link rel="stylesheet" type="text/css" href="../../../css/budget.css"/>
	<?php session_start(); 
		if(!isset($_SESSION['name'], $_SESSION['id'], $_SESSION['email'])){
			header('Location:/budget_system/app/view/pages/login/');
		}
	?>
</head>
<body>
	<header class="page">
		<div class="left">
			<p>Olá <?= $_SESSION['name'] ?></p>
			<a href='/budget_system/controller/budget/budget_controller.php?action=new' title="Fazer outro orçamento" class="plus">+</a>
		</div>
		<div class="right">
			<p><?= $_SESSION['email'] ?></p>
			<a href="../../../../controller/user/user_controller.php?logout=true">sair</a>	
		</div>
	</header>
	<section class="page">
		<aside>
			<header class="header_aside">
				<form name="search" action="" method="POST" enctype="multipart/form-data">
					<div class="container_search">
						<input type="text" pattern="[^'\x22]+" name="text_search"/>
						<button type="submit" name="btn_search"><img src="../../../image/magnifying_glass.png"/></button><!--temporario-->
					</div>
				</form>
			</header>
			<section class="products">
				<ul>
					<?php
						require('../../../../db/connection.php');
						$connection = connect_db();
						if($connection){
							if(isset($_POST['btn_search']) || isset($_SESSION['text_search']))
							{
								$_SESSION['text_search'] = (isset($_POST['text_search']))?$_POST['text_search']:$_SESSION['text_search'];
								$results = $connection->query('SELECT * FROM `products` WHERE `name` LIKE  "%'.$_SESSION['text_search'].'%" ');	
							}else
							{
								$results = $connection->query("SELECT * FROM `products`");
							}
							while($result = $results->fetch_assoc()){ 
					?>
								<li>
									<div class="content_first">
										<div class="name">
											<h2><?=$result['name']?></h2>
										</div>
										<div class="description">
											<p><?=$result['description']?></p>
										</div>
									</div>
									<div class="content_secound">
										<div class="price">
											<p>Preço:</p>
											<?=$result['price']?>
											<br/>
											<p>Mão de obra:</p>
											<?=$result['labor']?>
										</div>
										<div class="btn_add">
											<a href='/budget_system/controller/budget/budget_controller.php?action=add&id=<?= (int)$result['id'] ?>' title="Adcionar da lista">+</a>
										</div>
									</div>
								</li>
					<?php	}
							$connection->close();
						}else{
							echo '<p>Lamentamos o ocorrido, já estamos fazendo todo o possivel para que o sistema volte ao normal o quanto antes </p>';
						}
					?>
				</ul>
			</section>
		</aside>
		<section class="products_list">
			<table>
				<thead>
					<tr>
						<th>Ações</th>
						<th>Nome</th>
						<th>Descrição</th>
						<th>Preço</th>
						<th>Mão de obra</th>
						<th>Qtd</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$total = 0;
						if(isset($_SESSION['products']))
						{
							$products = $_SESSION['products'];
							for ($i=0; $i < count($products); $i++) { 
					?>		
								<tr>
									<td>
										<a href='/budget_system/controller/budget/budget_controller.php?action=remove&indice=<?= $i ?>' title="Retirar da lista"><img src="../../../image/icon_trash.png"/></a>
									</td>
									<td><?= $products[$i]['name'] ?></td>
									<td><?= $products[$i]['description'] ?></td>
									<td class="price<?=$i?>"><?= $products[$i]['price'] ?></td>
									<td class="labor<?=$i?>"><?= $products[$i]['labor'] ?></td>
									<td>
										<input type="number" name="amount<?=$i?>" min="1" max="999" pattern="[0-9]" onchange="update_value(<?=$i?>)" value="<?= $products[$i]['amount'] ?>"/>
									</td>
									<td class="total<?=$i?> total"><?= $products[$i]['price'] + $products[$i]['labor'] ?></td>
								</tr>
					<?php

								$total += ($products[$i]['price'] + $products[$i]['labor']);
					    	}	
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<td>Total:</td>
						<td colspan="5"></td>
						<td class="full_total"><?= $total ?></td>
					</tr>
				</tfoot>
			</table>
		</section>
	</section>
	<script type="text/javascript">
		all_total = document.getElementsByClassName('total');
		full_total = document.getElementsByClassName('full_total')[0];
		load_budget();

		function update_value(indice)
		{
			amount = document.getElementsByName('amount'+indice)[0].value;
			if(amount > 999)
			{
				amount = 999;
			}
			window.location = '/budget_system/controller/budget/budget_controller.php?qtd='+amount+'&indice='+indice;
		}

		function load_budget()
		{
			for (var i = 0; i < all_total.length; i++) {
				amount = document.getElementsByName('amount'+i)[0].value;
				labor = parseFloat(document.getElementsByClassName('labor'+i)[0].innerHTML);
				price = parseFloat(document.getElementsByClassName('price'+i)[0].innerHTML);
				total = document.getElementsByClassName('total'+i)[0];
				total.innerHTML = ((labor + price) * amount).toFixed(2);
			}

			temp_total = 0;
			for (var i = 0; i < all_total.length; i++) {
				temp_total += parseFloat(all_total[i].innerHTML);
			}

			full_total.innerHTML = temp_total.toFixed(2);
		}
	</script>
</body>
</html>