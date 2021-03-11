<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: /");

include_once($_SERVER['DOCUMENT_ROOT'] . "/imoveis/cadastro.php");
$cadastro = new Cadastro_imovel;

$cadastro->usuario = $_SESSION['usuario']['id'];

if (isset($_GET['id'])) {
    $cadastro->id = $_GET['id'];
} else {
    $cadastro->id = false;
}

$apagado = $cadastro->Apagar();

if ($apagado === null or $apagado) header("Location: /imoveis/meusimoveis");
else var_dump($apagado);
