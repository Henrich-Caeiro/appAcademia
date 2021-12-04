<?php
require_once "sessao.php";

// arquivo que verifica se iniciou ou não uma sessão

  if (sizeof($_SESSION) != 0) {
    header("Location: home.php");
    die;
  }
  else {
    header("Location: login.php");
    die;
  }

 ?>
