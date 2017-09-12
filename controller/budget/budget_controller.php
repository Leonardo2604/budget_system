<?php
	require('../../db/products_db.php');

	if($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		if(isset($_GET['action']) && $_GET['action'] != '')
		{
			$action = $_GET['action'];
			session_start();
			switch ($action) {
				case 'new':
					new_budget();
				break;

				case 'add':
					if(isset($_GET['id']) && $_GET['id'] != '' &&  is_numeric($_GET['id']))
					{
						$id = $_GET['id'];
						$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
						if(filter_var( $id, FILTER_VALIDATE_INT))
						{
							add_product($id);
						}else
						{
							echo "<p>o id não pode ser alterado</p>\n<a href='/budget_system/app/view/pages/budget/'>Voltar</a>";
						}
					}else
					{
						echo "<p>o id é invalido</p>\n<a href='/budget_system/app/view/pages/budget/'>Voltar</a>";
					}
				break;
				
				case'remove':
					if(isset($_GET['indice']) && $_GET['indice'] != '' &&  is_numeric($_GET['indice']))
					{
						$indice = $_GET['indice'];
						$indice = filter_var($indice, FILTER_SANITIZE_NUMBER_INT);
						if($indice != 0)
						{
							if(filter_var( $indice, FILTER_VALIDATE_INT))
							{
								remove_product($indice);
							}else
							{
								echo "<p>o indice não pode ser alterado</p>\n<a href='/budget_system/app/view/pages/budget/'>Voltar</a>";
							}
						}else{
							remove_product($indice);
						}
					}else
					{
						echo "<p>o indice é invalido</p>\n<a href='/budget_system/app/view/pages/budget/'>Voltar</a>";
					}
				break;
			}
		}

		if(isset($_GET['indice']) && $_GET['indice'] != '' && is_numeric($_GET['indice']) && 
		   isset($_GET['qtd']) && $_GET['qtd'] != '' && is_numeric($_GET['qtd']))	
		{
			$indice = filter_var($_GET['indice'], FILTER_SANITIZE_NUMBER_INT);
			$qtd = filter_var($_GET['qtd'], FILTER_SANITIZE_NUMBER_INT);
			update_value_amount($indice, $qtd);
		}
	}

	function update_value_amount($indice, $qtd)
	{	
		session_start();
		if(isset($_SESSION['products']))
		{
			$_SESSION['products'][$indice]['amount'] = $qtd;
		}
		header('Location:/budget_system/app/view/pages/budget/');
	}

	function add_product ($id)
	{
		$result = show($id);
		$product = $result->fetch_assoc();
		$product['amount'] = 1;

		if(isset($_SESSION['products']))
		{
			array_push($_SESSION['products'], $product);
			
		}else
		{	
			$_SESSION['products'] = array();
			array_push($_SESSION['products'], $product);
		}
		
		header('Location:/budget_system/app/view/pages/budget/');
	}

	function remove_product ($indice)
	{	
		unset($_SESSION['products'][$indice]);
		$_SESSION['products'] = array_values($_SESSION['products']);
		header('Location:/budget_system/app/view/pages/budget/');
	}

	function new_budget ()
	{
		unset($_SESSION['products']);
		header('Location:/budget_system/app/view/pages/budget/');
	}
?>