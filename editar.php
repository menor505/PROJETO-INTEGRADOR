<?php
/*
   EDITAR.PHP - painel do admin (lista e edita produtos)

   1. exigir_admin(): só admin entra.
   2. Salvar (POST): UPDATE no produto com nome, preço, categoria e descrição.
   3. Lista: cada produto vira um formulário editável na própria linha.
      O <select> de categoria já vem marcando a categoria atual (selected).
   4. Botão Excluir: link para excluir.php com confirm() ("tem certeza?").
   5. Se a URL tiver ?erro=em_pedido, avisa que o produto não pode ser
      excluído porque já aparece em pedidos.
   6. Botão "+ Novo produto" leva para o adicionar.php.
*/

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

    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'em_pedido'): ?>
        <p class="erro">Esse produto não pode ser excluído porque já aparece em pedidos feitos.</p>
    <?php endif; ?>

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