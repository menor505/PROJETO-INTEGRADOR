<?php
require_once("funcoes.php");
exigir_login();

require("conexao.php");

// adicionar produto (vem do formulário do produtos.php)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'adicionar') {
    $id = (int) $_POST['id'];
    $quantidade = (int) $_POST['quantidade'];

    if ($quantidade < 1) {
        $quantidade = 1;
    }

    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id] += $quantidade;
    } else {
        $_SESSION['carrinho'][$id] = $quantidade;
    }

    $_SESSION['aviso'] = "Produto adicionado ao carrinho!";

    // volta para a página do cardápio (mantendo a categoria escolhida)
    $voltar = $_SERVER['HTTP_REFERER'] ?? 'produtos.php';
    header("Location: $voltar");
    exit;
}

// remover produto
if (isset($_GET['remover'])) {
    unset($_SESSION['carrinho'][(int) $_GET['remover']]);
    header("Location: carrinho.php");
    exit;
}

include("cabecalho.php");
$total = 0;
?>

<main class="editar">
    <section class="msgcd">
        <h3>Meu Carrinho</h3>
    </section>

    <?php if (empty($_SESSION['carrinho'])): ?>
    <div class="carrinho-vazio">
        <div class="vazio-emoji">🛒</div>
        <h3>Seu carrinho está vazio</h3>
        <p>Que tal pedir um lanche gostoso? Escolha no cardápio e adicione aqui.</p>
        <a class="botao" href="produtos.php">Ver cardápio</a>
    </div>
<?php else: ?>
        <?php foreach ($_SESSION['carrinho'] as $produto_id => $qtd): ?>
            <?php
            $r = mysqli_query($conexao, "SELECT nome, preco FROM produtos WHERE id = " . (int) $produto_id);
            $produto = mysqli_fetch_assoc($r);
            if (!$produto) {
                continue;
            }
            $subtotal = $produto['preco'] * $qtd;
            $total += $subtotal;
            ?>
            <div class="produto-linha">
                <span><?= htmlspecialchars($produto['nome']) ?> (x<?= $qtd ?>)</span>
                <span>R$ <?= number_format($subtotal, 2, ',', '.') ?></span>
                <a class="botao botao-excluir" href="carrinho.php?remover=<?= $produto_id ?>">Remover</a>
            </div>
        <?php endforeach; ?>

        <h3>Total: R$ <?= number_format($total, 2, ',', '.') ?></h3>

        <form action="finalizar.php" method="post">
            <button class="botao" type="submit">Finalizar pedido</button>
        </form>
    <?php endif; ?>
</main>

<?php include("rodape.php"); ?>