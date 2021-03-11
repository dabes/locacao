<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "./libs/db.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/imoveis/listagem.php");



session_start();
if (!isset($_SESSION['usuario'])) header("Location: /");
else {
    $imoveis = new Listagem_imovel;

    $imoveis->usuario = $_SESSION['usuario']['id'];

    $imoveis->listar_por_usuario();

    $meusimoveis = $imoveis->imoveis;
}


$title = "Sistema de Locação de imóveis - Meus Imóveis";
?>


<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/static/css/site.css">

    <title><?= $title ?></title>
</head>

<body>
    <div class="container border mt-2 mb-2 pt-2">
        <?php if (!isset($_SESSION["usuario"])) { ?>
            <p class="text-right"><a href="/usuario/cadastrar">Cadastrar</a> ou <a href="/usuario/login">Login</a></p>
        <?php } else { ?>
            <p class="text-right"><a href="/usuario/logout">Logout</a> <a href="/imoveis/meusimoveis">Meus Imóveis</a></p>
        <?php } ?>
        <div class="row">
            <div class="col-sm">

                <h1 class="text-center fs-1">SITE DE LOCAÇÃO DE IMÓVEIS</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <p class="text-right"><a href="/imoveis/editar" class="btn btn-primary">Cadastrar</a></p>
                <h4 class="text-center">Listagem dos Meus Imóveis</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Titulo</th>
                            <th scope="col">Aluguel</th>
                            <th scope="col">Condomínio</th>
                            <th scope="col">IPTU</th>
                            <th scope="col">Área</th>
                            <th scope="col">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($meusimoveis as $imovel) { ?>
                            <tr>
                                <td scope="row">
                                    <b><?= $imovel->id ?></b>
                                </td>
                                <td>
                                    <?= $imovel->titulo ?>
                                </td>
                                <td>
                                    <?= number_format($imovel->valor, 2, ",", ".") ?>
                                </td>
                                <td>
                                    <?= number_format($imovel->condominio, 2, ",", ".") ?>
                                </td>
                                <td>
                                    <?= number_format($imovel->iptu, 2, ",", ".") ?>
                                </td>
                                <td>
                                    <?= number_format($imovel->area, 2, ",", ".") ?>
                                </td>
                                <td>
                                    <a href="/imoveis/editar?id=<?= $imovel->id ?>" class="btn btn-primary">Editar</a>
                                    <a href="/imoveis/apagar?id=<?= $imovel->id ?>" class="btn btn-primary" onclick="if (!confirm('Deseja mesmo apagar o imóvel?')) return false;">Apagar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="/static/js/funcs.js"></script>
</body>

</html>