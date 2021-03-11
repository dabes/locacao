<?php
function objectify($array)
{
    if (!is_array($array)) return false;
    $object = new stdClass();
    foreach ($array as $key => $value) {
        if (is_array($value)) objectify($value);
        $object->$key = $value;
    }
    return $object;
}


function imagem_blob_to_base64($imagem)
{
    $image = imagecreatefromstring($imagem);
    ob_start();
    imagejpeg($image, null, 80);
    $data = ob_get_contents();
    ob_end_clean();
    return  base64_encode($data);
}


function consulta_cep($cep)
{
    $url = "https://buscacepinter.correios.com.br/app/endereco/carrega-cep-endereco.php?pagina=%2Fapp%2Fendereco%2Findex.php&cepaux=&mensagem_alerta=&endereco=$cep&tipoCEP=ALL";
    $result = file_get_contents($url);
    return $result;
}
