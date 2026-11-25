<?php
session_start();
require_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha_digitada = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexao, $sql);
    $usuario = mysqli_fetch_assoc($resultado);

    if ($usuario and password_verify($senha_digitada, $usuario['senha'])) {
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['tipo'] = $usuario['tipo'];

        if ($usuario['tipo'] === 'admin') {
            header("Location: editar.php");
        } else {
            header("Location: produtos.php");
        }
        exit;
    } else {
        $erro = "E-mail ou senha incorretos";
    }
}

include("cabecalho.php");
?>

<main class="cadastro">
    <section class="msgcd">
        <h3>Bem-vindo de volta!</h3>
        <small>Entre na sua conta para fazer seu pedido.</small>
    </section>

    <?php if (isset($erro)): ?>
        <p class="erro"><?= $erro ?></p>
    <?php endif; ?>

    <form action="login.php" class="form" method="post">
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button class="botao" type="submit">Entrar</button>
    </form>

    <p>Ainda não tem conta?</p>
    <a href="cadastro.php">Cadastre-se</a>
</main>

<?php include("rodape.php"); ?>