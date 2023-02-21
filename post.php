<?php 
    require_once "db/db_credentials.php";
    require "functions/authenticate.php";
    require_once "functions/sanitize.php";

    $conn = mysqli_connect($servername, $username, $db_password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $post_id = $_GET["postid"];

    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["categoria"])){
        $error = false;
        $error_msg = "";
        
        $id = $_GET["postid"];
        $id = mysqli_real_escape_string($conn, sanitize($id));

        $sql = "SELECT titulo, conteudo, data_publicacao FROM posts WHERE id = '$id'";
        if(!($post = mysqli_query($conn, $sql))){
            $error = true;
            $error_msg = "Ocorreu um erro ao tentar acessar o banco de dados, tente novamente mais tarde.";
        };
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["form_comment"]) && !empty($_POST["form_comment"])) {
        $error = false;
        $error_msg = "";
        
        $comentario = mysqli_real_escape_string($conn, sanitize($_POST["form_comment"]));

        $sql = "INSERT INTO $table_comments (post_id, autor_id, content) VALUES ('$post_id', '$user_id', '$comentario')";

        if (mysqli_query($conn, $sql)) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?postid=" . $post_id . "&categoria=" . $_GET['categoria']);
            exit();
        } else {
            $error = true;
            $error_msg = "Ocorreu um erro ao tentar fazer o comentario, tente novamente mais tarde.";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($_GET["commentid"])) {
            $error = false;
            $error_msg = "";
            
            $id = $_GET["commentid"];
            $id = mysqli_real_escape_string($conn, sanitize($id));

            if($_GET["acao"] == "remover"){
                $sql = "DELETE FROM $table_comments WHERE id = '$id'";
                if(!mysqli_query($conn,$sql)){
                    $error = true;
                    $error_msg = "Ocorreu um erro ao tentar remover o comentario, tente novamente mais tarde.";
                }
            }
        }
    };

    $sql = "SELECT $table_users.name AS user_name, 
            $table_comments.data_plubicacao AS comment_date,
            $table_comments.content AS comment_content,
            $table_comments.autor_id AS autor_id,
            $table_comments.id AS comment_id
            FROM $table_comments
            JOIN $table_users ON $table_comments.autor_id = $table_users.id
            JOIN $table_posts ON $table_comments.post_id = $table_posts.id
            WHERE $table_posts.id = $post_id";

    if ($comentarios_post = mysqli_query($conn, $sql)) {
        $num_comentarios = mysqli_num_rows($comentarios_post);
    } else {
        die("Problemas para carregar comentários do BD!<br>" . mysqli_error($conn));
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="js/post.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<?php if ($error): ?>
  <div class="erros">
    <h3> <?= $error_msg ?> </h3>
  </div>
<?php endif; ?>

      <nav class="navbar navbar-dark bg-primary fixed-top">
        <div class="container-fluid ">
            <h1 class="navbar-text">Posts</h1>
            <a href="<?="posts.php?categoria=" . $_GET["categoria"]?>">
                <button class="btn btn-outline-info col-sm-15" type="button">Voltar</button>
            </a>
        </div>
    </nav>


<div class="lista-post">
    <div class="m-2">
    <?php if($post && mysqli_num_rows($post) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($post)): ?>
            
            <div class="row justify-content-center align-items-center">
                <div class=" col-auto">
                    <h1><?= $row["titulo"]?></h1>
                    <p><em>Publicado em: <?= $row["data_publicacao"]?></em></p>
                    <p><?= $row["conteudo"]?></p>
                    
                    <!-- Alterar Post -->
                    <?php if($user_id == "1"):?>
                        <form action="alter_post.php" method="post">
                            <input type="hidden" name="acao" value="post">
                            <input type="hidden" name="postid" value="<?= $_GET["postid"]?>"> 
                            <input type="hidden" name="titulo" value="<?= $row["titulo"]?>">
                            <input type="hidden" name="conteudo" value="<?= $row["conteudo"]?>">
                            <button class="btn btn-outline-primary col-sm-15" type="submit">Alterar</button>
                        </form>     
                    <?php endif ?>
        <?php endwhile; ?>
    <?php endif; ?>

    <form action="<?= $_SERVER['PHP_SELF'] . '?postid=' . $_GET['postid'] . '&categoria=' . $_GET['categoria'] ?>" method="post" id="form-comment">
        <label for="form_comment">Fazer um comentário:</label>
        <textarea class="form-control" name="form_comment" id="form_comment" rows="8" cols="80" placeholder="Seu comentário"></textarea>
        <input class="btn btn-primary col-sm-2" type="submit" name="submit" value="Enviar">
    </form>
    </div>

    <?php if($comentarios_post && mysqli_num_rows($comentarios_post) > 0): ?>
        <h2>Comentários</h2>
        <?php while($row = mysqli_fetch_assoc($comentarios_post)): ?>
            <div class="m-2">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-primary">
            
                        <p><strong><?= $row["user_name"]?></strong></p>
                        <p><em>Publicado em: <?= $row["comment_date"]?></em></p>
                        <p><?= $row["comment_content"]?></p>
            

                        <?php if($user_id == "1" || $user_id == $row["autor_id"]):?>
                            <form action="<?= $_SERVER["PHP_SELF"]?>" method="get">
                                <input type="hidden" name="postid" value="<?= $_GET['postid']?>">
                                <input type="hidden" name="categoria" value="<?= $_GET['categoria']?>">
                                <input type="hidden" name="acao" value="remover">
                                <input type="hidden" name="commentid" value="<?= $row["comment_id"]?>">
                                <button class="btn btn-outline-primary col-sm-2" type="submit">Remover</button>
                            </form>
                            <form action="alter_post.php" method="post">
                                <input type="hidden" name="commentid" value="<?= $row["comment_id"]?>">
                                <input type="hidden" name="acao" value="comment">
                                <input type="hidden" name="postid" value="<?= $_GET["postid"]?>">
                                <input type="hidden" name="comentario" value="<?= $row["comment_content"]?>">
                                <button class="btn btn-outline-primary col-sm-2 mt-1" type="submit">Alterar</button>
                            </form> 
                        <?php endif ?>
                    </li>
                </ul>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
            </div>
        </div>
</div>       
</body>
</html>

