<?php
// pega as funcoes que eu criei por exemplo exigir adm pq esta pagina é so para adm
require_once("funcoes.php");
exigir_admin();
//usa o conexao pra se conectar pro banco 
require("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $preco = (float) $_POST['preco'];
    $categoria = mysqli_real_escape_string($conexao, $_POST['categoria']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);

    // foto (opcional)
    $imagem = '';
    if (isset($_FILES['foto']) and $_FILES['foto']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION)); //ele pega e ve o tipo da imagem transforma ela em minusculo pra validar

        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $imagem = time() . "." . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], "imagens/" . $imagem);
        }
    }

    mysqli_query($conexao, "INSERT INTO produtos (nome, preco, categoria, descricao, imagem) VALUES ('$nome', $preco, '$categoria', '$descricao', '$imagem')");
    header("Location: editar.php");
    exit;
}

include("cabecalho.php");
?>

<main class="cadastro">
    <section class="msgcd">
        <h3>Novo Produto</h3>
    </section>

    <form action="adicionar.php" class="form" method="post" enctype="multipart/form-data">
        <input type="text" name="nome" placeholder="Nome do produto" required>
        <input type="number" step="0.01" name="preco" placeholder="Preço" required>

        <select name="categoria" required>
            <option value="">Selecione a categoria</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat ?>"><?= ucfirst($cat) ?></option>
            <?php endforeach; ?>
        </select>

        <textarea name="descricao" placeholder="Descrição" required></textarea>
        <input type="file" name="foto" accept="image/*" required>
        <button class="botao" type="submit">Adicionar</button>
    </form>

    <a href="editar.php">Voltar</a>
</main>

<?php include("rodape.php"); ?>