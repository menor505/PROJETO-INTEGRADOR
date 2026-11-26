<?php
/*
   INDEX.PHP - página inicial

   1. Inclui o cabeçalho e a conexão com o banco.
   2. SELECT ... LIMIT 3: pega os 3 primeiros produtos para a seção
      "Os queridinhos da casa".
   3. Lado esquerdo: texto de chamada, botão "Ver nosso Cardápio" e os
      3 passinhos (Escolha, Monte, Receba).
   4. Lado direito (<aside>): um while passa pelos 3 produtos e mostra foto,
      nome e preço. number_format() deixa o preço no formato brasileiro (24,90).
*/

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