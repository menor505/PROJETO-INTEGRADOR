<?php
/*
   FUNCOES.PHP - funções de segurança usadas em várias páginas

   - exigir_login(): abre a sessão (se ainda não estiver aberta) e confere se
     existe alguém logado ($_SESSION['id']). Se não tiver, manda para o login.php.
   - exigir_admin(): primeiro chama exigir_login() e depois confere se o tipo
     do usuário é 'admin'. Se for cliente, manda de volta para o cardápio.
   - $categorias: lista fixa das categorias de produto, usada nos <select>
     das páginas do admin (adicionar e editar).
*/

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
    exigir_login();
    if ($_SESSION['tipo'] !== 'admin') {
        header("Location: produtos.php");
        exit;
    }
}
$categorias = ['lanches', 'bebidas', 'acompanhamentos', 'variantes'];