<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/libs/db.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/libs/helpers.php");

// LISTA OS IMOVEIS PARA A PAGINA DE PESQUISA
class Cadastro_imovel
{
    public $imovel;
    public $id;
    public $usuario;

    function Cadastrar()
    {
        if ($this->id) return $this->Atualizar();
        $db = new Database;
        if ($db->connect()) {
            $db->begin();
            $sql = "INSERT INTO imovel (titulo
                                 , valor
                                 , condominio
                                 , iptu
                                 , area
                                 , quartos
                                 , salas
                                 , banheiro
                                 , descricao
                                 , endereco
                                 , numero
                                 , complemento
                                 , bairro
                                 , cidade
                                 , estado
                                 , cep 
                                 , usuario_id)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) 
            ";
            $insert_arr = array(
                $this->imovel['titulo'],
                $this->imovel['valor'],
                $this->imovel['condominio'],
                $this->imovel['iptu'],
                $this->imovel['area'],
                $this->imovel['quartos'],
                $this->imovel['salas'],
                $this->imovel['banheiro'],
                $this->imovel['descricao'],
                $this->imovel['endereco'],
                $this->imovel['numero'],
                $this->imovel['complemento'],
                $this->imovel['bairro'],
                $this->imovel['cidade'],
                $this->imovel['estado'],
                $this->imovel['cep'],
                $this->imovel['usuario_id'],
            );
            $db->exec($sql, $insert_arr);
            $db->exec("SELECT LAST_INSERT_ID() as id;");
            $id = $db->result->fetch_assoc();
            $sql = "INSERT INTO imovel_caracteristica(imovel_id,descricao,usuario_id)
                    VALUES (?, ?, ?)
            ";

            foreach ($this->imovel['caracteristicas'] as $caracteristica) {
                $insert_caracteristica_arr = array($id['id'], $caracteristica, $this->imovel['usuario_id']);
                $db->exec($sql, $insert_caracteristica_arr);
            }
            $sql = "INSERT INTO imovel_imagem(imovel_id,imagem,mimetype,usuario_id,principal)
                    VALUES (?, ?, ?, ?, ?)
            ";
            foreach ($this->imovel['imagens'] as $imagem) {
                $insert_imagem_arr = array($id['id'], $imagem['imagem'], $imagem['mimetype'], $this->imovel['usuario_id'], ($imagem['principal'] ? 1 : 0));
                $db->exec($sql, $insert_imagem_arr);
            }
        }
        $db->commit();
        return $db->error;
    }

    function Atualizar()
    {
        if (!$this->id) return false;
        $db = new Database;
        if ($db->connect()) {
            $db->begin();
            $sql = "UPDATE imovel 
                       SET titulo = ?
                         , valor = ?
                         , condominio = ?
                         , iptu = ?
                         , area = ?
                         , quartos = ?
                         , salas = ?
                         , banheiro = ?
                         , descricao = ?
                         , endereco = ?
                         , numero = ?
                         , complemento = ?
                         , bairro = ?
                         , cidade = ?
                         , estado = ?
                         , cep  = ?
                         , usuario_id = ?
                     WHERE id = ? 
            ";
            $insert_arr = array(
                $this->imovel['titulo'],
                $this->imovel['valor'],
                $this->imovel['condominio'],
                $this->imovel['iptu'],
                $this->imovel['area'],
                $this->imovel['quartos'],
                $this->imovel['salas'],
                $this->imovel['banheiro'],
                $this->imovel['descricao'],
                $this->imovel['endereco'],
                $this->imovel['numero'],
                $this->imovel['complemento'],
                $this->imovel['bairro'],
                $this->imovel['cidade'],
                $this->imovel['estado'],
                $this->imovel['cep'],
                $this->imovel['usuario_id'],
                $this->id
            );
            $db->exec($sql, $insert_arr);
            $sql = "DELETE FROM imovel_caracteristica WHERE imovel_id = ?";
            $db->exec($sql, array($this->id));
            $sql = "INSERT INTO imovel_caracteristica(imovel_id,descricao,usuario_id)
                    VALUES (?, ?, ?)
            ";

            foreach ($this->imovel['caracteristicas'] as $caracteristica) {
                $insert_caracteristica_arr = array($this->id, $caracteristica, $this->imovel['usuario_id']);
                $db->exec($sql, $insert_caracteristica_arr);
            }

            if (isset($this->imovel['imagens'])) {
                $sql = "DELETE FROM imovel_imagem WHERE imovel_id = ?";
                $db->exec($sql, array($this->id));
                $sql = "INSERT INTO imovel_imagem(imovel_id,imagem,mimetype,usuario_id,principal)
                        VALUES (?, ?, ?, ?, ?)
                ";
                foreach ($this->imovel['imagens'] as $imagem) {
                    $insert_imagem_arr = array($this->id, $imagem['imagem'], $imagem['mimetype'], $this->imovel['usuario_id'], ($imagem['principal'] ? 1 : 0));
                    $db->exec($sql, $insert_imagem_arr);
                }
            }
        }
        $db->commit();
        return $db->error;
    }

    function Apagar()
    {
        if (!$this->usuario or !$this->id) return false;
        $db = new Database;
        if ($db->connect()) {
            $db->begin();
            $sql = "SELECT TRUE AS permite FROM imovel WHERE usuario_id = ? and id = ?";
            $db->exec($sql, array($this->usuario, $this->id));
            $permite = $db->result->fetch_assoc();
            if ($permite['permite']) {
                $sql = "DELETE FROM imovel_imagem WHERE imovel_id = ?";
                $db->exec($sql, array($this->id));
                $sql = "DELETE FROM imovel_caracteristica WHERE imovel_id = ?";
                $db->exec($sql, array($this->id));
                $sql = "DELETE FROM imovel WHERE id = ?";
                $db->exec($sql, array($this->id));
            } else {
                return "Usuário sem permissão para apagar o registro!";
            }
        }
        $db->commit();
        return $db->error;
    }
}
