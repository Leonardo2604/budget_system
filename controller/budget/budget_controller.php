<?php
	require('../../db/products_db.php');

	if($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		session_start();
		if(isset($_GET['action']) && $_GET['action'] != '')
		{
			$action = $_GET['action'];
			switch ($action) {
				case 'clear_budget':
					clear_budget();
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

				case 'init_products':
					//sleep(1); para que a pagina fique carregando 1 segundo
					init_products();					
				break;

				case 'init_budget':
					//sleep(1); para que a pagina fique carregando 1 segundo
					show_table();				
				break;

				case 'search_products':
					if(isset($_GET['search']))
					{
						$text = filter_var($_GET['search'], FILTER_SANITIZE_STRING, FILTER_SANITIZE_SPECIAL_CHARS );
						init_products($text);			
					}else
					{
						return;
					}
				break;

				default:
					echo "não foi possivel fazer o carregamento do conteúdo";
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

	function init_products($text_search = "")
	{
		$results = ($text_search == "")?return_all():return_all($text_search);

		if($results->num_rows == 0 && $text_search != ""){
			echo "Não existe nunhum produto com esse nome";
			return;
		}

		echo "<ul class='list-group list-products'>";
		while ($row = $results->fetch_assoc()) {
			$row['price'] = number_format($row['price'],"2",",",".");
			$row['labor'] = number_format($row['labor'],"2",",",".");
			echo    "<li class='list-group-item card'>
						<div class='row'>
							<div class='col-10'>
								<h4 class='card-title'>{$row['name']}</h4>
								<p class='card-text'>{$row['description']}</p>
							</div>
							<div class='col-2'>
								<a href='#' class='btn btn-primary' onclick=add_to_budget('/budget_system/controller/budget/budget_controller.php?action=add&id={$row['id']}') title='Adcionar da lista'>
									<i class='fa fa-plus' aria-hidden='true'></i>
								</a>
							</div>
						</div>
						<div class='row'>
							<div class='col-6'>
								<p class='text-inline'>Preço:</p>
								{$row['price']}
							</div>
							<div class='col'>
								<p class='text-inline'>Mão de obra:</p>
								{$row['labor']}
							</div>
						</div>
					</li>";
		}
		echo "</ul>";
	}

	function update_value_amount($indice, $qtd)
	{	
		if(isset($_SESSION['products']))
		{
			$_SESSION['products'][$indice]['amount'] = $qtd;
		}
		show_table();
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

		show_table();
	}

	function show_table()
	{
		echo "<table class='table'>
					<thead>
						<tr class='row'>
							<th class='col-1'>Ações</th>
							<th class='col-2'>Nome</th>
							<th class='col-4'>Descrição</th>
							<th class='col-1'>Preço</th>
							<th class='col-1'>Mão de obra</th>
							<th class='col-1'>Qtd</th>
							<th class='col-1'>Total</th>
							<th class='col-1'><a href='#' onclick='clear_budget()' title='Fazer outro orçamento' class='btn btn-primary align-bottom'>Limpar</a></th>
						</tr>
					</thead>
					<tbody>";
					$total = 0;
					if(isset($_SESSION['products'])){
						$products = $_SESSION['products'];
						$amount_products = count($products);
						if($amount_products > 0){
							for ($i=0; $i < $amount_products; $i++) 
							{
								// is important add row_total to total before in to use the function num_format
								$row_total = ($products[$i]['price'] + $products[$i]['labor'])*$products[$i]['amount'];
								$total += $row_total;
								$row_total = number_format($row_total,2,",",".");
								$products[$i]['price'] = number_format($products[$i]['price'],2,",",".");
								$products[$i]['labor'] = number_format($products[$i]['labor'],2,",",".");
								echo "<tr class='row'>
											<td class='col-1'>
												<a href='#' class='btn btn-danger' onclick=remove_to_budget('/budget_system/controller/budget/budget_controller.php?action=remove&indice={$i}') title='Retirar da lista'>
													<i class='fa fa-trash-o fa-lg'></i></a>
												</a>
											</td>
											<td class='col-2'>{$products[$i]['name']}</td>
											<td class='col-4'>{$products[$i]['description']}</td>
											<td class='col-1'>{$products[$i]['price']}</td>
											<td class='col-1'>{$products[$i]['labor']}</td>
											<td class='col-1'>
												<input type='number' name='amount{$i}' min='1' max='999' pattern='[0-9]' onchange=update_value_to_budget('{$i}') value='{$products[$i]['amount']}'/>
											</td>
											<td class='col-2'>{$row_total}</td>
										</tr>";
							}
							$total = number_format($total,2,",",".");
						}else
						{
							echo "<tr class='row'>
									<td class='center col' colspan='8'>Você ainda não adiciono nenhum item ao orçamento. Para adicionar basta aperta no <i class='btn btn-primary fa fa-plus' aria-hidden='true'></i> nos itens a esquerda</td>
								  </tr>
								  ";
						}
					}else
					{
						echo "<tr class='row'>
								<td class='center col' colspan='8'>Você ainda não adiciono nenhum item ao orçamento. Para adicionar basta aperta no <i class='btn btn-primary fa fa-plus' aria-hidden='true'></i> nos itens a esquerda</td>
							  </tr>
							  ";
					}
		      echo "</tbody>
					<tfoot>
						<tr class='row'>
							<td class='col-1'>Total:</td>
							<td class='col'></td>
							<td class='col-2'>{$total}</td>
						</tr>
					</tfoot>
				</table>";
	}

	function remove_product ($indice)
	{	
		unset($_SESSION['products'][$indice]);
		$_SESSION['products'] = array_values($_SESSION['products']);
		show_table();
	}

	function clear_budget ()
	{	
	 	unset($_SESSION['products']);
	 	$_SESSION['products'] = array();
		show_table();
	}
?>