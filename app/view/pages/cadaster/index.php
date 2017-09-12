<?php
	session_start();
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'];
	}else{
		$id = -1; 
	}

	$_SESSION['id'] = $id;
	
	if(!isset($_SESSION['token'])){
		$_SESSION['token'] = hash( 'sha512', rand( 100, 1000 ) );
	}else{
		$_SESSION['token'] = $_SESSION['token'];
	}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<title><?=($id == -1)?"Cadastrar-se":"Atualizar"?></title>
	<link rel="stylesheet" type="text/css" href="../../../css/login_cadaster.css"/>
</head>
<body>
	<section class="register">
			<header>
				<h1>Cadastre-se</h1>
			</header>
			<section>
				<form name="register_user" action="/budget_system/controller/user/user_controller.php" method="post" enctype="multipart/form-data">
					<div class="input">
						<label>Nome:</label>
						<input type="text" name="name" pattern="[a-zA-Z\s]+$" required="required"/><br/>
					</div>
					<div class="input">
						<label>E-mail:</label>
						<input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required="required"/><br/>
					</div>
					<div class="input">
						<label>Senha:</label>
						<input type="password" name="password" required="required" /><br/>
					</div>
					<div class="input">
						<label>Confirmar senha:</label>
						<input type="password" name="confirm_password" required="required" /><br/>
					</div>
					<input type="hidden" name="id" value="<?= $id ?>"/>
					<input type="hidden" name="token" value="<?= $_SESSION['token'] ?>"/>
					<div class="input input_btn">
						<div>
							<a href="<?=($id == -1)?"../login/":"../../user/"?>">Cancelar</a>
						</div>
						<div>
							<button type="submit" name="btn_register"><?=($id == -1)?"Cadastrar":"Salvar"?></button>
						</div>
					</div>
				</form>
			</section>
	</section>
</body>
</html>