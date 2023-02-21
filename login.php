<?php
require "db/db_functions.php";
require "functions/authenticate.php";
require_once "functions/sanitize.php";

$error = false;
$password = $email = "";

if (!$login && $_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["email"]) && isset($_POST["password"])) {

    $conn = connect_db();

    $email = mysqli_real_escape_string($conn,sanitize($_POST["email"]));
    $password = mysqli_real_escape_string($conn,sanitize($_POST["password"]));
    $password = md5($password);

    $sql = "SELECT id,name,email,password FROM $table_users
            WHERE email = '$email';";

    $result = mysqli_query($conn, $sql);
    if($result){
      if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($user["password"] == $password) {

          $_SESSION["user_id"] = $user["id"];
          $_SESSION["user_name"] = $user["name"];
          $_SESSION["user_email"] = $user["email"];

          header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
          exit();
        }
        else {
          $error_msg = "Usuário ou senha incorretos!";
          $error = true;
        }
      }
      else{
        $error_msg = "Usuário ou senha incorretos!";
        $error = true;
      }
    }
    else {
      $error_msg = mysqli_error($conn);
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
  <title>Login</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="login.css" type="text/css">
  <script src="js/login.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<?php if ($login): ?>
    <h3>Você já está logado!</h3>
  </body>
  </html>
  <?php exit(); ?>
<?php endif; ?>

<?php if ($error): ?>
  <div class="erros">
    <h3> <?= $error_msg ?> </h3>
  </div>
<?php endif; ?>

<nav class="navbar navbar-dark bg-primary fixed-top">
  <div class="container-fluid ">
      <div class="col-auto">
        <h1 class="navbar-text">Dados para iniciar o Login</h1>
      </div>
    </div>
</nav>

  <form action="login.php" method="post" id="form-login">
    <div class="conteiner">
      <div class="row justify-content-center align-items-center vh-100">
        <div class="col-auto">

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

          <div class="d-grid gap-2 d-md-block">
            <input type="submit" class="btn btn-primary col-sm-5" name="submit" value="Entrar">
            <a class="btn btn-primary col-sm-5" href="index.php">Voltar</a>
          </div>
        </div>
      </div>
    </div>
  </form>
</p>
</body>
</html>