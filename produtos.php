<?php
require_once("funcoes.php");
exigir_login();

require("conexao.php");

// categoria escolhida na URL (vazio = todos)
$categoria = $_GET['categoria'] ?? '';

if ($categoria == '') {
    $sql = "SELECT id, nome, preco FROM produtos";
} else {
    $categoria = mysqli_real_escape_string($conexao, $categoria);
    $sql = "SELECT id, nome, preco FROM produtos WHERE categoria = '$categoria'";
}

// Busca os preços e os ids no banco e guarda pelo nome do produto
$resultado = mysqli_query($conexao, $sql);
$precos = [];
$ids = [];
while ($linha = mysqli_fetch_assoc($resultado)) {
    $precos[$linha['nome']] = $linha['preco'];
    $ids[$linha['nome']] = $linha['id'];
}

// categorias para os botões
$lista = mysqli_query($conexao, "SELECT DISTINCT categoria FROM produtos");

// Devolve o preço formatado (ex.: 24,90) do produto pedido
function preco($precos, $nome) {
    return number_format($precos[$nome] ?? 0, 2, ',', '.');
}

include("cabecalho.php");
?>

<main class="cardapio">
    <h2 class="titulo-pagina">Nosso Cardápio</h2>

    <nav class="categorias">
        <a class="btn-categoria" href="produtos.php">Todos</a>
        <?php while ($c = mysqli_fetch_assoc($lista)) { ?>
            <a class="btn-categoria" href="produtos.php?categoria=<?= $c['categoria'] ?>">
                <?= ucfirst($c['categoria']) ?>
            </a>
        <?php } ?>
    </nav>

    <section class="lista-produtos">

        <?php if (isset($precos['X-Burger'])) { ?>
        <article class="produto">
            <img class="produto-img" src="/imagens/como-fazer-x-burguer.jpg" alt="X-Burger">
            <div class="produto-info">
                <h3>X-Burger</h3>
                <p class="preco">R$ <?= preco($precos, 'X-Burger') ?></p>
                <form method="post" action="carrinho.php">
                    <input type="hidden" name="acao" value="adicionar">
                    <input type="hidden" name="id" value="<?= $ids['X-Burger'] ?>">
                    <input class="qtd" type="number" name="quantidade" value="1" min="1">
                    <button class="botao" type="submit">Adicionar</button>
                </form>
            </div>
        </article>
        <?php } ?>

        <?php if (isset($precos['X-Bacon'])) { ?>
        <article class="produto">
            <img class="produto-img" src="/imagens/images.jpg" alt="X-Bacon">
            <div class="produto-info">
                <h3>X-Bacon</h3>
                <p class="preco">R$ <?= preco($precos, 'X-Bacon') ?></p>
                <form method="post" action="carrinho.php">
                    <input type="hidden" name="acao" value="adicionar">
                    <input type="hidden" name="id" value="<?= $ids['X-Bacon'] ?>">
                    <input class="qtd" type="number" name="quantidade" value="1" min="1">
                    <button class="botao" type="submit">Adicionar</button>
                </form>
            </div>
        </article>
        <?php } ?>

        <?php if (isset($precos['Hot Dog Completo'])) { ?>
        <article class="produto">
            <img class="produto-img" src="/imagens/hotdog.jpg" alt="Hot Dog Completo">
            <div class="produto-info">
                <h3>Hot Dog Completo</h3>
                <p class="preco">R$ <?= preco($precos, 'Hot Dog Completo') ?></p>
                <form method="post" action="carrinho.php">
                    <input type="hidden" name="acao" value="adicionar">
                    <input type="hidden" name="id" value="<?= $ids['Hot Dog Completo'] ?>">
                    <input class="qtd" type="number" name="quantidade" value="1" min="1">
                    <button class="botao" type="submit">Adicionar</button>
                </form>
            </div>
        </article>
        <?php } ?>

        <?php if (isset($precos['Refrigerante Lata'])) { ?>
        <article class="produto">
            <img class="produto-img" src="/imagens/cola.jpg" alt="Refrigerante Lata">
            <div class="produto-info">
                <h3>Refrigerante Lata</h3>
                <p class="preco">R$ <?= preco($precos, 'Refrigerante Lata') ?></p>
                <form method="post" action="carrinho.php">
                    <input type="hidden" name="acao" value="adicionar">
                    <input type="hidden" name="id" value="<?= $ids['Refrigerante Lata'] ?>">
                    <input class="qtd" type="number" name="quantidade" value="1" min="1">
                    <button class="botao" type="submit">Adicionar</button>
                </form>
            </div>
        </article>
        <?php } ?>

        <?php if (isset($precos['Suco Natural'])) { ?>
        <article class="produto">
            <img class="produto-img" src="/imagens/suco.png" alt="Suco Natural">
            <div class="produto-info">
                <h3>Suco Natural</h3>
                <p class="preco">R$ <?= preco($precos, 'Suco Natural') ?></p>
                <form method="post" action="carrinho.php">
                    <input type="hidden" name="acao" value="adicionar">
                    <input type="hidden" name="id" value="<?= $ids['Suco Natural'] ?>">
                    <input class="qtd" type="number" name="quantidade" value="1" min="1">
                    <button class="botao" type="submit">Adicionar</button>
                </form>
            </div>
        </article>
        <?php } ?>

        <?php if (isset($precos['Brownie com Sorvete'])) { ?>
        <article class="produto">
            <img class="produto-img" src="/imagens/brownie.jpg" alt="Brownie com Sorvete">
            <div class="produto-info">
                <h3>Brownie com Sorvete</h3>
                <p class="preco">R$ <?= preco($precos, 'Brownie com Sorvete') ?></p>
                <form method="post" action="carrinho.php">
                    <input type="hidden" name="acao" value="adicionar">
                    <input type="hidden" name="id" value="<?= $ids['Brownie com Sorvete'] ?>">
                    <input class="qtd" type="number" name="quantidade" value="1" min="1">
                    <button class="botao" type="submit">Adicionar</button>
                </form>
            </div>
        </article>
        <?php } ?>

        <?php if (isset($precos['Pudim'])) { ?>
        <article class="produto">
            <img class="produto-img" src="/imagens/pudim.jpg" alt="Pudim">
            <div class="produto-info">
                <h3>Pudim</h3>
                <p class="preco">R$ <?= preco($precos, 'Pudim') ?></p>
                <form method="post" action="carrinho.php">
                    <input type="hidden" name="acao" value="adicionar">
                    <input type="hidden" name="id" value="<?= $ids['Pudim'] ?>">
                    <input class="qtd" type="number" name="quantidade" value="1" min="1">
                    <button class="botao" type="submit">Adicionar</button>
                </form>
            </div>
        </article>
        <?php } ?>

        <?php if (isset($precos['Batata Frita'])) { ?>
        <article class="produto">
            <img class="produto-img" src="/imagens/batata.jpg" alt="Batata Frita">
            <div class="produto-info">
                <h3>Batata Frita</h3>
                <p class="preco">R$ <?= preco($precos, 'Batata Frita') ?></p>
                <form method="post" action="carrinho.php">
                    <input type="hidden" name="acao" value="adicionar">
                    <input type="hidden" name="id" value="<?= $ids['Batata Frita'] ?>">
                    <input class="qtd" type="number" name="quantidade" value="1" min="1">
                    <button class="botao" type="submit">Adicionar</button>
                </form>
            </div>
        </article>
        <?php } ?>

        <?php if (isset($precos['Gelo'])) { ?>
        <article class="produto">
            <img class="produto-img" src="/imagens/gelo.jpg" alt="Gelo">
            <div class="produto-info">
                <h3>Gelo</h3>
                <p class="preco">R$ <?= preco($precos, 'Gelo') ?></p>
                <form method="post" action="carrinho.php">
                    <input type="hidden" name="acao" value="adicionar">
                    <input type="hidden" name="id" value="<?= $ids['Gelo'] ?>">
                    <input class="qtd" type="number" name="quantidade" value="1" min="1">
                    <button class="botao" type="submit">Adicionar</button>
                </form>
            </div>
        </article>
        <?php } ?>

    </section>
</main>

<?php include("rodape.php"); ?>