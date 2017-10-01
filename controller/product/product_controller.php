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
					echo "
						<div class='alert alert-success alert-dismissible fade show' role='alert'>
							<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
								<span aria-hidden='true'>&times;</span>
							</button>
							<strong>Cadastrado!</strong> Produto cadastrado com sucesso.
						</div>
						";
				}else
				{
					session_start();
					update($name, $description, $price, $cash_discount, $labor, $id);
					show_table_products($_SESSION['current_page']);
				}
			}else
			{
				echo "
					<div class='alert alert-danger alert-dismissible fade show' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
						</button>
						<strong>Falhou!</strong> Estão faltando dados no registro.
					</div>
					";
			}
		}
	}


	if($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		if(isset($_GET['action']) && !empty($_GET['action']) && !is_numeric($_GET['action']))
		{
			$action = $_GET['action'];

			if(isset($_GET['id']) && !empty($_GET['id'])){
				$id = $_GET['id'];
				$id = filter_var( $id, FILTER_SANITIZE_NUMBER_INT );
				session_start();
				switch ($action) 
				{
					case 'show':
						$result = show($id);
						$row = $result->fetch_assoc();
						view_product($row);
						break; 
					
					case 'delete':
						delete($id);
						show_table_products($_SESSION['current_page']);
						break;

					case 'update':
						create_new_product($id);
						break;

					case 'new_product':
						create_new_product($id);
						break;
				}
			}
			else
			{
				switch ($action)
			    {
					case 'init_table':
						if(isset($_GET['page']) && is_numeric($_GET['page']))
						{
							$page = $_GET['page'];
							show_table_products($page);
						}
						break;
				
					default:
						echo "Ouveram erros ao fazer a requisição favor informar ao desenvolvedor";
						break;
				}
			}
		}
	}

	function view_product($product)
	{
		echo "
			<button onclick='close_modal()' class='close'>x</button>
			<p>Id: {$product['id']}</p>
			<hr>
			<h2>Nome: {$product['name']}</h2>
			<p>Descrição: {$product['description']}</p>
			<p>Preço: {$product['price']}</p>
			<p>Desconto: {$product['cash_discount']}</p>
			<p>Mão de obra: {$product['labor']}</p>

		";
	}

	function show_table_products($page)
	{
		$_SESSION['current_page'] = $page;
		$limit = 10;
		$index_start = ($page == 1)? 0 : ($limit * $page) - $limit; 
		$results = return_all("", $limit, $index_start);
		$amount_products = num_products();
		$pages = is_float(($amount_products / $limit))? ($amount_products / $limit) + 1 : $amount_products / $limit ;

		echo "
			<h1>Produtos</h1>
			<table class='table'>
				<thead>
					<tr class='row'>
						<th class='col-1'>Id</th>
						<th class='col-2'>Nome</th>
						<th class='col-3'>Descrição</th>
						<th class='col-1'>Preço</th>
						<th class='col-1'>Desconto</th>
						<th class='col-1'>Mão de Obra</th>
						<th class='col-1'>Ver</th>
						<th class='col-1'>Atualizar</th>
						<th class='col-1'>Apagar</th>
					</tr>
				</thead>
				<tbody>
		";
			while ($result = $results->fetch_assoc())
			{
				$result['price'] = number_format($result['price'],"2",",",".");
				$result['labor'] = number_format($result['labor'],"2",",",".");
				echo"
					<tr class='row'>
						<td class='col-1'>{$result['id']}</td>
				      	<td class='col-2'>{$result['name']}</td>
				      	<td class='col-3'>{$result['description']}</td>
				      	<td class='col-1'>{$result['price']}</td>
				      	<td class='col-1'>{$result['cash_discount']}%</td>
				      	<td class='col-1'>{$result['labor']}</td>
				      	<td class='col-1'><button type='button' class='btn btn-info btn-sm' onclick='action_product(\"show\", {$result['id']})'><i class='fa fa-eye custom-settings-icon' aria-hidden='true'></i>Ver</button>
				      	<td class='col-1'><button type='button' class='btn btn-secondary btn-sm' onclick='action_product(\"update\", {$result['id']})'><i class='fa fa-pencil custom-settings-icon' aria-hidden='true'></i>Atualizar</a></td>
				      	<td class='col-1'><button type='button' class='btn btn-danger btn-sm' onclick='delete_product({$result['id']})'><i class='fa fa-eraser custom-settings-icon' aria-hidden='true'></i>Deletar</a></td>
					</tr>
				";
			}
		echo "
				</tbody>
			</table>

			<nav aria-label='Page navigation example'>
				<ul class='pagination justify-content-center'>
					<li class='page-item'>
						<a class='page-link' href='#'>Previous</a>
					</li>
			";
				for ($i=1; $i <= $pages; $i++) 
				{ 
		echo "
					<li class='page-item'>
						<a class='page-link' href='#' onclick='page({$i})'>{$i}</a>
					</li>
			
			 ";	
				}	

		echo "
					<li class='page-item'>
						<a class='page-link' href='#'>Next</a>
					</li>
				</ul>
			</nav>
			";
	}

	function create_new_product($id)
	{
		if($id == -1)
		{
			$text_btn = "Cadastrar";
			$title = "Cadastrar Produto";
			$function_for_execute = 'create_product()';
		}else if($id != -1)
		{
			$text_btn = "Atualizar";
			$title = "Atualizar Produto";
			echo "<button onclick='close_modal()' class='close'>x</button>";
			$function_for_execute = 'update_product()';
		}

		echo "
			<section>
				<header>
					<h1>{$title}</h1>
				</header>
				<form name='cadaster_product' enctype='multipart/form-data'>
					<div class='form-group'>
						<label col-form-label>Nome:</label>
						<input type='text' class='form-control' name='name' required='required'/>
					</div>
					<div class='form-row'>
						<div class='form-group col-md'>
							<label col-form-label>Preço:</label>
							<input type='number' class='form-control' name='price' pattern='[0-9]+([\.,][0-9]+)?' step='any' required='required' />
						</div>
						<div class='form-group col-md'>
							<label col-form-label>Mão de obra:</label>
							<input type='number' class='form-control' name='labor' pattern='[0-9]+([\.,][0-9]+)?' step='any' required='required' />
						</div>
						<div class='form-group col-md'>
							<label col-form-label>Desconto do produto:</label>
							<input type='number' class='form-control' name='cash_discount' min='0' max='100' required='required' />
						</div>
					</div>
					<div class='form-group'>
						<label col-form-label>Descrição:</label>
						<textarea rows='5' class='form-control' placeholder='Descreva como é o produto: tamanho, marca, nome, etc ...' cols='50' name='description'></textarea>
					</div>
					<input type='hidden' name='id' value='{$id}'/>
					<div class='form-group'>
						<button type='button' class='btn btn-primary' onclick='{$function_for_execute}' name='btn_cadaster'>{$text_btn}</button>
					</div>
				</form>
			</section>
		";
	}	
?>