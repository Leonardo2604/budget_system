<?php session_start(); 
	if(!isset($_SESSION['name'], $_SESSION['id'], $_SESSION['email'])){
		$erro = 'você/não/pode/ter/acesso/a/esta/parte/do/sistema!';
        header('Location:/budget_system/app/view/pages/login/?erro='.$erro.'');
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8"/>
	<title>Store</title>
	<link rel="stylesheet" type="text/css" href="/budget_system/app/css/bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/budget_system/app/css/font-awesome-4.7.0/css/font-awesome.min.css"/>
	<link rel="stylesheet" type="text/css" href="/budget_system/app/css/budget.css"/>
	<script type="text/javascript" src="../../../javascript/budget/budget.js" defer="defer"></script>
</head>
<body>
	<header class="container-fluid custom-container">
		<nav class="navbar navbar-default navbar-static-top" role="navigation">
			<h3>Olá <?= $_SESSION['name'] ?></h3>
			<ul class="nav navbar-top-links navbar-right">
				<li class="dropdown dropdown-menu-right">
		            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
		                <?= $_SESSION['email'] ?>
		            </a>
		            <ul class="dropdown-menu custom-dropdown-right">
		                <li>
		                	<a href="/budget_system/controller/user/user_controller.php?logout=true">
		                		<i class="fa fa-sign-out fa-fw"></i> Sair
		                	</a>
		                </li>
		            </ul>
		            <!-- /.dropdown-user -->
		        </li>
		    </ul>
		</nav>
	</header>
	<section class="row container-fluid">
		<aside class="col-2">
			<header class="header_aside">
				<div class="form-group">
					<input type="text" class="form-control" pattern="[^'\x22]+" name="text_search" autocomplete="true" placeholder="Pesquisar..." />
				</div>
			</header>
			<section id="products" class="">
				<!--IMPORTANT NAME CLASS LOOK budget.js function search-->
			</section>
		</aside>
		<section id="products_list" class="col">
				<!--IMPORTANT NAME CLASS LOOK budget.js function add_to_budget-->
		</section>
	</section>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/budget_system/app/css/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>