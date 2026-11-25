<?php
require_once("funcoes.php");
exigir_admin();

require("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $preco = (float) $_POST['preco'];
    $categoria = mysqli_real_escape_string($conexao, $_POST['categoria']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);

    mysqli_query($conexao, "UPDATE produtos SET nome = '$nome', preco = $preco, categoria = '$categoria', descricao = '$descricao' WHERE id = $id");
    header("Location: editar.php");
    exit;
}

$resultado = mysqli_query($conexao, "SELECT * FROM produtos ORDER BY id");

include("cabecalho.php");
?>

<main class="editar">
    <section class="msgcd">
        <h3>Editar Produtos</h3>
    </section>

    <a href="adicionar.php" class="botao botao-novo">+ Novo produto</a>

    <?php while ($produto = mysqli_fetch_assoc($resultado)): ?>
        <form method="post" class="produto-linha">
            <input type="hidden" name="id" value="<?= $produto['id'] ?>">
            <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
            <input type="number" step="0.01" name="preco" value="<?= $produto['preco'] ?>" required>
            <select name="categoria" required>
    <?php foreach ($categorias as $cat): ?>
        <option value="<?= $cat ?>" <?= $cat == $produto['categoria'] ? 'selected' : '' ?>>
            <?= ucfirst($cat) ?>
        </option>
    <?php endforeach; ?>
</select>
            <textarea name="descricao" required><?= htmlspecialchars($produto['descricao']) ?></textarea>
            <button class="botao" type="submit">Salvar</button>
            <a class="botao botao-excluir" href="excluir.php?id=<?= $produto['id'] ?>" onclick="return confirm('Excluir este produto?')">Excluir</a>
        </form>
    <?php endwhile; ?>
</main>

<?php include("rodape.php"); ?>