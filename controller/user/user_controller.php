<?php
	require('../../db/users_db.php'); // functions create, update, show, delete, return_all, login

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		//========================================== REGISTER AND UPDATE USER ==================================
		if(isset($_POST['btn_register']))
		{
			if(isset($_POST['id'], $_POST['token'], $_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirm_password']) &&
			  !empty($_POST['id']) && !empty($_POST['token']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password']))
			{
				$id = $_POST['id'];
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

								$email = filter_var( $email, FILTER_SANITIZE_EMAIL );
								$name = filter_var( $name, FILTER_SANITIZE_STRING, FILTER_SANITIZE_SPECIAL_CHARS );

								$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

								if(filter_var($email, FILTER_VALIDATE_EMAIL))
								{
									if($id == -1)
									{	
										// create a user
										create($name, $email, $password);
										header('Location:/budget_system/app/view/pages/cadaster?sucess=true');
									}else
									{
										// update the user
										if(filter_var($id, FILTER_VALIDATE_INT))
										{
											update($name, $email, $password, $id);
											header('Location:/budget_system/app/view/user/');
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
			   		$result = login($email, $password);

			   		if($result->num_rows > 0)
			   		{
			   			$row = $result->fetch_assoc();
			   			if(password_verify($password, $row['password']))
			   			{
			   				session_start();
							$_SESSION['id'] = (int)$row['id'];
							$_SESSION['name'] = $row['name'];
							$_SESSION['email'] = $row['email'];
							header('Location:/budget_system/app/view/pages/budget/');
			   			}else
			   			{
			   				echo "<p>Senha incorreta</p>\n<a href='/budget_system/app/view/pages/login/'>Voltar</a>";
			   			}
			   		}else
			   		{
			   			echo "<p>email não encontrado</p>\n<a href='/budget_system/app/view/pages/login/'>Voltar</a>";
			   		}
			   	}else
			   	{
			   		echo "<p>email esta em um formato não correspondente ao esperado</p>\n<a href='/budget_system/app/view/pages/login/'>Voltar</a>";
			   	}
			}else
			{
				echo "<p>estão faltando dados no login</p>\n<a href='/budget_system/app/view/pages/login/'>Voltar</a>";
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
				
				if(filter_var( $id, FILTER_VALIDATE_INT))
				{
					switch ($action) 
					{
						case 'show':
							$result = show($id);
							$row = $result->fetch_assoc();
							header('Location:/budget_system/app/view/user/show.php?id='.$row['id'].'&name='.$row['name'].'&email='.$row['email'].'');
						break;
						
						case 'delete':
							delete($id);
							header('Location:/budget_system/app/view/user/');
						break;
					}
				}else
				{
					echo "<p>O id deve ser um numero inteiro</p>\n<a href='/budget_system/app/view/user/'>Voltar</a>";
				}
			}else
			{
				echo "<p>O id deve existir</p>\n<a href='/budget_system/app/view/user/'>Voltar</a>";
			}
		}
		//=================================================== LOGOUT ============================================================
		if(isset($_GET['logout']))
		{
			logout();
		}
	}

	function logout(){
		session_start();
		if(isset($_SESSION['id'], $_SESSION['name'], $_SESSION['email']))
		{
			unset($_SESSION['id']);
			unset($_SESSION['name']);
			unset($_SESSION['email']);
			if(isset($_SESSION['text_search']) || isset($_SESSION['products']))
			{
				unset($_SESSION['text_search']);
				unset($_SESSION['products']);
			}
			header('Location:/budget_system/app/view/pages/login/');

		}else
		{
			header('Location:/budget_system/app/view/pages/pages/budget/');
		}
	}	
?>