<?php
/*
   FINALIZAR.PHP - fecha o pedido (não tem tela, só processa e redireciona)

   1. Se o carrinho estiver vazio, volta para o carrinho.
   2. Busca o preço de cada produto NO BANCO (segurança: o preço não vem do
      navegador, então ninguém consegue trapacear) e calcula o total.
   3. Produto que foi apagado depois de ir pro carrinho é removido dele.
   4. INSERT INTO pedidos: cria o pedido com o usuário e o total.
   5. mysqli_insert_id(): pega o id do pedido que acabou de ser criado.
   6. INSERT INTO itens_pedido: grava cada item com o preco_unitario do momento
      (se o preço mudar depois, o pedido antigo continua com o valor certo).
   7. Esvazia o carrinho e manda para a página de pedidos.
*/

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
foreach ($_SESSION['carrinho'] as $produto_id => $qtd) {
    $r = mysqli_query($conexao, "SELECT preco FROM produtos WHERE id = " . (int) $produto_id);
    $produto = mysqli_fetch_assoc($r);

    if (!$produto) {
        unset($_SESSION['carrinho'][$produto_id]);
        continue;
    }

    $precos[$produto_id] = $produto['preco'];
    $total += $produto['preco'] * $qtd;
}

if (empty($_SESSION['carrinho'])) {
    header("Location: carrinho.php");
    exit;
}

mysqli_query($conexao, "INSERT INTO pedidos (usuario_id, total) VALUES ($usuario_id, $total)");
$pedido_id = mysqli_insert_id($conexao);

foreach ($_SESSION['carrinho'] as $produto_id => $qtd) {
    $preco = $precos[$produto_id];
    mysqli_query($conexao, "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario)
                            VALUES ($pedido_id, " . (int) $produto_id . ", " . (int) $qtd . ", $preco)");
}

unset($_SESSION['carrinho']);

header("Location: pedidos.php");
exit;