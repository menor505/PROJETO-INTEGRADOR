<?php
require_once("funcoes.php");
exigir_admin();

require("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'];

    if ($acao == 'adicionar') {
        $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
        $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
        $categoria = mysqli_real_escape_string($conexao, $_POST['categoria']);
        $preco = (float) str_replace(',', '.', $_POST['preco']);
        $usuario_id = $_SESSION['id'];

        mysqli_query($conexao, "INSERT INTO produtos (nome, descricao, preco, categoria, usuario_id)
                                VALUES ('$nome', '$descricao', $preco, '$categoria', $usuario_id)");
    }

    if ($acao == 'editar') {
        $id = (int) $_POST['id'];
        $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
        $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
        $categoria = mysqli_real_escape_string($conexao, $_POST['categoria']);
        $preco = (float) str_replace(',', '.', $_POST['preco']);

        mysqli_query($conexao, "UPDATE produtos SET nome = '$nome', descricao = '$descricao',
                                preco = $preco, categoria = '$categoria' WHERE id = $id");
    }

    if ($acao == 'excluir') {
        $id = (int) $_POST['id'];
        mysqli_query($conexao, "DELETE FROM produtos WHERE id = $id");
    }

    header("Location: editar.php");
    exit;
}

$produtos = mysqli_query($conexao, "SELECT * FROM produtos ORDER BY id");

include("cabecalho.php");
?>

<main class="cardapio">
    <h2 class="titulo-pagina">Painel do Admin</h2>

    <h3 class="subtitulo">Adicionar produto</h3>
    <form class="form-admin" method="post">
        <input type="hidden" name="acao" value="adicionar">
        <input class="campo" type="text" name="nome" placeholder="Nome" required>
        <input class="campo" type="text" name="descricao" placeholder="Descrição">
        <input class="campo" type="number" step="0.01" name="preco" placeholder="Preço" required>
        <input class="campo" type="text" name="categoria" placeholder="Categoria (ex.: lanches)" required>
        <button class="botao" type="submit">Adicionar</button>
    </form>

    <h3 class="subtitulo">Produtos cadastrados</h3>

    <?php while ($p = mysqli_fetch_assoc($produtos)) { ?>
        <form class="linha-produto" method="post">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <input class="campo" type="text" name="nome" value="<?= htmlspecialchars($p['nome']) ?>" required>
            <input class="campo" type="text" name="descricao" value="<?= htmlspecialchars($p['descricao']) ?>">
            <input class="campo" type="number" step="0.01" name="preco" value="<?= $p['preco'] ?>" required>
            <input class="campo" type="text" name="categoria" value="<?= htmlspecialchars($p['categoria']) ?>" required>
            <button class="botao" type="submit" name="acao" value="editar">Salvar</button>
            <button class="btn-remover" type="submit" name="acao" value="excluir"
                    onclick="return confirm('Excluir este produto?')">Excluir</button>
        </form>
    <?php } ?>
</main>

<?php include("rodape.php"); ?>