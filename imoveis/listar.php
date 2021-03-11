<?php
session_start();
if (!isset($_GET['id'])) echo "IMOVEL NÃO ENCONTRADO";

include_once($_SERVER['DOCUMENT_ROOT'] . "/imoveis/listagem.php");
$imovel = new Listar_imovel;
$imovel->id = $_GET['id'];

$imovel->listar();

$title = "Sistema de Locação de imóveis - " . $imovel->imovel->titulo;

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
        <?= $imovel->cards() ?>
        <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <img src="" class="imagepreview" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="/static/js/funcs.js"></script>
    <script>
        $(function() {
            $('.pop').on('click', function() {
                $('.imagepreview').attr('src', $(this).find('img').attr('src'));
                $('#imagemodal').modal('show');
            });
        });
    </script>
</body>

</html>