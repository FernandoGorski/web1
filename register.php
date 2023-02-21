<?php
require "db/db_functions.php";
require_once "functions/sanitize.php";


$error = false;
$success = false;
$name = $email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {

    $conn = connect_db();

    $name = mysqli_real_escape_string($conn,sanitize($_POST["name"]));
    $email = mysqli_real_escape_string($conn,sanitize($_POST["email"]));
    $password = mysqli_real_escape_string($conn,sanitize($_POST["password"]));
    $confirm_password = mysqli_real_escape_string($conn,sanitize($_POST["confirm_password"]));

    if ($password == $confirm_password) {
      $password = md5($password);

      $sql = "INSERT INTO $table_users
              (name, email, password) VALUES
              ('$name', '$email', '$password');";

      if(mysqli_query($conn, $sql)){
        $success = true;
      }
      else {
        $error_msg = mysqli_error($conn);
        $error = true;
      }
    }
    else {
      $error_msg = "Senha não confere com a confirmação.";
      $error = true;
    }
  }
  else {
    $error_msg = "Por favor, preencha todos os dados.";
    $error = true;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>[WEB 1] Exemplo Sistema de Login - Registro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="js/register.js"></script>
</head>
<body>

<?php if ($success): ?>
  <h3 style="color:lightgreen;">Usuário criado com sucesso!</h3>
  <p>
    Seguir para <a href="login.php">login</a>.
  </p>
<?php endif; ?>

<?php if ($error): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
<?php endif; ?>

<nav class="navbar navbar-dark bg-primary fixed-top">
  <div class="container-fluid ">
    <div class="col-auto">
      <div class="row justify-content-center align-items-center">
        <div class="col-auto">
          <h1 class="navbar-text">Dados para registro de novo usuário</h1>
        </div>
      </div>
    </div>
  </div>
</nav>

<?php if ($success): ?>
  <h3 style="color:lightgreen;">Usuário criado com sucesso!</h3>
  <p>
    Seguir para <a href="login.php">login</a>.
  </p>
<?php endif; ?>


<form action="register.php" method="post" id="form-register">
  <div class="conteiner">
    <div class="row justify-content-center align-items-center vh-100">
      <div class="col-auto">

        <div class="row mb-1">
          <label for="inputName3" class="col-form-label">Nome: </label>
          <div class="col-sm-10">
            <input type="name" class="form-control" id="inputName3" name="name" value="<?php echo $name; ?>" required><br>
          </div>
        </div>

        <div class="row mb-1">
          <label for="inputEmail3" class="col-form-label">Email: </label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="inputEmail3" name="email" value="<?php echo $email; ?>" required><br>
          </div>
        </div>

        <div class="row mb-1">
          <label for="inputPassword3" class="col-form-label">Senha: </label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword3" name="password" value="" required><br>
          </div>
        </div>

        <div class="row mb-1">
          <label for="inputPassword3" class="col-form-label">Confirmação da Senha: </label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword3" name="confirm_password" value="" required><br>
          </div>
        </div>

        <div class="d-grid gap-2 d-md-block">
          <input type="submit" class="btn btn-primary col-sm-5" name="submit" value="Criar usuário">
          <a class="btn btn-primary col-sm-5" href="index.php">Voltar</a>
        </div>

      </div>
    </div>
  </div>
</form>

</p>
</body>
</html>