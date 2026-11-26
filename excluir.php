<?php
require_once("funcoes.php");
exigir_admin();

require("conexao.php");

$id = (int) $_GET['id'];

// se o produto já aparece em algum pedido, o banco não deixa apagar (chave estrangeira)
$pedidos = mysqli_query($conexao, "SELECT id FROM itens_pedido WHERE produto_id = $id LIMIT 1");

if (mysqli_num_rows($pedidos) > 0) {
    header("Location: editar.php?erro=em_pedido");
    exit;
}

mysqli_query($conexao, "DELETE FROM produtos WHERE id = $id");

header("Location: editar.php");
exit;