<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: /");

include_once($_SERVER['DOCUMENT_ROOT'] . "/imoveis/listagem.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/imoveis/cadastro.php");
$imovel = new Listar_imovel;
$cadastro = new Cadastro_imovel;

if (isset($_POST['titulo'])) {
    $dados_imovel = $_POST;
    if ($_POST['usuario_id'] != $_SESSION['usuario']['id']) echo "<script type='javascript'>alert('Proíbido alterar um imóvel que não é seu!');";


    foreach ($dados_imovel['caracteristicas'] as $index => $valor) {
        if ($valor == "") unset($dados_imovel['caracteristicas'][$index]);
    }

    // temos imagens
    if (isset($_FILES['imagens']) and $_FILES['imagens']['name'][0] != "") {
        $dados_imagens = $_FILES['imagens'];
        $imagens_blobs = array();
        $principal = true; // implementar seleção da foto principal no momento pega a primeira
        foreach ($dados_imagens['name'] as $index => $imagem_data) {
            $imagens_blobs[] = array('imagem' => file_get_contents($dados_imagens['tmp_name'][$index]), 'principal' => $principal, 'mimetype' => $dados_imagens['type'][$index]);
            $principal = false;
        }
        $dados_imovel['imagens'] = $imagens_blobs;
    }

    // se nao existir id ele vai inserir senao atualizar
    if (!isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = false;
    }
    $cadastro_edit = "Editar";
    $cadastro->imovel = $dados_imovel;
    $cadastro->Cadastrar();
}

if (!isset($_GET['id'])) {
    $cadastro_edit = "Cadastrar";
} else {
    $cadastro_edit = "Editar";
    $imovel->id = $_GET['id'];

    $imovel->listar();
    if ($imovel->imovel->usuario_id != $_SESSION['usuario']['id']) header("Location: /imoveis/meusimoveis");
}



