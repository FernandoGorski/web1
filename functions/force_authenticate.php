<?php

  require "authenticate.php";

  if(!$login || $user_id != "1"){
    die("Você não tem permissão para acessar essa página.");
  }

?>
