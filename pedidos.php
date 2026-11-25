<?php
require_once("funcoes.php");
exigir_login();

require("conexao.php");

$id = (int) $_SESSION['id'];

if ($_SESSION['tipo'] === 'admin') {
    $sql = "SELECT p.*, u.nome FROM pedidos p JOIN usuarios u ON u.id = p.usuario_id ORDER BY p.id DESC";
} else {
    $sql = "SELECT p.*, u.nome FROM pedidos p JOIN usuarios u ON u.id = p.usuario_id WHERE p.usuario_id = $id ORDER BY p.id DESC";
}
$pedidos = mysqli_query($conexao, $sql);

include("cabecalho.php");
?>

<main class="editar">
    <section class="msgcd">
        <h3><?= $_SESSION['tipo'] === 'admin' ? 'Todos os Pedidos' : 'Meus Pedidos' ?></h3>
    </section>

    <?php while ($pedido = mysqli_fetch_assoc($pedidos)): ?>
        <div class="produto-linha pedido">
            <strong>Pedido #<?= $pedido['id'] ?></strong>
            <span><?= htmlspecialchars($pedido['nome']) ?></span>
            <span><?= date('d/m/Y H:i', strtotime($pedido['criado_em'])) ?></span>
            <span>Status: <?= $pedido['status'] ?></span>
            <strong>R$ <?= number_format($pedido['total'], 2, ',', '.') ?></strong>

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