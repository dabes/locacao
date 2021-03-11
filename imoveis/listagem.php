<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/libs/db.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/libs/helpers.php");

// LISTA OS IMOVEIS PARA A PAGINA DE PESQUISA
class Listagem_imovel
{
    public $itens_pagina = 20;
    public $filtro = null;
    public $offset = 0;
    public $json = null;
    public $imoveis = null;
    public $usuario = null;
    public $aluguel_de = "100";
    public $aluguel_ate = "20000";
    public $area_de = "20";
    public $area_ate = "1000";

    function listar()
    {
        $db = new Database;
        if ($db->connect()) {
            $db2 = clone ($db);
            $filtro_sql = "";
            $filtro_arr = array();
            $filtro_sql = "WHERE valor BETWEEN ? AND ? ";
            $filtro_arr[] = $this->aluguel_de;
            $filtro_arr[] = $this->aluguel_ate;
            $filtro_sql .= "AND area BETWEEN ? AND ? ";
            $filtro_arr[] = $this->area_de;
            $filtro_arr[] = $this->area_ate;
            if ($this->filtro) {
                $this->filtro = "%" . $this->filtro . "%";
                $filtro_sql .= "AND (endereco like ?
                              OR bairro like ?
                              OR cidade like ?
                              OR estado like ?
                              OR cep like ?
                              OR complemento like ?
                              )
                ";
                $filtro_arr[] = $this->filtro;
                $filtro_arr[] = $this->filtro;
                $filtro_arr[] = $this->filtro;
                $filtro_arr[] = $this->filtro;
                $filtro_arr[] = $this->filtro;
                $filtro_arr[] = $this->filtro;
            }

            $sql = "SELECT id
                         , titulo
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
                      FROM imovel
                    " . $filtro_sql . "          
                     LIMIT $this->itens_pagina
                    OFFSET $this->offset
            ";
            $db->exec($sql, $filtro_arr);
            $imoveis = array();
            while ($imovel = $db->result->fetch_assoc()) {
                $sql = "SELECT descricao 
                              FROM imovel_caracteristica
                             WHERE imovel_id = " . $imovel['id'] . "
                    ";

                $db2->exec($sql);
                $itens_imovel = array();
                while ($imovel_caracteristica =  $db2->result->fetch_assoc()) {
                    $itens_imovel[] = $imovel_caracteristica['descricao'];
                }
                $imovel = array_merge($imovel, array("caracteristicas" => $itens_imovel));
                $sql = "SELECT imagem,principal,mimetype 
                              FROM imovel_imagem
                             WHERE imovel_id = " . $imovel['id'] . "
                    ";
                $db2->exec($sql);
                $imovel_imagem = array();
                while ($imovel_imagens =  $db2->result->fetch_assoc()) {
                    $imovel_imagem[] = $imovel_imagens;
                }
                $imovel = array_merge($imovel, array("imagens" => $imovel_imagem));
                $imoveis[] =  objectify($imovel);
            }
            $this->imoveis = objectify($imoveis);
        }
    }

    function listar_por_usuario()
    {
        $db = new Database;

        if ($db->connect()) {
            $db2 = clone ($db);
            $sql = "SELECT id
                         , titulo
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
                         , usuario_id
                      FROM imovel
                     WHERE usuario_id = ?
            ";
            $db->exec($sql, array($this->usuario));
            $imoveis = array();
            while ($imovel = $db->result->fetch_assoc()) {
                $sql = "SELECT descricao 
                              FROM imovel_caracteristica
                             WHERE imovel_id = " . $imovel['id'] . "
                    ";

                $db2->exec($sql);
                $itens_imovel = array();
                while ($imovel_caracteristica =  $db2->result->fetch_assoc()) {
                    $itens_imovel[] = $imovel_caracteristica['descricao'];
                }
                $imovel = array_merge($imovel, array("caracteristicas" => $itens_imovel));
                $sql = "SELECT imagem,principal,mimetype 
                              FROM imovel_imagem
                             WHERE imovel_id = " . $imovel['id'] . "
                    ";
                $db2->exec($sql);
                $imovel_imagem = array();
                while ($imovel_imagens =  $db2->result->fetch_assoc()) {
                    $imovel_imagem[] = $imovel_imagens;
                }
                $imovel = array_merge($imovel, array("imagens" => $imovel_imagem));
                $imoveis[] =  objectify($imovel);
            }
            $this->imoveis = objectify($imoveis);
        }
    }

    function cards()
    {
        $cards = "";
        foreach ($this->imoveis as $imovel) {
            foreach ($imovel->imagens as $imagem_data) {
                if ($imagem_data['principal']) {
                    $imagem = imagem_blob_to_base64($imagem_data['imagem']);
                    $imagem_mimetype = $imagem_data['mimetype'];
                }
            }
            $cards .=
                "<div class='row m-1 mb-3'>
                    <div class='card'>
                        <div class='card-body'>
                            <div class='row'>
                                <div class='col-sm-3'>
                                <img  class='img-fluid' src='data:" . $imagem_mimetype . ";base64," . $imagem . "'/>
                                </div>
                                <div class='col-sm-9'>
                                    <p class='h6' style='font-weight: normal'>Cód:" . $imovel->id . "</p>
                                    <h3 class='card-title'><a href='/imoveis/listar?id=" . $imovel->id . "'  class='deco-none'>" . $imovel->titulo . "</a></h3>
                                    <p>" . $imovel->endereco . "," . $imovel->numero . " " . $imovel->complemento . " - " . $imovel->bairro . ", " . $imovel->cidade . " - " . $imovel->estado . "</p>
                                    <h5> Valor Aluguel: R$" . number_format($imovel->valor, 2, ",", ".") . " Condominio: R$" . number_format($imovel->condominio, 2, ",", ".") . " IPTU: R$" . number_format($imovel->iptu, 2, ",", ".") . "
                                    <h5> Área: " . $imovel->area . "m² Quarto: " . $imovel->quartos . " Salas: " . $imovel->salas . " Banheiros: " . $imovel->banheiro . "</h5>
                                    <p class='card-text'>" . substr($imovel->descricao, 0, 250) . "...</p>
                                    <a href='/imoveis/listar?id=" . $imovel->id . "' class='btn btn-primary'>Mais Informações</a>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            ";
        }
        return $cards;
    }
}

