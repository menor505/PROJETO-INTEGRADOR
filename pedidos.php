<?php
/*
   PEDIDOS.PHP - lista de pedidos

   1. Admin mudando o status (POST): só funciona se for admin.
      Faz o UPDATE do status (cortado em 20 caracteres com substr).
   2. Qual lista mostrar:
      - admin vê TODOS os pedidos;
      - cliente vê só os dele (WHERE usuario_id = id da sessão);
      - o JOIN com usuarios traz o nome de quem fez o pedido.
   3. Cada pedido mostra número, nome, data (d/m/Y H:i) e total.
      O admin ganha um campo para editar o status; o cliente só vê o status.
   4. Itens do pedido: outro SELECT com JOIN em produtos mostra
      "2x X-Burguer", "1x Refrigerante" etc.
*/

require_once("funcoes.php");
exigir_login();

require("conexao.php");

$id = (int) $_SESSION['id'];
$eh_admin = ($_SESSION['tipo'] === 'admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $eh_admin) {
    $pedido_id = (int) $_POST['pedido_id'];
    $status = mysqli_real_escape_string($conexao, substr($_POST['status'], 0, 20));

    mysqli_query($conexao, "UPDATE pedidos SET status = '$status' WHERE id = $pedido_id");

    header("Location: pedidos.php");
    exit;
}

if ($eh_admin) {
    $sql = "SELECT p.*, u.nome FROM pedidos p JOIN usuarios u ON u.id = p.usuario_id ORDER BY p.id DESC";
} else {
    $sql = "SELECT p.*, u.nome FROM pedidos p JOIN usuarios u ON u.id = p.usuario_id WHERE p.usuario_id = $id ORDER BY p.id DESC";
}
$pedidos = mysqli_query($conexao, $sql);

include("cabecalho.php");
?>

<main class="editar">
    <section class="msgcd">
        <h3><?= $eh_admin ? 'Todos os Pedidos' : 'Meus Pedidos' ?></h3>
    </section>

    <?php while ($pedido = mysqli_fetch_assoc($pedidos)): ?>
        <div class="produto-linha pedido">
            <strong>Pedido #<?= $pedido['id'] ?></strong>
            <span><?= htmlspecialchars($pedido['nome']) ?></span>
            <span><?= date('d/m/Y H:i', strtotime($pedido['criado_em'])) ?></span>
            <strong>R$ <?= number_format($pedido['total'], 2, ',', '.') ?></strong>

            <?php if ($eh_admin): ?>
                <form method="post" class="form-status">
                    <input type="hidden" name="pedido_id" value="<?= $pedido['id'] ?>">
                    <input type="text" name="status" maxlength="20" value="<?= htmlspecialchars($pedido['status']) ?>" required>
                    <button class="botao" type="submit">Salvar</button>
                </form>
            <?php else: ?>
                <span class="status">Status: <?= htmlspecialchars($pedido['status']) ?></span>
            <?php endif; ?>

            <ul>
                <?php
                $itens = mysqli_query($conexao, "SELECT i.quantidade, pr.nome
                                                 FROM itens_pedido i
                                                 JOIN produtos pr ON pr.id = i.produto_id
                                                 WHERE i.pedido_id = " . $pedido['id']);
                while ($item = mysqli_fetch_assoc($itens)):
                ?>
                    <li><?= $item['quantidade'] ?>x <?= htmlspecialchars($item['nome']) ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    <?php endwhile; ?>
</main>

<?php include("rodape.php"); ?>