<?php
try {
    include "abrir_transacao.php";
include_once "operacoes.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$tipos = listar_tipo();
$situacoes = listar_situacao();

function validar($imovel) {
    global $tipos;
    global $situacoes;
    
    if (!is_numeric($imovel["area_construida_m2"]) || $imovel["area_construida_m2"] < 0) {
        return false;
    }
    
    if (!is_numeric($imovel["area_total_m2"]) || $imovel["area_total_m2"] < 0) {
        return false;
    }
    
    if ($imovel["area_construida_m2"] > $imovel["area_total_m2"]) {
        return false;
    }
    
    if (!is_numeric($imovel["quartos"]) || $imovel["quartos"] < 0) {
        return false;
    }
    
    if (!is_numeric($imovel["banheiros"]) || $imovel["banheiros"] < 0) {
        return false;
    }
    
    if (isset($imovel["numero_piso"]) && (!is_numeric($imovel["numero_piso"]) || $imovel["numero_piso"] < -5)) {
        return false;
    }
    
    if (strlen($imovel["logradouro"]) < 10 || strlen($imovel["logradouro"]) > 1000) {
        return false;
    }
    
    if (!is_numeric($imovel["preco_venda"]) || $imovel["preco_venda"] < 0) {
        return false;
    }
    
    if (!is_numeric($imovel["mensalidade_aluguel"]) || $imovel["mensalidade_aluguel"] < 0) {
        return false;
    }
    
    if (strlen($imovel["situacao"]) < 1 || strlen($imovel["situacao"]) > 50 || !in_array($imovel["situacao"], $situacoes)) {
        return false;
    }
    
    if (strlen($imovel["tipo_imovel"]) < 1 || strlen($imovel["tipo_imovel"]) > 50 || !in_array($imovel["tipo_imovel"], $tipos)) {
        return false;
    }
    
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $json = file_get_contents("php://input");
    $dados = json_decode($json, true);
    $alterar = isset($dados["chave"]);

    if ($alterar) {


        $imovel = [
            "chave" => (int) $dados["chave"],
            "area_construida_m2" =>  $dados["area_construida_m2"],
            "area_total_m2" =>  $dados["area_total_m2"],
            "quartos" =>  $dados["quartos"],
            "banheiros" =>  $dados["banheiros"],
            "numero_piso" =>  $dados["numero_piso"],
            "logradouro" =>  $dados["logradouro"],
            "preco_venda" =>  $dados["preco_venda"],
            "mensalidade_aluguel" =>  $dados["mensalidade_aluguel"],
            "situacao" =>  $dados["situacao"],
            "tipo_imovel" =>  $dados["tipo_imovel"],
           
        ];
        $validacaoOk = validar($imovel);
        if ($validacaoOk) alterar_imovel($imovel);
        
    } else {
        $imovel= [
            "area_construida_m2" =>  $dados["area_construida_m2"],
            "area_total_m2" =>  $dados["area_total_m2"],
            "quartos" =>  $dados["quartos"],
            "banheiros" =>  $dados["banheiros"],
            "numero_piso" =>  $dados["numero_piso"],
            "logradouro" =>  $dados["logradouro"],
            "preco_venda" =>  $dados["preco_venda"],
            "mensalidade_aluguel" =>  $dados["mensalidade_aluguel"],
            "situacao" =>  $dados["situacao"],
            "tipo_imovel" =>  $dados["tipo_imovel"],
           
        ];
        $validacaoOk = validar($imovel);
        if ($validacaoOk) $id = inserir_imovel($imovel);
    }

    if ($validacaoOk) {
        $transacaoOk = true;
        echo "OK";
    } else {
        echo "ERRO";
    }
} else {
    die("Método não aceito");
}

} finally {
    include "fechar_transacao.php";
}
?>