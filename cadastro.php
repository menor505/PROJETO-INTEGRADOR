<?php
require("conexao.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){

$nome  = $_POST['nome'];
$senha = $_POST['senha'];
$email = $_POST['email'];
$erro  = [];


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
    // o mysqli_real_escape_string protege meu codigo de quebrar com caracteres especiais e comandos
    $email = mysqli_real_escape_string($conexao, $email);
    $nome  = mysqli_real_escape_string($conexao, $nome);

    $consulta = mysqli_query($conexao, "SELECT id FROM usuarios WHERE email = '$email' LIMIT 1");

    if (mysqli_num_rows($consulta) > 0) {
        $erro[] = 'Já existe uma conta cadastrada com esse e-mail.';
    }
}

if (count($erro) == 0) {
    $senha = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

    if (mysqli_query($conexao, $sql)) {
        echo 'Cadastro realizado com sucesso!';
    } else {
        echo 'Erro ao cadastrar.';
    }
}
foreach ($erro as $mensagem) {
    echo "<p>$mensagem</p>";
}
}