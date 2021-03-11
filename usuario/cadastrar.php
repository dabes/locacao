<?php

session_start();
if ($_SESSION["usuario"]) {
    header('Location: ' . '/');
}

if (isset($_POST['nome'])) {
    include_once($_SERVER['DOCUMENT_ROOT'] . "/usuario/usuario.php");
    $usuario = new Usuario;
    $usuario->usuario = $_POST['nome'];
    $usuario->email = $_POST['email'];
    $usuario->confirmar_email = $_POST['confirmaremail'];
    $usuario->senha = $_POST['senha'];
    $usuario->confirmar_senha = $_POST['confirmarsenha'];

    $cadastro = $usuario->cadastrar();

    if ($cadastro === true) {
        $retorno_cadastro = "<h4 class='text-success'><b>USUÁRIO CADASTRADO COM SUCESSO</b></h4>";
    } else {
        $retorno_cadastro = "<h4 class='text-danger'><b>" . $cadastro . "</b></h4>";
    }
} else {
    $retorno_cadastro = "";
}






$title = "Sistema de Locação de imóveis - Cadastrar Usuário";
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
        <p class="text-right"><a href="/usuario/cadastrar">Cadastrar</a> ou <a href="/usuario/login">Login</a></p>
        <div class="row">
            <div class="col-sm">

                <h1 class="text-center fs-1">SITE DE LOCAÇÃO DE IMÓVEIS</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <?= $retorno_cadastro ?>
                <form action="/usuario/cadastrar" method="post" class="needs-validation" novalidate oninput='
                    confirmaremail.setCustomValidity(confirmaremail.value != email.value ? "Email não confere." : "");
                    confirmarsenha.setCustomValidity(confirmarsenha.value != senha.value ? "Senha não confere." : "")'>
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" name="nome" id="nome" aria-describedby="nomeHelp" placeholder="Entre com nome completo" required>
                        <div class="valid-feedback">
                            OK
                        </div>
                        <div class="invalid-feedback">
                            Favor entrar com o nome!
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Entre com email" required>
                            <div class="valid-feedback">
                                OK
                            </div>
                            <div class="invalid-feedback">
                                Favor entrar com um e-mail!
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="confirmarEmail">Confirmar Email</label>
                            <input type="email" class="form-control" name="confirmaremail" id="confirmarEmail" aria-describedby="confirmarEmailHelp" placeholder="Confirme o email" required>
                            <div class="valid-feedback">
                                OK
                            </div>
                            <div class="invalid-feedback">
                                Favor entrar com um e-mail igual ao campo anterior!
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="senha">Senha</label>
                            <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" required>
                            <div class="valid-feedback">
                                OK
                            </div>
                            <div class="invalid-feedback">
                                Favor entrar com uma senha!
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="confirmarSenha">Confirmar Senha</label>
                            <input type="password" class="form-control" name="confirmarsenha" id="confirmarSenha" placeholder="Confirme a senha" required>
                            <div class="valid-feedback">
                                OK
                            </div>
                            <div class="invalid-feedback">
                                Favor entrar com uma senha igual ao campo anterior!
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="/static/js/funcs.js"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>