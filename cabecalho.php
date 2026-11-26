<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMEKETO - peça o que quiser!</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="corpo">
    <header class="cabecalho">
        <div class="meio">
          <a href="index.php"><img class="img" src="/imagens/comeketo-logo.svg" alt="fantasma comeketo"></a>
           <a class="a1" href="produtos.php">PEÇA JÁ</a>
            
            
        </div>
        <div class="meio">
            
            <a class="a" href="index.php">INÍCIO</a>
        </div>
        <nav class="navegacao">

    <a href="produtos.php" class="a">Cardápio</a>

    <?php if (isset($_SESSION['id']) and $_SESSION['tipo'] === 'admin'): ?>
        <a href="editar.php" class="a">admin</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['id'])): ?>
        <a href="pedidos.php" class="a">Pedidos</a>
        <a href="carrinho.php" class="a">Carrinho (<?= count($_SESSION['carrinho'] ?? []) ?>)</a>
        <a href="logout.php" class="a">Sair</a>
    <?php else: ?>
        <a href="cadastro.php" class="a">Cadastre-se</a>
        <a href="login.php" class="a">Entrar</a>
    <?php endif; ?>

</nav>
    </header>