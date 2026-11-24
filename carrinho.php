<?php
require_once("funcoes.php");
exigir_login();

require("conexao.php");

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];

    if ($_POST['acao'] == 'adicionar') {
        $quantidade = (int) $_POST['quantidade'];

        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id] += $quantidade;
        } else {
            $_SESSION['carrinho'][$id] = $quantidade;
        }
    }

    if ($_POST['acao'] == 'remover') {
        unset($_SESSION['carrinho'][$id]);
    }

    header("Location: carrinho.php");
    exit;
}

include("cabecalho.php");
?>

<main class="cardapio">
    <h2 class="titulo-pagina">Meu Carrinho</h2>

    <?php if (count($_SESSION['carrinho']) == 0) { ?>
        <p class="vazio">Seu carrinho está vazio.</p>
    <?php } else { ?>

        <table class="tabela-carrinho">
            <tr>
                <th>Produto</th>
                <th>Qtd</th>
                <th>Subtotal</th>
                <th></th>
            </tr>

            <?php
            $total = 0;
            foreach ($_SESSION['carrinho'] as $id => $quantidade) {
                $resultado = mysqli_query($conexao, "SELECT nome, preco FROM produtos WHERE id = $id");
                $p = mysqli_fetch_assoc($resultado);
                $subtotal = $p['preco'] * $quantidade;
                $total = $total + $subtotal;
            ?>
                <tr>
                    <td><?= $p['nome'] ?></td>
                    <td><?= $quantidade ?></td>
                    <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="acao" value="remover">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <button class="btn-remover" type="submit">Remover</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <p class="total">Total: R$ <?= number_format($total, 2, ',', '.') ?></p>

    <?php } ?>
</main>

<?php include("rodape.php"); ?>