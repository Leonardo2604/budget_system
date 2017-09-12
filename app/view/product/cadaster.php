<?php
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'];
	}else{
		$id = -1; 
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<title><?=($id == -1)?"Cadaster":"Update"?></title>
</head>
<body>
	<section class="conteiner">
		<h1><?=($id == -1)?"Cadastrar":"Atualizar"?></h1>
		<section class="cadaster">
			<form name="cadaster_product" action="/budget_system/controller/product/product_controller.php" method="post" enctype="multipart/form-data">
				<label>Nome:</label>
				<input type="text" name="name" required="required"/><br/>
				<label>Descrição:</label>
				<textarea rows="5" cols="50" name="description"></textarea><br/>
				<label>Preço:</label>
				<input type="number" name="price" pattern="[0-9]+([\.,][0-9]+)?" step="any" required="required" /><br/>
				<label>Desconto do produto:</label>
				<input type="number" name="cash_discount" min="0" max="100" required="required" /><br/>
				<label>Mão de obra:</label>
				<input type="number" name="labor" pattern="[0-9]+([\.,][0-9]+)?" step="any" required="required" /><br/>
				<input type="hidden" name="id" value="<?= $id ?>"/>
				<button type="submit" name="btn_cadaster"><?=($id == -1)?"Cadaster":"Save"?></button>
			</form>
			<a href="index.php">Cancelar</a>
		</section><!-- section register -->
	</section><!-- section conteiner -->
</body>

</html>