$title = "Sistema de Locação de imóveis - " . (isset($imovel->imovel->titulo) ? $imovel->imovel->titulo : " Cadastrar ");


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
        <h4 class="text-center"><?= $cadastro_edit ?></h4>
        <form action="/imoveis/editar.php<?= (isset($_GET['id']) ? "?id=" . $_GET['id'] : "") ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label label for="titulo">Titulo</label>
                <input name="usuario_id" type="hidden" class="form-control" id="usuario_id" value="<?= (isset($_SESSION['usuario']['id']) ? $_SESSION['usuario']['id'] : "") ?>">
                <input name="titulo" type="text" class="form-control" id="titulo" placeholder="Titulo" value="<?= (isset($imovel->imovel->titulo) ? $imovel->imovel->titulo : "") ?>" required>
                <div class="valid-feedback">
                    OK
                </div>
                <div class="invalid-feedback">
                    Favor entrar com o Titulo!
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4">
                        <label label for="titulo">Valor do Aluguel</label>
                        <input name="valor" type="number" class="form-control" id="valor" placeholder="Valor do Aluguel" pattern="[0-9]+([\,][0-9]+)?" step="0.01" value="<?= (isset($imovel->imovel->valor) ? $imovel->imovel->valor : "") ?>" required>
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o Valor do Aluguel!
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label label for="condominio">Condominio</label>
                        <input name="condominio" type="number" class="form-control" id="condominio" placeholder="Condominio" pattern="[0-9]+([\,][0-9]+)?" step="0.01" value="<?= (isset($imovel->imovel->condominio) ? $imovel->imovel->condominio : "") ?>" required>
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o Condominio!
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label label for="iptu">IPTU</label>
                        <input name="iptu" type="number" class="form-control" id="iptu" placeholder="IPTU" pattern="[0-9]+([\,][0-9]+)?" step="0.01" value="<?= (isset($imovel->imovel->iptu) ? $imovel->imovel->iptu : "") ?>" required>
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o IPTU!
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-3">
                        <label label for="area">Área</label>
                        <input name="area" type="number" class="form-control" id="area" placeholder="Área" pattern="[0-9]+([\,][0-9]+)?" step="0.01" value="<?= (isset($imovel->imovel->area) ? $imovel->imovel->area : "") ?>">
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o Área!
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label label for="quartos">Quartos</label>
                        <input name="quartos" type="number" class="form-control" id="quartos" placeholder="Quartos" pattern="[0-9]+([\,][0-9]+)?" step="1" value="<?= (isset($imovel->imovel->quartos) ? $imovel->imovel->quartos : "") ?>">
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o Quartos!
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label label for="salas">Salas</label>
                        <input name="salas" type="number" class="form-control" id="salas" placeholder="Salas" pattern="[0-9]+([\,][0-9]+)?" step="1" value="<?= (isset($imovel->imovel->salas) ? $imovel->imovel->salas : "") ?>">
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o Salas!
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label label for="banheiro">Banheiros</label>
                        <input name="banheiro" type="number" class="form-control" id="banheiro" placeholder="Banheiros" pattern="[0-9]+([\,][0-9]+)?" step="1" value="<?= (isset($imovel->imovel->banheiro) ? $imovel->imovel->banheiro : "") ?>">
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o Banheiros!
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">

            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-10">
                        <label label for="titulo">CEP</label>
                        <input name="cep" pattern="^\d{5}-\d{3}$" onkeypress="mascara(this, '#####-###')" maxlength="9" type="text" class="form-control" id="cep" placeholder="CEP" value="<?= (isset($imovel->imovel->cep) ? $imovel->imovel->cep : "") ?>">
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o CEP!
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-primary" onclick="consulta_cep($('#cep').val())" style="position: absolute;bottom: 0;">Consultar CEP</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-8">
                        <label label for="endereco">Endereço</label>
                        <input name="endereco" type="text" class="form-control" id="endereco" placeholder="Endereço" value="<?= (isset($imovel->imovel->endereco) ? $imovel->imovel->endereco : "") ?>">
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o Endereço!
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label label for="numero">Numero</label>
                        <input name="numero" type="text" class="form-control" id="numero" placeholder="Numero" value="<?= (isset($imovel->imovel->numero) ? $imovel->imovel->numero : "") ?>">
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o Numero!
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <label label for="complemento">Complemento</label>
                        <input name="complemento" type="text" class="form-control" id="complemento" placeholder="Complemento" value="<?= (isset($imovel->imovel->complemento) ? $imovel->imovel->complemento : "") ?>">
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o Complemento!
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">
                        <label label for="bairro">Bairro</label>
                        <input name="bairro" type="text" class="form-control" id="bairro" placeholder="Bairro" value="<?= (isset($imovel->imovel->bairro) ? $imovel->imovel->bairro : "") ?>">
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o Bairro!
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <label label for="cidade">Cidade</label>
                        <input name="cidade" type="text" class="form-control" id="cidade" placeholder="Cidade" value="<?= (isset($imovel->imovel->cidade) ? $imovel->imovel->cidade : "") ?>">
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o Cidade!
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label label for="estado">Estado</label>
                        <input name="estado" type="text" class="form-control" id="estado" placeholder="Estado" value="<?= (isset($imovel->imovel->estado) ? $imovel->imovel->estado : "") ?>">
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o Estado!
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <h5>Descrição</h5>
                <textarea name="descricao" id="descricao" rows="10" cols="80"><?= (isset($imovel->imovel->descricao) ? $imovel->imovel->descricao : "") ?></textarea>
            </div>
            <div class="form-group">
                <div class="editcaracteristicas">
                    <h5>Caracteristicas</h5>
                    <button id="adicionar_caracteristica" type="button" class="btn btn-primary mb-2">Adicionar +</button>
                    <?php $id = 1;
                    if (isset($imovel->imovel->caracteristicas)) {
                        foreach ($imovel->imovel->caracteristicas as $caracteristica) {
                    ?>
                            <div class="row mb-1" id="div-caracteristica-<?= $id ?>">
                                <div class="col-sm-10">
                                    <input name="caracteristicas[]" type="text" class="form-control" id="caracteristica_<?= $id ?>" placeholder="Escreva uma caracteristica" value="<?= $caracteristica ?>">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary" onClick="$('#div-caracteristica-<?= $id ?>').remove()" id="remove_caracteristica_<?= $id ?>">Remover Item</button>
                                </div>
                            </div>
                    <?php
                            $id++;
                        }
                    }    ?>
                    <div class="row mb-1" id="div-caracteristica-<?= $id ?>">
                        <div class="col-sm-10">
                            <input name="caracteristicas[]" type="text" class="form-control  mb-1" id="caracteristica_<?= $id ?>" placeholder="Escreva uma caracteristica">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary" onClick="$('#div-caracteristica-<?= $id ?>').remove()" id="remove_caracteristica_<?= $id ?>">Remover Item</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="editimagens">
                    <h5>Imagens do Imóvel</h5>
                    <div class="row mb-1" id="div-imagem-1">
                        <div class="col-sm-4">
                            <input name="imagens[]" type="file" id="image-1" onchange="mostrarImagens(this)" style="display:none" multiple="multiple"><br>
                            <input class="btn btn-primary" type="button" id="simage-1" onclick="$('#image-1').click()" value="Escolher Imagens"><br>
                        </div>

                    </div>
                    <?php
                    if (isset($imovel->imovel->imagens)) {
                        foreach ($imovel->imovel->imagens as $imagem) { ?>
                            <img src="data:image/jpg;base64,<?= imagem_blob_to_base64($imagem['imagem']) ?>" height="200" alt="Image preview..." id="img-1" class='mr-1 mb-1'>
                    <?php
                        }
                    } ?>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Gravar
                </button>
            </div>

        </form>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
        <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
        <script src="/static/js/funcs.js"></script>
        <script>
            $(document).ready(function() {
                $(window).keydown(function(event) {
                    if (event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                });
                CKEDITOR.replace('descricao', {
                    language: 'en',
                    removePlugins: 'about,image,url,sourcearea,maximize,link',

                });
            });

            $("#adicionar_caracteristica").click(function() {
                var lastField = $(".editcaracteristicas input:last");
                if (lastField && lastField.length) {
                    var id = parseInt(lastField.attr('id').split("_")[1], 10) + 1;
                } else {
                    var id = 1;
                }
                var wrow = $("<div class='row mb-1' id='div-caracteristica-" + id + "'></div>");
                var wcol1 = $("<div class='col-sm-10'></div>");
                var wcol2 = $("<div class='col-sm-2'></div>");
                var fName = $("<input name=\"caracteristicas[]\" type=\"text\" class=\"form-control  mb-1\" id=\"caracteristica_" + id + "\" placeholder=\"Escreva uma caracteristica\">");
                var fRemove = $("<button type=\"button\" class=\"btn btn-primary\" onClick=\"$('#div-caracteristica-" + id + "').remove()\" id=\"remove_caracteristica_" + id + "\">Remover Item</button>");
                wcol1.append(fName);
                wcol2.append(fRemove);
                wrow.append(wcol1);
                wrow.append(wcol2);
                $(".editcaracteristicas").append(wrow);
            });
        </script>
</body>

</html>