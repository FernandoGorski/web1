<?php
  require "functions/authenticate.php";
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-dark bg-primary fixed-top">
  <div class="container-fluid ">
    <h1 class="navbar-text">Bem-vindo
      <?php if ($login): ?>
      <?="$user_name!"?>
      <?php else: ?>
        !
      <?php endif;?>
    </h1>
  </div>
</nav>
<div class="container">
  <div class="row justify-content-center align-items-center">
    <div class="col-auto">
      <p>Escolha uma das opções:</p>
    </div>
  </div>
</div>
<ul>
  <?php if ($login): ?>
    <div class="conteiner">
      <div class="row justify-content-center align-items-center vh-100">
        <div class="col-auto">
          <div class="d-grid gap-3">
            <a class="btn btn-outline-primary col-sm-15" href="categories.php">Categorias</a>
            <form action="alter_lp.php" method="post">
              <button class="btn btn-outline-primary col-sm-15" type="submit" name="nome" value="1">Alterar Nome</button>
              <button class="btn btn-outline-primary col-sm-15" type="submit" name="senha" value="1">Alterar Senha</button>
            </form>
            <a class="btn btn-outline-primary col-sm-15" href="functions/logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="conteiner ">
      <div class="row justify-content-center align-items-center vh-100">
        <div class="col-auto">
          <div class="d-grid gap-3">
            <a class="btn btn-outline-primary col-sm-15" href="login.php">Login</a>
            <a class="btn btn-outline-primary col-sm-15" href="register.php">Registrar-se</a>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</ul>
</p>
</body>
</html>
