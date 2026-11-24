<?php
require_once("funcoes.php");
exigir_admin();

require("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $preco = (float) $_POST['preco'];

    mysqli_query($conexao, "UPDATE produtos SET nome = '$nome', preco = $preco WHERE id = $id");
    header("Location: editar.php");
    exit;
}

$resultado = mysqli_query($conexao, "SELECT * FROM produtos ORDER BY id");

include("cabecalho.php");
?>

<main>
    <h2>Editar Produtos</h2>

    <?php while ($produto = mysqli_fetch_assoc($resultado)): ?>
        <form method="post">
            <input type="hidden" name="id" value="<?= $produto['id'] ?>">
            <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
            <input type="number" step="0.01" name="preco" value="<?= $produto['preco'] ?>" required>
            <button type="submit">Salvar</button>
        </form>
    <?php endwhile; ?>
</main>

<?php include("rodape.php"); ?>