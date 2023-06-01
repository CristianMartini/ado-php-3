<?php
function conectar() {
    try {
        $db_file = 'C:\\xampp\\htdocs\\Imobiliaria-M&S\\ado-php-2\\Imobiliaria-M&S.sqlite';
        return new PDO("sqlite:$db_file");
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        throw $e;
    }
}


?>