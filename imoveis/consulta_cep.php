<?php
// CRIADO PARA "PASSAR" POR CIMA DE CORS DO NAVEGADOR
include_once($_SERVER['DOCUMENT_ROOT'] . "/libs/helpers.php");

$cep = $_GET['cep'];

echo consulta_cep($cep);
