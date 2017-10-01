<?php
	require('../../db/users_db.php'); // functions create, update, show, delete, return_all, login

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		//========================================== REGISTER AND UPDATE USER ==================================
		if(isset($_POST['btn_register']))
		{
			if(isset($_POST['id'], $_POST['token'], $_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirm_password'], $_POST['permission']) &&
			  !empty($_POST['id']) && !empty($_POST['token']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password']))
			{
				$id = (int)$_POST['id'];
				session_start();
				if(is_numeric($id))
				{
					if($id == $_SESSION['id'])
					{
						if($_POST['token'] == $_SESSION['token'])
						{
							if($_POST['password'] == $_POST['confirm_password'])
							{
								$name = addslashes($_POST['name']);
								$email = addslashes($_POST['email']);
								$permission = addslashes($_POST['permission']);

								$email = filter_var( $email, FILTER_SANITIZE_EMAIL );
								$name = filter_var( $name, FILTER_SANITIZE_STRING, FILTER_SANITIZE_SPECIAL_CHARS );
								$permission = filter_var( $permission, FILTER_SANITIZE_STRING, FILTER_SANITIZE_SPECIAL_CHARS );

								$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

								if(filter_var($email, FILTER_VALIDATE_EMAIL))
								{
									if($id == -1)
									{	
										// create a user
										create($permission, $name, $email, $password);
										echo "
												<div class='msg'>
													<p>usuario criado com sucesso!</p>
												</div>
											";
									}else
									{
										// update the user
										if(filter_var($id, FILTER_VALIDATE_INT))
										{
											update($permission, $name, $email, $password, $id);
											show_table_users();
										}else
										{
											echo "<p>O id precisa ser um numero inteiro</p>\n<a href='/budget_system/app/view/pages/cadaster/'>Voltar</a>";
										}
									}
									// update token
									$_SESSION['token'] = hash( 'sha512', rand( 100, 1000 ) );
								}else
								{
									echo "<p>O email é invalido</p>\n<a href='/budget_system/app/view/pages/cadaster/'>Voltar</a>";				
								}
							}else
							{
								echo "<p>A confirmação de senha esta incorreta</p>\n<a href='/budget_system/app/view/pages/cadaster/'>Voltar</a>";				
							}
						}else
						{
							echo "<p>Token incorreto</p>\n<a href='/budget_system/app/view/pages/cadaster/'>Voltar</a>";		
						}
					}else
					{
						echo "<p>O id esta incorreto você não pode alterar dados de outro usuario</p>\n<a href='/budget_system/app/view/pages/cadaster/'>Voltar</a>";
					}
				}else
				{
					echo "<p>O id precisa ser um numero</p>\n<a href='/budget_system/app/view/pages/cadaster/'>Voltar</a>";
				}
			}else
			{
				echo "<p>estão faltando dados no registro</p>\n<a href='/budget_system/app/view/pages/cadaster/'>Voltar</a>";
			}
		}

		//========================================== LOGIN ==================================

		if( isset($_POST['btn_login']))
		{
			if(isset($_POST['email'], $_POST['password']) &&
			  !empty($_POST['email']) && !empty($_POST['password']))
			{
				$email = addslashes($_POST['email']);
				$password = addslashes($_POST['password']);
			
				$email = filter_var( $email, FILTER_SANITIZE_EMAIL );

				if(filter_var($email, FILTER_VALIDATE_EMAIL))
				{
			   		$result = login($email);

			   		if($result->num_rows > 0)
			   		{
			   			$row = $result->fetch_assoc();
			   			if(password_verify($password, $row['password']))
			   			{
			   				session_start();
							$_SESSION['id'] = (int)$row['id'];
							$_SESSION['name'] = $row['name'];
							$_SESSION['email'] = $row['email'];
							$_SESSION['permission'] = $row['permission'];

							switch ($row['permission']) {
								case 'adm':
									header('Location:/budget_system/app/view/pages/adm/');
									break;

								case 'user':
									header('Location:/budget_system/app/view/pages/budget/');
									break;
							}
			   			}else
			   			{
			   				$erro = 'Senha/incorreta!';
            				header('Location:/budget_system/app/view/pages/login/?erro='.$erro.'');
			   			}
			   		}else
			   		{
			   			$erro = 'email/não/encontrado!';
            			header('Location:/budget_system/app/view/pages/login/?erro='.$erro.'');
			   		}
			   	}else
			   	{
			   		$erro = 'email/esta/em/um/formato/não/correspondente/ao/esperado!';
            		header('Location:/budget_system/app/view/pages/login/?erro='.$erro.'');
			   	}
			}else
			{
				$erro = 'estão/faltando/dados/no/login!';
            	header('Location:/budget_system/app/view/pages/login/?erro='.$erro.'');
			}
		}
	}

	if($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		//========================================== SHOW AND DELETE USER ==================================
		if(isset($_GET['action']) && !empty($_GET['action']) && !is_numeric($_GET['action']))
		{
			$action = $_GET['action'];

			if(isset($_GET['id']) && !empty($_GET['id']))
			{
				$id = $_GET['id'];
				$id = filter_var( $id, FILTER_SANITIZE_NUMBER_INT );
				
				if(filter_var($id, FILTER_VALIDATE_INT))
				{
					switch ($action) 
					{
						case 'show':
							$result = show($id);
							$row = $result->fetch_assoc();
							view_user($row);
							break;
						
						case 'delete':
							delete($id);
							show_table_users();
							break;

						case 'update':
							create_new_user($id);
							break;

						case 'new_user':
							create_new_user($id);
							break;
					}
				}else
				{
					echo "<p>O id deve ser um numero inteiro</p>\n<a href='/budget_system/app/view/user/'>Voltar</a>";
				}
			}
			else
			{
				switch ($action) {
					case 'init_table':
						show_table_users();
						break;
					
					default:
						echo "Ouveram erros ao fazer a requisição favor informar ao desenvolvedor";
						break;
				}
			}
		}
		//=================================================== LOGOUT ============================================================
		if(isset($_GET['logout']))
		{
			logout();
		}
	}

	function show_table_users ()
	{	
		$results = return_all();

		echo "
			<h1>Usuários</h1>
			<table class='table'>
				<thead>
					<tr>
						<th>id</th>
						<th>Permissão</th>
						<th>Nome</th>
						<th>E-mail</th>
						<th>Ver</th>
						<th>Atualizar</th>
						<th>Deletar</th>
					</tr>
				</thead>
				<tbody>
		";
			while ($result = $results->fetch_assoc())
			{
				echo"
					<tr>
						<th scope='row'>{$result['id']}</th><!-- puxar id da tabela -->
						<td>{$result['permission']}</td><!-- puxar id da tabela -->
				      	<td>{$result['name']}</td><!-- puxar name da tabela -->
				      	<td>{$result['email']}</td><!-- puxar email da tabela -->
				      	<td><button type='button' class='btn btn-info btn-sm' onclick='action_user(\"show\", {$result['id']})'><i class='fa fa-eye custom-settings-icon' aria-hidden='true'></i>Ver</button></td>
				      	<td><button type='button' class='btn btn-secondary btn-sm' onclick='action_user(\"update\", {$result['id']})'><i class='fa fa-pencil custom-settings-icon' aria-hidden='true'></i>Atualizar</a></td>
				      	<td><button type='button' class='btn btn-danger btn-sm' onclick='delete_user({$result['id']})'><i class='fa fa-eraser custom-settings-icon' aria-hidden='true'></i>Deletar</a></td>
					</tr>
				";
			}
		echo "
				</tbody>
			</table>
		";
	}

	function create_new_user($id)
	{
		session_start();

		if(!isset($_SESSION['token'])){
			$_SESSION['token'] = hash( 'sha512', rand( 100, 1000 ) );
		}else{
			$_SESSION['token'] = $_SESSION['token'];
		}

		if($id == -1)
		{
			$text_btn = "Cadastrar";
			$title = "Cadastrar novo usuário";
			$function_for_execute = 'create_user()';
		}else if($id != -1)
		{
			$text_btn = "Atualizar";
			$title = "Atualizar usuário";
			echo "<button onclick='close_modal()' class='close'>x</button>";
			$function_for_execute = 'update_user()';
		}

		$_SESSION['id'] = $id;

		echo "
			<section>
				<header>
					<h1>{$title}</h1>
				</header>
				<form name='register_user' enctype='multipart/form-data'>
					<div class='form-group'>
						<label class='mr-sm-2'>Qual é o nivel de permissção</label>
						<select class='custom-select' name='permission'>
						  <option value='user' selected>user</option>
						  <option value='adm'>adm</option>
						</select>
					</div>
					<div class='form-group'>
						<label class='col-form-label'>Nome:</label>
						<input type='text' class='form-control' name='name' pattern='[a-zA-Z\s]+$' required='required'/>
					</div>
					<div class='form-group'>
						<label class='col-form-label'>E-mail:</label>
						<input type='email' class='form-control' name='email' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$'' placeholder='registrar@exemplo.com' required='required'/>
					</div>
					<div class='form-row'>
						<div class='form-group col-md-6'>
							<label class='col-form-label'>Senha:</label>
							<input type='password' class='form-control' name='password' placeholder='********' required='required' />
						</div>
						<div class='form-group col-md-6'>
							<label class='col-form-label'>Confirmar senha:</label>
							<input type='password' class='form-control' name='confirm_password' placeholder='********' required='required' />
						</div>
					</div>
					<input type='hidden' name='id' value='{$id}'  />
					<input type='hidden' name='token' value='{$_SESSION['token']}'/>
					<div class='form-group'>
						<button type='button' class='btn btn-primary' onclick='{$function_for_execute}' name='btn_register'>{$text_btn}</button>
					</div>
				</form>
			</section>
		";
	}

	function view_user($user)
	{
		echo "
			<button onclick='close_modal()' class='close'>x</button>
			<h2>Nome: {$user['name']}</h2>
			<hr>
			<p>E-mail: {$user['email']}</p>
			<p>Seu id: {$user['id']}</p>
		";
	}

	function logout(){
		session_start();
		if(isset($_SESSION['id'], $_SESSION['name'], $_SESSION['email']))
		{
			unset($_SESSION['id']);
			unset($_SESSION['name']);
			unset($_SESSION['email']);
			unset($_SESSION['permission']);

			if(isset($_SESSION['products']))
			{
				unset($_SESSION['products']);
			}
			header('Location:/budget_system/app/view/pages/login/');
		}else
		{
			header('Location:/budget_system/app/view/pages/pages/budget/');
		}
	}	
?>