<?php
try {
    include "abrir_transacao.php";
include_once "operacoes.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type", "application/json");

$resultado = listar_imovel();
$tipos = listar_tipo();
$situacoes = listar_situacao();
$resposta = [
    "listagem" => array_values($resultado),
    "tipos" => array_values($tipos),
    "situacoes" => array_values($situacoes)
];
$json = json_encode($resposta, JSON_PRETTY_PRINT);
echo $json;

$transacaoOk = true;

} finally {
    include "fechar_transacao.php";
}
?>