<?php
	require('../../db/products_db.php'); // functions create, update, show, delete, return_all
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		//========================================== REGISTER AND UPDATE PRODUCTS ==================================
		if(isset($_POST['btn_cadaster']))
		{
			if(isset($_POST['id'], $_POST['name'], $_POST['description'], $_POST['price'], $_POST['cash_discount'], $_POST['labor']) &&
			  !empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['description']) && $_POST['price'] != "" && $_POST['cash_discount'] != "" && $_POST['labor'] != "")
			{
				$id = (int)$_POST['id'];
				$name = addslashes($_POST['name']);
				$description = addslashes($_POST['description']);
				$price = (double)$_POST['price'];
				$cash_discount = (int)$_POST['cash_discount'];
				$labor = (double)$_POST['labor'];

				$name = filter_var($name, FILTER_SANITIZE_STRING, FILTER_SANITIZE_SPECIAL_CHARS);
				$description = filter_var($description, FILTER_SANITIZE_STRING, FILTER_SANITIZE_SPECIAL_CHARS);
				$cash_discount = filter_var($cash_discount, FILTER_SANITIZE_NUMBER_INT);

				if($id == -1)
				{	
					create($name, $description, $price, $cash_discount, $labor);
					header('Location:/budget_system/app/view/product/cadaster.php');
				}else
				{
					update($name, $description, $price, $cash_discount, $labor, $id);
					header('Location:/budget_system/app/view/product/');
				}
			}else
			{
				echo "<p>estão faltando dados no registro</p>\n<a href='/budget_system/app/view/product/cadaster.php'>Voltar</a>";
			}
		}
	}


	if($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		//========================================== SHOW AND DELETE PRODUCTS ==================================
		if(isset($_GET['action']) && !empty($_GET['action']) && !is_numeric($_GET['action']))
		{
			$action = $_GET['action'];

			if(isset($_GET['id']) && !empty($_GET['id'])){
				$id = $_GET['id'];
				$id = filter_var( $id, FILTER_SANITIZE_NUMBER_INT );

				switch ($action) 
				{
					case 'show':
						$result = show($id);
						$row = $result->fetch_assoc();
						header('Location:/budget_system/app/view/product/show.php?id='.$row['id'].'&name='.$row['name'].'&description='.$row['description'].'&price='.$row['price'].'&cash_discount='.$row['cash_discount'].'&labor='.$row['labor'].'');
					break; 
					
					case 'delete':
						delete($id);
						header('Location:/budget_system/app/view/product/');
					break;
				}
			}else
			{	
				echo "<p>O id deve existir</p>\n<a href='/budget_system/app/view/product/'>Voltar</a>";
			}
		}
	}	
?>