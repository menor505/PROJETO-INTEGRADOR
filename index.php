<?php
include("cabecalho.php");
require("conexao.php");
$sql="SELECT * FROM produtos ORDER BY id";
$resultado = mysqli_query($conexao, $sql);
?>
<main class="visual">
    <section class="sessao">
<h1>    Comida boa!<br> sem espera!</h1> <br>
<h3>E muito Mais!</h3>
<p>Lanches e bebidas autorais com tradição e ingredientes especiais!</p>
</section>
<a href="produtos.php">Ver nosso Cardápio</a> <small>mais de 10000+ entregas em Curitiba</small>
<img class="img" src="./comeketo-logo.svg" alt="fantasma come keto">
</main>