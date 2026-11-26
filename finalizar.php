<?php
require_once("funcoes.php");
exigir_login();

require("conexao.php");

if (empty($_SESSION['carrinho'])) {
    header("Location: carrinho.php");
    exit;
}

$usuario_id = (int) $_SESSION['id'];
$total = 0;
$precos = [];
// pega o preço de cada produto e calcula 
foreach ($_SESSION['carrinho'] as $produto_id => $qtd) {
    $r = mysqli_query($conexao, "SELECT preco FROM produtos WHERE id = " . (int) $produto_id);
    $produto = mysqli_fetch_assoc($r);

    // produto foi apagado depois de ir pro carrinho tira do carrinho
    if (!$produto) {
        unset($_SESSION['carrinho'][$produto_id]);
        continue;
    }

    $precos[$produto_id] = $produto['preco'];
    $total += $produto['preco'] * $qtd;
}

// se não sobrou nada no carrinho volta pra ele
if (empty($_SESSION['carrinho'])) {
    header("Location: carrinho.php");
    exit;
}

// cria o pedido
mysqli_query($conexao, "INSERT INTO pedidos (usuario_id, total) VALUES ($usuario_id, $total)");
$pedido_id = mysqli_insert_id($conexao);

// grava cada item
foreach ($_SESSION['carrinho'] as $produto_id => $qtd) {
    $preco = $precos[$produto_id];
    mysqli_query($conexao, "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario)
                            VALUES ($pedido_id, " . (int) $produto_id . ", " . (int) $qtd . ", $preco)");
}

unset($_SESSION['carrinho']);

header("Location: pedidos.php");
exit;