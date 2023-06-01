<?php
try {
    include "abrir_transacao.php";
include_once "operacoes.php";


// ATENÇÃO: Isto não é um HTML completo!
// É apenas um pedaço do HTML que deve ser lido por AJAX!

?>
   <title>Imobiliaria Martini & Showza</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
       <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<div class="container_adm">
        <form class="form_adm">
            <div class="container-md">
                <?php $resultado = listar_imovel(); ?>
                <table class="table table-striped-columns table-bordered ">
                    <tbody class="table-group-divider tabelaEst">
                        <tr>
                            <th scope="column">Chave</th>
                            <th scope="column">Area construida em m2</th>
                            <th scope="column">Area total em m2</th>
                            <th scope="column">Quartos</th>
                            <th scope="column">Banheiros</th>
                            <th scope="column">Numero do Andar</th>
                            <th scope="column">Logradouro</th>
                            <th scope="column">Preço de Venda</th>
                            <th scope="column">Mensalidade do aluguel</th>
                            <th scope="column">Situação </th>
                            <th scope="column">Tipo</th>
                            <th scope="column">Editar / Excluir</th>
                        </tr>
                        <?php foreach ($resultado as $linha) { ?>
                        <tr class="table-secondary">
                            <td class="table-secondary"><?= $linha["chave"] ?></td>
                            <td class="table-secondary"><?= $linha["area_construida_m2"] ?></td>
                            <td class="table-secondary"><?= $linha["area_total_m2"] ?></td>
                            <td class="table-secondary"><?= $linha["quartos"] ?></td>
                            <td class="table-secondary"><?= $linha["banheiros"] ?></td>
                            <td class="table-secondary"><?= $linha["numero_piso"] ?></td>
                            <td class="table-secondary"><?= $linha["logradouro"] ?></td>
                            <td class="table-secondary"><?= $linha["preco_venda"] ?></td>
                            <td class="table-secondary"><?= $linha["mensalidade_aluguel"] ?></td>
                            <td class="table-secondary"><?= $linha["situacao"] ?></td>
                            <td class="table-secondary"><?= $linha["tipo"] ?></td>
                            <td class="table-secondary">
                                <button type="button">
                                    <a href="cadastro.php?chave=<?= $linha["chave"] ?>">Editar</a>
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <button type="button"><a href="cadastro.php">Criar novo</a></button>
            </div>
<?php

$transacaoOk = true;

} finally {
    include "fechar_transacao.php";
}
?>