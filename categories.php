<?php
  require "functions/authenticate.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Categorias</title>
    <title>Document</title>
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
            <a href="index.php">
                <button class="btn btn-outline-info col-sm-15" type="button">Voltar</button>
            </a>
    </nav>

    <div class="conteiner">
      <div class="row justify-content-center align-items-center vh-100">
        <div class="col-auto">
          <form action="posts.php" method="get">
            <div class="d-grid gap-3">
            <input class="btn btn-outline-primary col-sm-15" type="submit" name="categoria" value="Categoria">
            <input class="btn btn-outline-primary col-sm-15" type="submit" name="categoria" value="Categoria 1">
            <input class="btn btn-outline-primary col-sm-15"type="submit" name="categoria" value="Categoria 2">
            <input class="btn btn-outline-primary col-sm-15"type="submit" name="categoria" value="Categoria 3">
                </div>
          </form>
        </div>
      </div>
    </div>

</body>
</html>
