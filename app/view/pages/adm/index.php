<?php
    session_start();
    if(isset($_SESSION['permission']))
    {
        if($_SESSION['permission'] != 'adm')
        {
            $erro = 'você/não/pode/ter/acesso/a/esta/parte/do/sistema!';
            header('Location:/budget_system/app/view/pages/login/?erro='.$erro.'');
        }
    }else
    {
         $erro = 'você/não/efetuou/login/ainda!';
        header('Location:/budget_system/app/view/pages/login/?erro='.$erro.'');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel administrativo</title>
    <link rel="stylesheet" type="text/css" href="/budget_system/app/css/user.css"/>
    <link rel="stylesheet" type="text/css" href="/budget_system/app/css/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="/budget_system/app/css/font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="/budget_system/app/css/adm.css"/>
    <script type="text/javascript" src="/budget_system/app/javascript/adm/adm.js" defer="defer"></script>
    <script type="text/javascript" src="/budget_system/app/javascript/user/user.js" defer="defer"></script>
    <script type="text/javascript" src="/budget_system/app/javascript/product/product.js" defer="defer"></script>
  </head>
  <body class="container-fluid">
    <div class="row">
        <nav class="side-bar col-2 side-bar" id="sidebar">
            <div class="list-group panel">
                <!-- ITEM 1 -->
                <a href="#menu1" class="list-group-item collapsed custom-settings-a" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false">
                    <i class="fa fa-users custom-settings-icon" aria-hidden="true"></i>Usuários
                    <span class="fa fa-caret-down custom-settings-icon-arrow"></span> 
                </a>
                    <div class="collapse" id="menu1">
                        <a href="#" name="show-users" class="list-group-item sub-menu" data-toggle="collapse" aria-expanded="false">
                            <i class="fa fa-list-ul custom-settings-icon" aria-hidden="true"></i>Lista de usuários
                        </a>
                        <a href="#" name="new-user" class="list-group-item sub-menu" data-toggle="collapse" aria-expanded="false">
                            <i class="fa fa-plus-square-o custom-settings-icon" aria-hidden="true"></i>Cadastar Usuário
                        </a>
                    </div>
                <!-- ITEM 2 -->
                <a href="#menu2" class="list-group-item collapsed custom-settings-a" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false">
                    <i class="fa fa-book custom-settings-icon" aria-hidden="true"></i>Produtos
                    <span class="fa fa-caret-down custom-settings-icon-arrow"></span> 
                </a>
                    <div class="collapse" id="menu2">
                        <a href="#" name="show-products" class="list-group-item sub-menu" data-parent="#menu2" aria-expanded="false">
                            <i class="fa fa-list-ul custom-settings-icon" aria-hidden="true"></i>Lista de Produtos
                        </a>
                        <a href="#" name="new-product" class="list-group-item sub-menu" data-toggle="collapse" aria-expanded="false">
                            <i class="fa fa-plus-square-o custom-settings-icon" aria-hidden="true"></i>Cadastar Produtos
                        </a>
                    </div>

                <!-- ITEM 3 -->
                <a href="/budget_system/app/view/pages/budget/" class="list-group-item collapsed custom-settings-a" data-parent="#sidebar">
                    <i class="fa fa-crosshairs custom-settings-icon" aria-hidden="true"></i> Sistema de Orçamento
                </a>

                <!-- ITEM 3 -->
                <a href="/budget_system/controller/user/user_controller.php?logout=true" class="list-group-item collapsed custom-settings-a" data-parent="#sidebar">
                    <i class="fa fa-sign-in custom-settings-icon" aria-hidden="true"></i>Sair
                </a>
            </div>
        </nav>

        <section id="content" class="col">
             <!-- IMPORTANT ID LOOK IN adm.js, user.js, product.js -->
        </section>

        <section id="modal">
            <!-- IMPORTANT ID LOOK IN adm.js, user.js, product.js -->
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/budget_system/app/css/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>