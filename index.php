<?php
include("cabecalho.php");
require("conexao.php");
$resultado = mysqli_query($conexao, "SELECT * FROM produtos ORDER BY id LIMIT 3");
?>
<main class="visual">
    <div class="inicio">

        <div class="inicio-texto">
            <section class="sessao">
                <h1>Varios tipos de lanches!<br> sem espera!</h1> <br>
                <h3>E muito Mais!</h3>
                <p>Lanches e bebidas autorais com tradição e ingredientes especiais!</p>
            </section>
            <a href="produtos.php">Ver nosso Cardápio</a> <small>mais de 10000+ entregas em Curitiba</small>

            <ul class="mini-passos">
                <li>🍔 Escolha</li>
                <li>🛒 Monte</li>
                <li>🚀 Receba rapidinho</li>
            </ul>
        </div>

        <aside class="inicio-destaques">
            <p class="destaques-titulo">Os queridinhos da casa</p>
            <?php while ($produto = mysqli_fetch_assoc($resultado)) { ?>
                <div class="destaque">
                    <img src="/imagens/<?= $produto['imagem'] ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                    <div>
                        <strong><?= htmlspecialchars($produto['nome']) ?></strong>
                        <span class="preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                    </div>
                </div>
            <?php } ?>
        </aside>

    </div>
</main>

<?php include("rodape.php"); ?>