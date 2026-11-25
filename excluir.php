<?php
require_once("funcoes.php");
exigir_admin();

require("conexao.php");

$id = (int) $_GET['id'];
mysqli_query($conexao, "DELETE FROM produtos WHERE id = $id");

header("Location: editar.php");
exit;