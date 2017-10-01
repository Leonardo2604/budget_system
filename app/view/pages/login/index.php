<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="/budget_system/app/css/bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/budget_system/app/css/login_cadaster.css"/>
	<script type="text/javascript" src="../../../javascript/login/login.js" defer="defer"></script>
</head>
<body>
	<section class="container container-main">
		<form name="login_user" class="form-signin" id="needs-validation" action="/budget_system/controller/user/user_controller.php" method="post" enctype="multipart/form-data" novalidate>
			<h1 class="form-signin-heading">Login</h1>
			<div class="form-group">
				<label>E-mail:</label>
				<input type="email" class="form-control" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="login@exemplo.com" required="required"/>
			</div>
			<div class="form-group">
				<label>Senha:</label>
				<input type="password" class="form-control" name="password" placeholder="**********" required="required" />
			</div>
			<div class="input input_btn">
				<div>
					<button type="submit" class="btn btn-lg btn-primary btn-block" name="btn_login">Entrar</button>
				</div>
			</div>
		</form>
		<?php
		if (isset($_GET['erro']))
		{
			$erro = str_replace('/',' ',$_GET['erro']);
		?>
			<div class="alert alert-danger alert-dismissible fade show container-alert" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<span class="align-middle"><?= $erro ?></span>
			</div>
		<?php
			}
		?>
	</section>
	<script>
	// Example starter JavaScript for disabling form submissions if there are invalid fields
	(function() {
	  window.addEventListener("load", function() {
	    var form = document.getElementById("needs-validation");
	    form.addEventListener("submit", function(event) {
	      if (form.checkValidity() == false) {
	        event.preventDefault();
	        event.stopPropagation();
	      }
	      form.classList.add("was-validated");
	    }, false);
	  }, false);
	}());
	</script>
	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/budget_system/app/css/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>