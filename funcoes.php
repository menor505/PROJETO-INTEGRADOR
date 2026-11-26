<?php
function exigir_login() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit;
    }
}

function exigir_admin() {
    exigir_login(); // primeiro confere se está logado
    if ($_SESSION['tipo'] !== 'admin') {
        header("Location: produtos.php"); // logad o mas nao é admin
        exit;
    }
}
$categorias = ['lanches', 'bebidas', 'acompanhamentos', 'variantes'];