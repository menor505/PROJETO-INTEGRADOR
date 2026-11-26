<?php
/*
   EXCLUIR.PHP - apagar produto (só admin)

   1. exigir_admin(): só admin entra.
   2. Confere se o produto aparece em itens_pedido. Se aparecer, NÃO apaga
      (a chave estrangeira do banco não deixa) e volta com ?erro=em_pedido.
   3. Se não aparecer em nenhum pedido, faz o DELETE.
*/

require_once("funcoes.php");
exigir_admin();

require("conexao.php");

$id = (int) $_GET['id'];

$pedidos = mysqli_query($conexao, "SELECT id FROM itens_pedido WHERE produto_id = $id LIMIT 1");

if (mysqli_num_rows($pedidos) > 0) {
    header("Location: editar.php?erro=em_pedido");
    exit;
}

mysqli_query($conexao, "DELETE FROM produtos WHERE id = $id");

header("Location: editar.php");
exit;