<?php
session_start();
require("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = $_POST['senha'];

    $resultado = mysqli_query($conexao, "SELECT * FROM usuarios WHERE email = '$email'");
    $usuario = mysqli_fetch_assoc($resultado);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['tipo'] = $usuario['tipo'];

        // cookie: lembrar o e-mail por 30 dias
        if (isset($_POST['lembrar'])) {
            setcookie("email_lembrado", $usuario['email'], time() + 2592000);
        } else {
            setcookie("email_lembrado", "", time() - 3600);
        }

        if ($usuario['tipo'] === 'admin') {
            header("Location: editar.php");
        } else {
            header("Location: produtos.php");
        }
        exit;
    }

    $erro = "E-mail ou senha incorretos";
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
        <input type="email" name="email" placeholder="E-mail" value="<?= $_COOKIE['email_lembrado'] ?? '' ?>" required>
        <input type="password" name="senha" placeholder="Senha" required>

        <label class="lembrar">
            <input type="checkbox" name="lembrar" <?= isset($_COOKIE['email_lembrado']) ? 'checked' : '' ?>>
            Lembrar meu e-mail
        </label>

        <button class="botao" type="submit">Entrar</button>
    </form>

    <p>Ainda não tem conta?</p>
    <a href="cadastro.php">Cadastre-se</a>
</main>

<?php include("rodape.php"); ?>