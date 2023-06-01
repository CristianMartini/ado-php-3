<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location:http://localhost/ado-php-3/Imobiliaria_m&S/login.php");
    exit();
}
$usuario = $_SESSION["usuario"];
?>
<!DOCTYPE html>
<html>

<head>
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
   
       <script async>
    let dadosLidos = null;
    let idxLinha = -1;

    function popular(dados) {
        dadosLidos = dados;
        let tabela = "" +
            "<table >" +
                        '    <tr>' +
            '        <th scope="column">Chave</th>' +
            '        <th scope="column">Area construida em m2</th>' +
            '        <th scope="column">Area total em m2</th>' +
            '        <th scope="column">Quartos</th>' +
            '        <th scope="column">Banheiros</th>' +
            '        <th scope="column">Numero do Andar</th>' +
            '        <th scope="column">Numero do Andar</th>' +
            '        <th scope="column">Logradouro</th>' +
            '        <th scope="column">Preço de Vendar</th>' +
            '        <th scope="column">Mensalidade do aluguel</th>' +
            '        <th scope="column">Numero do Andar</th>' +
            '        <th scope="column">Situação</th>' +
            '        <th scope="column">Tipo</th>' +
            '    </tr>';
        let idx = 0;
        for (const linha of dados.listagem) {
            tabela += `<tr>` +
                `    <td>${linha.chave}</td>` +
                `    <td>${linha.area_construida_m2}</td>` +
                `    <td>${linha.area_total_m2}</td>` +
                `    <td>${linha.quartos}</td>` +
                `    <td>${linha.banheiros}</td>` +
                `    <td>${linha.numero_piso}</td>` +
                `    <td>${linha.logradouro}</td>` +
                `    <td>${linha.numero_piso}</td>` +
                `    <td>${linha.preco_venda}</td>` +
                `    <td>${linha.mensalidade_aluguel}</td>` +
                `    <td>${linha.situacao}</td>` +
                `    <td>${linha.tipo}</td>` +
                `    <td><button type="button" onclick="editar(${idx})">Editar</button></td>` +
                `</tr>`;
            idx++;
        }
        tabela += `` +
            `<tr>` +
            `    <td colspan="12"></td>` +
            `    <td><button type="button" onclick="novo()">Criar novo</button></td>` +
            `</tr>`;
        document.getElementById("tipo_imovel").innerHTML = "<option>Escolha...</option>";
        for (const tipo of dados.tipos) {
            const option = document.createElement("option");
            option.value = tipo;
            option.innerHTML = tipo;
            option.id = "opcao-" + tipo;
            document.getElementById("tipo_imovel").appendChild(option);
        }
        document.getElementById("situacao").innerHTML = "<option>Escolha...</option>";
        for (const situacao of dados.situacoes) {
            const option = document.createElement("option");
            option.value = situacao;
            option.innerHTML = situacao;
            option.id = "opcao-" + situacao;
            document.getElementById("situacao").appendChild(option);
        }
        document.getElementById("listagem").innerHTML = tabela;
        document.getElementById("formulario").style.display = "none";

    }

    function editar(idx) {
        const linha = dadosLidos.listagem[idx];
        for (const campo in linha) {
            const elem = document.getElementById(campo);
            if (elem) elem.value = linha[campo];
        }
        document.getElementById("opcao-" + linha.tipo).setAttribute("selected", "selected");
        document.getElementById("formulario").style.display = "block";
        document.getElementById("div-chave").style.display = "block";
        document.getElementById("bt-excluir").style.display = "block";
    }

    function novo() {
        for (const campo of document.querySelectorAll("form input")) {
            campo.value = "";
        }
        for (const campo of document.querySelectorAll("option")) {
            campo.removeAttribute("selected");
        }
        document.getElementById("formulario").style.display = "block";
        document.getElementById("div-chave").style.display = "none";
        document.getElementById("bt-excluir").style.display = "none";
    }

    function lerDados() {
        fetch("http://localhost/ado-php-3/Imobiliaria_m&S/listagem-json2.php")
            .then(resposta => resposta.text())
            .then(dados => popular(JSON.parse(dados)))
            .catch(erro => {
                console.log("Deu chabu", erro);
            });
    }

    function confirmar() {
        if (!confirm("Tem certeza que deseja salvar os dados?")) return;
        const alterar = document.getElementById("div-chave").style.display === "block";
        let dados = {};
        const campos = ["area_construida_m2", "area_total_m2", "quartos", "banheiros", "numero_piso", "logradouro",
            "preco_venda", "mensalidade_aluguel", "situacao", "tipo_imovel"
        ];
        if (alterar) campos.push("chave");
        for (const campo of campos) {
            const valor = document.getElementById(campo).value;
            dados[campo] = valor;
        }
        const conteudo = JSON.stringify(dados);
        console.log(conteudo);
        fetch("http://localhost/ado-php-3/Imobiliaria_m&S/cadastro-json2.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: conteudo
            })
            .then(resultado => lerDados())
            .catch(zica => console.error(zica));
    }

    function excluir() {
        if (!confirm("Tem certeza que deseja excluir o imovel?")) return;
        document.getElementById("excluir-imovel").submit();
    }
    </script>
</head>

<body>
    <h1>Seja bem-vindo(a), <?= $usuario["nome"] ?></h1>
    <form action="../Imobiliaria_M&S/logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>
    <div id="listagem"></div>
    <button type="button" onclick="lerDados()">Ler o resultado</button>
    <form id="formulario" style="display:none">
        <div id="div-chave">
            <label for="chave">Chave:</label>
            <input type="text" id="chave" name="chave" value="" readonly>
        </div>
                        <label for="area_total_m2"> Area total do imovel:</label>
                <input type="number" id="area_total_m2" name="area_total_m2">
            </div>
            <div>
                <label for="area_construida_m2">Area construida :</label>
                <input type="number" id="area_construida_m2" name="area_construida_m2">
            </div>
            <div>
                <label for="quartos">Quantidade de quartos:</label>
                <input type="number" id="quartos" name="quartos">
            </div>
            <div>
                <label for="banheiros">Banheiros:</label>
                <input type="number" id="banheiros" name="banheiros">
            </div>
            <div>
                <label for="numero_piso">Numero do piso:</label>
                <input type="number" id="numero_piso" name="numero_piso">
            </div>
            <div>
                <label for="logradouro">Insira seu Endereço completo:</label>
                <input type="text" id="logradouro" name="logradouro">
            </div>
            <div>
                <label for="preco_venda">Preço de venda do imovel:</label>
                <input type="number" id="preco_venda" name="preco_venda">
            </div>
            <div>
                <label for="mensalidade_aluguel">Mensalidade do imovel:</label>
                <input type="number" id="mensalidade_aluguel" name="mensalidade_aluguel">
            </div>

            <div>
                <label for="situacao">Situação do imóvel:</label>
                <select id="situacao" name="situacao">
                    <option>Escolha...</option>
                </select>
            </div>
            <label for="tipo_imovel">Tipo do Imóvel:</label>
            <select id="tipo_imovel" name="tipo_imovel">
                <option>Escolha...</option>
            </select>
        </div>
        <button type="button" onclick="confirmar()">Salvar</button>
        <button type="button" onclick="excluir()" id="bt-excluir">Excluir</button>
        </div>
    </form>
</body>

</html>