class Listar_imovel
{
    public $id = null;
    public $imovel = null;

    function listar()
    {
        $db = new Database;

        if ($db->connect()) {
            $db2 = clone ($db);
            $sql = "SELECT id
                         , titulo
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
                         , usuario_id
                      FROM imovel
                     WHERE id = ?
            ";
            $db->exec($sql, array($this->id));
            $imoveis = array();
            while ($imovel = $db->result->fetch_assoc()) {
                $sql = "SELECT descricao 
                              FROM imovel_caracteristica
                             WHERE imovel_id = " . $imovel['id'] . "
                    ";

                $db2->exec($sql);
                $itens_imovel = array();
                while ($imovel_caracteristica =  $db2->result->fetch_assoc()) {
                    $itens_imovel[] = $imovel_caracteristica['descricao'];
                }
                $imovel = array_merge($imovel, array("caracteristicas" => $itens_imovel));
                $sql = "SELECT imagem,principal,mimetype 
                              FROM imovel_imagem
                             WHERE imovel_id = " . $imovel['id'] . "
                    ";
                $db2->exec($sql);
                $imovel_imagem = array();
                while ($imovel_imagens =  $db2->result->fetch_assoc()) {
                    $imovel_imagem[] = $imovel_imagens;
                }
                $imovel = array_merge($imovel, array("imagens" => $imovel_imagem));
                $imoveis =  objectify($imovel);
            }
            $this->imovel = $imoveis;
        }
    }

    function cards()
    {
        $cards = "";
        $imovel = $this->imovel;
        $imagens = "";
        foreach ($imovel->imagens as $imagem_data) {
            $imagem = imagem_blob_to_base64($imagem_data['imagem']);
            $mimetype = $imagem_data['mimetype'];
            $imagens .= "<div class='col-sm-3'>
                                <img  class='img-fluid' src='data:" . $mimetype . ";base64," . $imagem . "'/>
                             </div> 
            ";
        }

        $lista_caracteristica = "";
        foreach ($imovel->caracteristicas as $caracteristica) {
            $lista_caracteristica .= "<li class='list-item col-6 py-2'>$caracteristica</li>";
        }
        $cards .=
            "<div class='row m-1 mb-3'>
                    <div class='card'>
                        <div class='card-body'>
                            <div class='row'>
                                " . $imagens . "   
                            </div>
                            <div class='rows'>
                                <div class='col-sm-12'>
                                    <p class='text-right'>Cód:" . $imovel->id . "</p>
                                    <h3 class='card-title'>" . $imovel->titulo . "</h3>
                                    <p class='text-right'><a href='/imoveis/alugar?id=" . $imovel->id . "' class='btn btn-primary'>Alugar</a></p>
                                </div>
                            </div>
                            <div class='rows'>
                                <div class='col-sm-12'>
                                    <ul class='list-group list-group-flush'>
                                        <li class='list-group-item'>" . $imovel->endereco . "," . $imovel->numero . " " . $imovel->complemento . " - " . $imovel->bairro . ", " . $imovel->cidade . " - " . $imovel->estado . "</li>
                                        <li class='list-group-item'><h5>Valor Aluguel: R$" . number_format($imovel->valor, 2, ",", ".") . "</h5></li>
                                        <li class='list-group-item'><h5>Condominio: R$" . number_format($imovel->condominio, 2, ",", ".") . "</h5></li>
                                        <li class='list-group-item'><h5>IPTU: R$" . number_format($imovel->iptu, 2, ",", ".") . "</h5></li>
                                        <li class='list-group-item'><h5>Área: " . $imovel->area . "m² Quarto: " . $imovel->quartos . " Salas: " . $imovel->salas . " Banheiros: " . $imovel->banheiro . "</h5></li>
                                        <li class='list-group-item'></li>
                                    </ul>
                                    <p class='card-text text-justify'>" . $imovel->descricao . "</p>
                                </div>
                            </div>
                            <div class='rows mt-5'>
                                <div class='col-sm-12'>
                                    <hr/>
                                    <h5>Características:</h5>
                                    <ul class='list-unstyled row caracteristicas'>
                                        " . $lista_caracteristica . "
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ";

        return $cards;
    }
}
