<?php

$host="localhost";
$usuario="root";
$senha= "root";
$banco= "comeketo";

$conexao=mysqli_connect($host,$usuario,$senha,$banco);

if(!$conexao){
    die ("nao foi possivel conectar ao banco"mysqli_connect_error());
}