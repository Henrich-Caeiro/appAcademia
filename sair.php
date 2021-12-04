<?php
require_once "sessao.php";

    if(isset($_SESSION["login"])){
        session_unset();
        session_destroy();
    }
    header("Location: login.php");
    die;