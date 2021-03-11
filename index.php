<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "./libs/db.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/imoveis/listagem.php");

session_start();


$db = new Database();
// TESTA O BANCO, SE NAO EXISTIR A TABELA IMOVEL INSTALA O BANCO PARA O PRIMEIRO USO
// O BANCO FOI CRIADO NO PADRAO UTF8 "utf8mb4", NECESSÁRIO PARA FUNÇÕES DE JSON
// VARIAVEIS DE USUARIO, HOST, SENHA, E BANCO NO ./libs/db.php
if ($db->connect()) {
    $sql = "SELECT TRUE FROM imovel LIMIT 1";

    $db->exec($sql);
    if (!$db->result) {
        include_once("./libs/instala_db.php");
        $instala = new Instala;
        if (!$instala->instalar()) {
            print($instala->error);
        }
    }
}

$lista_imoveis = new Listagem_imovel;

$filtro = "";
if (isset($_GET['filtro'])) $filtro = $_GET['filtro'];

$lista_imoveis->filtro = $filtro;

$aluguel_de = "100";
$aluguel_ate = "20000";

if (isset($_GET['aluguel_de'])) $aluguel_de = $_GET['aluguel_de'];
if (isset($_GET['aluguel_ate'])) $aluguel_ate = $_GET['aluguel_ate'];

$lista_imoveis->aluguel_de = $aluguel_de;
$lista_imoveis->aluguel_ate = $aluguel_ate;

$aluguel_de = number_format($aluguel_de, 2, ".", "");
$aluguel_ate = number_format($aluguel_ate, 2, ".", "");

$area_de = "20";
$area_ate = "1000";

if (isset($_GET['area_de'])) $area_de = $_GET['area_de'];
if (isset($_GET['area_ate'])) $area_ate = $_GET['area_ate'];

$lista_imoveis->area_de = $area_de;
$lista_imoveis->area_ate = $area_ate;

$area_de = number_format($area_de, 2, ".", "");
$area_ate = number_format($area_ate, 2, ".", "");

$salas = $banheiro = $quartos = 1;


$lista_imoveis->listar();
$cards = $lista_imoveis->cards();

$title = "Sistema de Locação de imóveis";

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
                <form action="/" method="get">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon3">Casa, Apartamento ou Comercial</span>

                        <input name="filtro" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Pesquise por bairro, cidade, cep ou endereco" value="<?= $filtro ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi-search"></i>
                        </button>
                        <div class="btn-group dropleft">
                            <button type="button" id="filtros" class="btn btn-secondary dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                                Filtros
                            </button>
                            <div class="dropdown-menu lista-filtros" aria-labelledby="filtros" style="min-width:300px">
                                <p class="dropdown-item">
                                    Aluguel de:<br />
                                    <b>R$ <input type="number" id="aluguel_de" name="aluguel_de" min="100" pattern="[0-9]+([\,][0-9]+)?" value="<?= $aluguel_de ?>" step="0.01" style="width:80px" /> </b>
                                    <br />Até:<br />
                                    <b>R$ <input type="number" id="aluguel_ate" name="aluguel_ate" max="20000" pattern="[0-9]+([\,][0-9]+)?" value="<?= $aluguel_ate ?>" step="0.01" style="width:80px" /></b>
                                </p>
                                <p class="dropdown-item">
                                    Área de:<br />
                                    <b><input type="number" id="area_de" name="area_de" min="20" pattern="[0-9]+([\,][0-9]+)?" value="<?= $area_de ?>" step="0.01" style="width:80px" /> m²</b>
                                    <br />Até:<br />
                                    <b><input type="number" id="area_ate" name="area_ate" max="1000" pattern="[0-9]+([\,][0-9]+)?" value="<?= $area_ate ?>" step="0.01" style="width:80px" /> m²</b>
                                </p>
                                <div class="dropdown-divider"></div>
                                <p class="dropdown-item">
                                    Quartos:<br />
                                    <b><input type="number" id="quartos" name="quartos" min="1" pattern="[0-9]+([\,][0-9]+)?" value="<?= $quartos ?>" step="1" style="width:80px" /></b>
                                </p>
                                <p class="dropdown-item">
                                    Banheiro:<br />
                                    <b><input type="number" id="banheiro" name="banheiro" min="1" pattern="[0-9]+([\,][0-9]+)?" value="<?= $banheiro ?>" step="1" style="width:80px" /></b>
                                </p>
                                <p class="dropdown-item">
                                    Salas:<br />
                                    <b><input type="number" id="salas" name="salas" min="1" pattern="[0-9]+([\,][0-9]+)?" value="<?= $salas ?>" step="1" style="width:80px" /></b>
                                </p>
                                <button type="submit" class="btn btn-primary float-right mr-2">
                                    Filtrar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <p class="text-right"><a href="/">Limpar Filtros</a></p>
            </div>
        </div>
        <?= $cards ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="/static/js/funcs.js"></script>

    <script>
        $(document).ready(function() {
            $('.dropdown-toggle').on('click', function(event) {
                $(this).parent().toggleClass('show');
                $(".lista-filtros").toggleClass('show');
            });

        });
        console.log(jQuery);
    </script>
</body>

</html>