<?php
    require_once "db/db_credentials.php";
    require "functions/authenticate.php";
    require_once "functions/sanitize.php";

    $conn = mysqli_connect($servername, $username, $db_password, $dbname);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($_GET["categoria"]) && isset($_GET["acao"]) && isset($_GET["id"])) {
            $error = false;
            $error_msg = "";
            
            $id = $_GET["id"];
            $id = mysqli_real_escape_string($conn, sanitize($id));

            if($_GET["acao"] == "remover"){
                $sql = "DELETE FROM $table_posts WHERE id = '$id'";
                if(!mysqli_query($conn,$sql)){
                    $error = true;
                    $error_msg = "Ocorreu um erro ao tentar remover o post, tente novamente mais tarde.";
                }
            }
        }
    }

  
    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["categoria"])){
        $error = false;
        $error_msg = "";
        
        $categoria = $_GET["categoria"];
        $categoria = mysqli_real_escape_string($conn, sanitize($categoria));

        $sql = "SELECT * FROM posts WHERE categoria = '$categoria'";
        if(!($posts_feitos_set = mysqli_query($conn, $sql))){
            $error = true;
            $error_msg = "Ocorreu um erro ao carregar os posts, tente novamente mais tarde.";
        }
    };

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Document</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<nav class="navbar navbar-dark bg-primary fixed-top">
    <div class="container-fluid ">
        <h1 class="navbar-text">Posts</h1>
        <?php if($user_id == "1"): ?>
                <a href=" <?= "new_post.php?categoria=" . $_GET["categoria"]?>">
                    <button class="btn btn-outline-info col-sm-15" type="button">Novo Post</button>
                </a>
        <?php endif;?>
        <a href="categories.php">
            <button class="btn btn-outline-info col-sm-15" type="button">Voltar</button>
        </a>
    </div>
</nav>

<div class="lista-post">
    <?php if($posts_feitos_set && mysqli_num_rows($posts_feitos_set) > 0): ?>
        <?php while($posts = mysqli_fetch_assoc($posts_feitos_set)): ?>
            <div class="m-2">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-primary"> <?= $posts["titulo"] ?>
                    <?= $posts["data_publicacao"] ?>
                    <a href="<?= "post.php?postid=" . $posts["id"] . "&categoria=" . $_GET["categoria"]?>">
                        <button class="btn btn-outline-primary col-sm-1" type="button">Ver Post</button>
                    </a>
                    <?php if($user_id == "1" || $user_id == $posts["autor_id"]):?>
                        <a href="<?php echo $_SERVER["PHP_SELF"] . "?categoria=" . $_GET["categoria"] . "&id=" . $posts["id"] . "&" . "acao=remover"?>">
                            <button class="btn btn-outline-primary col-sm-1" type="button">Remover</button>
                        </a>     
                    <?php endif ?>
                </ul>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</body>
</html>
