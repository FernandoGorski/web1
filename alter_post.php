<?php 
    require_once "db/db_credentials.php";
    require "functions/authenticate.php";
    require_once "functions/sanitize.php";


    $conn = mysqli_connect($servername, $username, $db_password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["acao"]) && isset($_POST["postid"])) {
            $error = false;
            $error_msg = "";

            $post = $_POST["postid"];

            if($_POST["acao"] == "post" && isset($_POST["form-title"]) && isset($_POST["form-content"])){
                $titulo = $_POST["form-title"];
                $conteudo = $_POST["form-content"];
                $titulo = mysqli_real_escape_string($conn, sanitize($titulo));
                $conteudo = mysqli_real_escape_string($conn, sanitize($conteudo));

                $sql = "UPDATE $table_posts
                        SET titulo = '$titulo', conteudo = $conteudo
                        WHERE id = '$post'";
                
                if(!mysqli_query($conn,$sql)){
                    $error = true;
                    $error_msg = "Ocorreu um erro ao tentar alterar o post, tente novamente mais tarde.";
                }
                else {
                    header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/categories.php");
                    exit();
                }   
            }
            if($_POST["acao"] == "comment" && isset($_POST["new_comment"])){
                $comentario = $_POST["new_comment"];
                $comentario = mysqli_real_escape_string($conn, sanitize($comentario));
                $user = $_SESSION["user_id"];
                $commentid = $_POST["commentid"];

                $sql = "UPDATE $table_comments
                        SET content = '$comentario'
                        WHERE post_id = $post AND autor_id = $user AND id = $commentid";
                
                if(!mysqli_query($conn,$sql)){
                    $error = true;
                    $error_msg = "Ocorreu um erro ao tentar alterar o comentario, tente novamente mais tarde.";
                } 
                else {
                    header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/categories.php");
                    exit();
                }
            }
        }
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="js/alter_post.js"></script>
    <title>Alterar</title>
</head>
<body>
    <?php if($_POST["acao"] == "post"):?>
        <div class="conteiner">
            <div class="row justify-content-center align-items-center vh-100">
                <div class="col-auto">
                    <form action="<?= $_SERVER['PHP_SELF']?>" method="post" id="form-alterar-post">
                        Título:
                        <input class="form-control" type="text" name="form-title" value="<?= $_POST["titulo"]?>">
                        Conteúdo:
                        <textarea class="form-control" name="form-content" rows="12" cols="120"><?=$_POST["conteudo"]?></textarea>
                        <input type="hidden" name="acao" value="<?= $_POST["acao"]?>">
                        <input type="hidden" name="postid" value="<?= $_POST["postid"]?>">
                        <input class="btn btn-primary col-sm-2" type="submit" name="submit" value="Enviar">
                    </form>
                </div>
            </div>
        </div>
    <?php endif;?>

    <?php if($_POST["acao"] == "comment"):?>
        <div class="conteiner">
            <div class="row justify-content-center align-items-center vh-100">
                <div class="col-auto">
                    <form action="<?= $_SERVER['PHP_SELF']?>" method="post" id="form-alterar-comentario">
                        Editar Comentario:
                        <textarea class="form-control" name="new_comment" rows="12" cols="120"><?=$_POST["comentario"]?></textarea>
                        <input type="hidden" name="acao" value="<?= $_POST["acao"]?>">
                        <input type="hidden" name="postid" value="<?= $_POST["postid"]?>">
                        <input type="hidden" name="commentid" value="<?= $_POST["commentid"]?>">
                        <input class="btn btn-primary col-sm-2" type="submit" name="submit" value="Enviar">
                    </form>
                </div>
            </div>
        </div>
    <?php endif;?>

    <nav class="navbar navbar-dark bg-primary fixed-top">
        <div class="container-fluid ">
            <h1 class="navbar-text">Alterar</h1>
            <a href="index.php">
                <button class="btn btn-outline-info col-sm-15" type="button">Voltar</button>
            </a>
        </div>
    </nav>

    <?php if ($error): ?>
        <?= $error_msg ?>
    <?php endif; ?>

</body>
</html>