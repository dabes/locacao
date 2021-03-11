<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/libs/db.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/libs/helpers.php");

// LISTA OS IMOVEIS PARA A PAGINA DE PESQUISA
class Cadastro_imovel
{
    public $imovel;
    public $id;

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
                var_dump($imagem);
                $insert_imagem_arr = array($id['id'], $imagem['imagem'], $imagem['mimetype'], $this->imovel['usuario_id'], ($imagem['principal'] ? 1 : 0));
                $db->exec($sql, $insert_imagem_arr);
                var_dump($db);
            }
        }
        $db->commit();
        return $db->error;
    }

    function Atualizar()
    {
        return true;
    }
}
