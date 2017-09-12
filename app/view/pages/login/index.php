<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="../../../css/login_cadaster.css"/>
</head>
<body>
	<section class="login">
		<header>
			<h1>Login</h1>
		</header>
		<section>
			<form name="login_user" action="/budget_system/controller/user/user_controller.php" method="post" enctype="multipart/form-data">
				<div class="input">
					<label>E-mail:</label>
					<input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required="required"/><br/>
				</div>
				<div class="input">
					<label>Senha:</label>
					<input type="password" name="password" required="required" /><br/>
				</div>
				<div class="input input_btn">
					<div>
						<a href="../cadaster/">Cadastre-se</a>
					</div>
					<div>
						<button type="submit" name="btn_login">Entrar</button>
					</div>
				</div>
			</form>
		</section>
	</section>
</body>

</html>