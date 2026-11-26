<?php
/*
   PRODUTOS.PHP - cardápio

   1. exigir_login(): só entra quem está logado.
   2. Filtro de categoria: se a URL tiver ?categoria=bebidas, filtra com WHERE.
      Se não tiver, mostra todos os produtos.
   3. SELECT DISTINCT categoria: pega as categorias que existem no banco
      para montar os botões de filtro.
   4. Aviso verde ("Produto adicionado ao carrinho!"): mostra uma vez e apaga
      da sessão (mensagem flash).
   5. Cards dos produtos: cada card tem um formulário que envia
      acao=adicionar, o id e a quantidade para o carrinho.php.
*/

require_once("funcoes.php");
exigir_login();

require("conexao.php");

$categoria = $_GET['categoria'] ?? '';

if ($categoria == '') {
    $sql = "SELECT id, nome, preco, imagem FROM produtos ORDER BY id";
} else {
    $categoria = mysqli_real_escape_string($conexao, $categoria);
    $sql = "SELECT id, nome, preco, imagem FROM produtos WHERE categoria = '$categoria' ORDER BY id";
}

$resultado = mysqli_query($conexao, $sql);

$lista = mysqli_query($conexao, "SELECT DISTINCT categoria FROM produtos");

include("cabecalho.php");
?>

<main class="cardapio">
    <h2 class="titulo-pagina">Nosso Cardápio</h2>

    <?php if (isset($_SESSION['aviso'])): ?>
        <p class="aviso"><?= $_SESSION['aviso'] ?></p>
        <?php unset($_SESSION['aviso']); ?>
    <?php endif; ?>

    <nav class="categorias">
        <a class="btn-categoria" href="produtos.php">Todos</a>
        <?php while ($c = mysqli_fetch_assoc($lista)) { ?>
            <a class="btn-categoria" href="produtos.php?categoria=<?= $c['categoria'] ?>">
                <?= ucfirst($c['categoria']) ?>
            </a>
        <?php } ?>
    </nav>

    <section class="lista-produtos">
        <?php while ($produto = mysqli_fetch_assoc($resultado)) { ?>
        <article class="produto">
            <img class="produto-img" src="/imagens/<?= $produto['imagem'] ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
            <div class="produto-info">
                <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                <p class="preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                <form method="post" action="carrinho.php">
                    <input type="hidden" name="acao" value="adicionar">
                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                    <input class="qtd" type="number" name="quantidade" value="1" min="1">
                    <button class="botao" type="submit">Adicionar</button>
                </form>
            </div>
        </article>
        <?php } ?>
    </section>
</main>

<?php include("rodape.php"); ?>