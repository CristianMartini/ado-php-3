<?php 
include_once "conecta-sqlite.php";


 function inserir_imovel( $imovel){
    global $pdo;
    $sql = " INSERT INTO imovel ( area_construida_m2, area_total_m2, quartos , banheiros, numero_piso , logradouro , preco_venda , mensalidade_aluguel , situacao , tipo )". 
    " VALUES (:area_construida_m2, :area_total_m2, :quartos , :banheiros, :numero_piso , :logradouro , :preco_venda , :mensalidade_aluguel , :situacao , :tipo_imovel )";

    $pdo->prepare($sql)->execute($imovel);
    return $pdo->lastInsertId();
 }

 function alterar_imovel($imovel) {
    global $pdo;
    $sql = "UPDATE imovel SET " .
        "area_construida_m2 = :area_construida_m2, ".
        "area_total_m2 = :area_total_m2, " .
        "quartos = :quartos, " .
        "banheiros = :banheiros, ".
        "numero_piso = :numero_piso, " .
        "logradouro = :logradouro, " .
        "preco_venda = :preco_venda, " .
        "mensalidade_aluguel = :mensalidade_aluguel, ".
        "situacao = :situacao, " .
        "tipo = :tipo_imovel " .
        "WHERE chave = :chave";
    $pdo->prepare($sql)->execute($imovel);
}
function excluir_imovel($chave) {
    global $pdo;
    $sql = "DELETE FROM imovel WHERE chave = :chave";
    $pdo->prepare($sql)->execute(["chave" => $chave]);
}

function listar_imovel() {
    global $pdo;
    $sql = "SELECT * FROM imovel";
    $resultados = [];
    $consulta = $pdo->query($sql);
    while ($linha = $consulta->fetch()) {
        $resultados[] = $linha;
    }
    return $resultados;
}

function buscar_imovel($chave) {
    global $pdo;
    $sql = "SELECT * FROM imovel WHERE chave = :chave";
    $resultados = [];
    $consulta = $pdo->prepare($sql);
    $consulta->execute(["chave" => $chave]);
    return $consulta->fetch();
}
function listar_situacao() {
    global $pdo;
    $sql = "SELECT * FROM situacao_imovel";
    $resultados = [];
    $consulta = $pdo->query($sql);
    while ($linha = $consulta->fetch()) {
        $resultados[] = $linha["situacao"];
    }
    return $resultados;
}

function listar_tipo() {
    global $pdo;
    $sql = "SELECT * FROM tipo_imovel";
    $resultados = [];
    $consulta = $pdo->query($sql);
    while ($linha = $consulta->fetch()) {
        $resultados[] = $linha["tipo_imovel"];
    }
    return $resultados;
}
function login($nome, $senha) {
    global $pdo;
    $sql = "SELECT chave, nome FROM usuario WHERE nome = :nome AND senha = :senha";
    $resultados = [];
    $consulta = $pdo->prepare($sql);
    $consulta->execute(["nome" => $nome, "senha" => $senha]);
    return $consulta->fetch();
}
?>


