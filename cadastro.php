<?php
require("conexao.php");
$erro = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    if ($nome === '') {
        $erro[] = 'Informe seu nome';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro[] = 'Informe um email existente';
    }
    if (strlen($senha) < 8) {
        $erro[] = 'A senha deve ter no mínimo 8 caracteres.';
    }
    if (count($erro) == 0) {
        $email = mysqli_real_escape_string($conexao, $email);
        $nome = mysqli_real_escape_string($conexao, $nome);
        $consulta = mysqli_query($conexao, "SELECT id FROM usuarios WHERE email = '$email' LIMIT 1");

        if (mysqli_num_rows($consulta) > 0) {
            $erro[] = 'Já existe uma conta cadastrada com esse e-mail.';
        }
    }
    if (count($erro) == 0) {
        $senha = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

        if (mysqli_query($conexao, $sql)) {
            header("Location: login.php");
            exit;
        } else {
            $erro[] = 'Erro ao cadastrar.';
        }
    }
}
include "cabecalho.php";
?>
<main class="cadastro">
    <section class="msgcd">
        <h3>Comece a pedir criando a sua conta!</h3>
        <small>Crie uma conta para ter uma experiência melhor no site.</small>
    </section>

    <?php
    foreach ($erro as $mensagem) {
        echo "<p>$mensagem</p>";
    }
    ?>
    <form method="post">
        <input type="text" name="nome" placeholder="Nome">
        <input type="email" name="email" placeholder="E-mail">
        <input type="password" name="senha" placeholder="Senha (mínimo 8 caracteres)">
        <button type="submit">Criar conta</button>
    </form>
</main>