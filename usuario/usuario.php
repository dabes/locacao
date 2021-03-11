<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/libs/db.php");


class Usuario
// CADASTRA, LOGA E FAZ O HASH DE SENHA (HASH SIMPLES JÁ QUE NÃO É UM SISTEMA COMERCIAL)
{
    public $email;
    public $confirmar_email;
    public $senha;
    public $confirmar_senha;
    public $usuario;
    public $session_data;

    private $senha_hash;

    public $error = array(
        "confirma_senha" => "SENHA NÃO CONFERE",
        "senha_fraca" => "SENHA NÃO PASSOU DAS POLÍTICAS",
        "confirma_email" => "E-MAIL NÃO CONFERE",
        "email_ja_cadastrado" => "E-MAIL JÁ CADASTRADO"
    );

    function cadastrar()
    {
        $db = new Database;
        $db->connect();
        // VALIDACOES
        if ($this->senha != $this->confirmar_senha) return $this->error['confirma_senha'];
        else if ($this->email != $this->confirmar_email) return $this->error['confirma_email'];
        else if (strlen($this->senha) < 6) return  $this->error['senha_fraca'];
        else {
            $sql = "SELECT TRUE FROM usuario WHERE email = ?";
            $db->exec($sql, array($this->email));
            if ($db->result->num_rows > 0) return $this->error['email_ja_cadastrado'];
            $sql = "INSERT INTO usuario (usuario,email,senha) VALUES (?,?,?);";
            $db->exec($sql, array($this->usuario, $this->email, $this->hash()));
            if (!$db->error) return true;
            else return $db->error;
        }
    }

    function login()
    {
        $db = new Database;
        $db->connect();
        $sql = "SELECT id,email,usuario FROM usuario WHERE email = ? and senha = ?";
        $db->exec($sql, array($this->email, $this->hash()));
        if ($db->result->num_rows > 0) {
            while ($usuario = $db->result->fetch_assoc()) {
                $this->session_data = $usuario;
            }
            return true;
        } else return false;
    }

    function hash()
    {
        $secret_hash = "q2083i4324i232rmnd23ne23je2o3ie230e230e!@$134d134134dcfdsf!#$";
        return base64_encode($secret_hash . $this->senha);
    }
}
