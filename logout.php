<?php
/*
   LOGOUT.PHP - sair da conta

   - Esvazia a sessão, destrói ela e volta para a página inicial.
*/

session_start();
$_SESSION = [];
session_destroy();

header("Location: index.php");
exit;