<?php
/*
   CONEXAO.PHP - conexão com o banco de dados

   - Guarda os dados de acesso: servidor (host), usuário, senha e nome do banco (comeketo).
   - mysqli_connect() abre a conexão e coloca ela na variável $conexao.
   - Se não conseguir conectar, o die() para tudo e mostra o erro.
   - As outras páginas usam require("conexao.php") para poder usar o $conexao.
*/

$host="localhost";
$usuario="root";
$senha= "root";
$banco= "comeketo";

$conexao=mysqli_connect($host,$usuario,$senha,$banco);

if(!$conexao){
    die ("nao foi possivel conectar ao banco" . mysqli_connect_error());
}