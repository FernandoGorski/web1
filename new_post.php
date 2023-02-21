<?php 
    require_once "db/db_credentials.php";
    require "functions/force_authenticate.php";
    require_once "functions/sanitize.php";

    $conn = mysqli_connect($servername, $username, $db_password,$dbname);
    if (!$conn) {
        die("Problemas ao conectar com o BD!<br>" . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["submit"]) && $_POST["submit"] == "Enviar") {
            $error = false;
            $error_msg = "";

            $titulo = $_POST["form-title"];
            $conteudo = $_POST["form-content"];
            $categoria = $_GET["categoria"];
            $titulo = mysqli_real_escape_string($conn, sanitize($titulo));
            $categoria = mysqli_real_escape_string($conn, sanitize($categoria));

            $sql = "INSERT INTO $table_posts (titulo, conteudo, autor_id, categoria) VALUES ('$titulo', '$conteudo', '$user_id', '$categoria')";

            if (!mysqli_query($conn, $sql)) {
                $error = true;
                $error_msg = "Ocorreu um erro ao tentar criar o post, tente novamente mais tarde.";
            } else {
                mysqli_close($conn);
                header("Location: posts.php?categoria=$categoria");
                exit;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Novo Post</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="js/new_post.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

    <?php if ($error): ?>
      <h3> <?= $error_msg ?> </h3>
    <?php endif; ?>

    <nav class="navbar navbar-dark bg-primary fixed-top">
        <div class="container-fluid ">
            <h1 class="navbar-text">Categoria</h1>
            <a href="index.php">
                <button class="btn btn-outline-info col-sm-15" type="button">Voltar</button>
            </a>
        </div>
    </nav>

    <div class="conteiner">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-auto">
                <form action="<?= $_SERVER['PHP_SELF'] ?>?categoria=<?=$_GET["categoria"] ?>" method="post" id="form-post"><br>
                    Título:
                    <input class="form-control" type="text" name="form-title" placeholder="Seu título">
                    Conteúdo:
                    <textarea class="form-control" name="form-content" rows="12" cols="120" placeholder="Conteúdo"></textarea><br>
                    <input class="btn btn-primary col-sm-2" type="submit" name="submit" value="Enviar">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
