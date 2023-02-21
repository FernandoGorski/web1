<?php
    require "functions/authenticate.php";
    require_once "db/db_credentials.php";
    require_once "functions/sanitize.php";

    $conn = mysqli_connect($servername, $username, $db_password, $dbname);
    $error_senha = false;

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Verifica se o metodo de requisição é post

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica se os campos nova-senha, confirmação e senha foram enviados
        if (isset($_POST["nova-senha"]) && isset($_POST["confirmacao"]) && isset($_POST["senha"])) {
            
            // Formatação
            $nova = mysqli_real_escape_string($conn,sanitize($_POST["nova-senha"]));
            $confirmacao = mysqli_real_escape_string($conn,sanitize($_POST["confirmacao"]));
            $senha = mysqli_real_escape_string($conn,sanitize($_POST["senha"]));

            // SQL para pegar as informações do usuário para uso futuro
            $sql = "SELECT id, password FROM $table_users
                    WHERE id = '$user_id';";

            $result = mysqli_query($conn, $sql);
            if($result){
                if (mysqli_num_rows($result) > 0) {
                    $user = mysqli_fetch_assoc($result);
                }
            }
            // SQL para alteração da senha do usuário + confirmando senhas
            if ($nova == $confirmacao && md5($senha) == $user["password"]) {
                $nova = md5($nova);
      
                $sql = "UPDATE $table_users
                SET password = '$nova'
                WHERE id = '$user_id'";

                // Após alterar a senha, desconectar o usuário
                if (!mysqli_query($conn, $sql)) {
                    $error_msg = "Erro ao altera senha";
                } else {
                    mysqli_close($conn);
                    header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
                    exit();
                }  
            } 

            // Bloco para o caso de erro de senha
            else {
                $error_senha = true;
                $error_msg = "Senha atual ou confirmação está incorreta";
            }
        }

        // Verifica se os campos novo-nome e senha foram enviados
        if (isset($_POST["novo-nome"]) && isset($_POST["senha-nome"])) {
            
            // Formatação
            $novo = mysqli_real_escape_string($conn,sanitize($_POST["novo-nome"]));
            $senha = mysqli_real_escape_string($conn,sanitize($_POST["senha-nome"]));

            // SQL para pegar informações do usuário para uso futuro
            $sql = "SELECT id, name, password FROM $table_users
                    WHERE id = '$user_id';";

            $result = mysqli_query($conn, $sql);
            if($result){
                if (mysqli_num_rows($result) > 0) {
                    $user = mysqli_fetch_assoc($result);
                }
            }
            
            // SQL para alteração do nome do usuário caso acerte a senha
            if (md5($senha) == $user["password"]) {
                $sql = "UPDATE $table_users
                SET name = '$novo'
                WHERE id = '$user_id'";

                // Redirecionar o usuário para o index + alterar o nome na sessão
                if (!mysqli_query($conn, $sql)) {
                    $error_msg = "Erro ao alterar o nome";
                } else {
                    $_SESSION["user_name"] = $novo;
                    mysqli_close($conn);
                    header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
                    exit();
                }
            } 
            // Caso erro de senha
            else {
                $error_senha = true;
                $error_msg = "Senha está incorreta";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="js/alter_lp.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

    <!-- Caso tenha errado a senha -->
    <?php if ($error_senha): ?>
        <div class="erros">
            <h3> <?= $error_msg ?> </h3>
        </div>
    <?php endif; ?>
    
    <!-- Usuário quer alterar o nome -->
    <?php if(isset($_POST["nome"])):?>
        
        <!-- Voltar para o index -->
        <nav class="navbar navbar-dark bg-primary fixed-top">
            <div class="container-fluid ">
                <h1 class="navbar-text">Alterar Nome</h1>
                <a href="index.php">
                    <button class="btn btn-outline-info col-sm-15" type="button">Voltar</button>
                </a>
            </div>
        </nav>

        <!-- Formulario para a alteração do nome -->
        <form action="<?= $_SERVER['PHP_SELF']?>" method="post" id="form-alterar-nome">
            <div class="conteiner">
                <div class="row justify-content-center align-items-center vh-100">
                    <div class="col-auto">
                        <div class="col-sm-10">
                            <div class="row mt-2">
                                Novo nome:
                                <input class="form-control" type="text" name="novo-nome" placeholder="Novo nome" value="<?= $user_name?>">
                                <input type="hidden" name="nome" value="1">
                            </div>
                            <div class="row mt-2">
                                Senha atual:
                                <input class="form-control" type="password" name="senha-nome" placeholder="Senha">
                            </div>
                            <div class="row mt-2">
                                <input class="btn btn-primary col-sm-15" type="submit" name="submit" value="Enviar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>               
    <?php endif;?>

    <!-- Usuário quer alterar a senha -->
    <?php if(isset($_POST["senha"])):?>

        <!-- Voltar para o index -->
        <nav class="navbar navbar-dark bg-primary fixed-top">
            <div class="container-fluid ">
                <h1 class="navbar-text">Alterar Senha</h1>
                <a href="index.php">
                    <button class="btn btn-outline-info col-sm-15" type="button">Voltar</button>
                </a>
            </div>
        </nav>

        <!-- Formulario para alteração da senha -->
        <form action="<?= $_SERVER['PHP_SELF']?>" method="post" id="form-alterar-senha">
            <div class="conteiner">
                <div class="row justify-content-center align-items-center vh-100">
                    <div class="col-auto">
                        <div class="col-sm-10">
                            <div class="row mt-2">
                                Nova senha:
                                <input class="form-control" type="password" name="nova-senha" placeholder="Nova senha">
                            </div>
                            <div class="row mt-2">
                                Confirmação:
                                <input class="form-control" type="password" name="confirmacao" placeholder="Confirmação">
                            </div>
                            <div class="row mt-2">
                                Senha atual:
                                <input class="form-control" type="password" name="senha" placeholder="Senha">
                            </div>
                            <div class="row mt-2">
                                <input class="btn btn-primary col-sm-15" type="submit" name="submit" value="Enviar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php endif;?>
</body>
</html>