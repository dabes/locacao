<?php

include_once("db.php");

class Instala
{
    public $error;
    function instalar()
    {
        $db = new Database;
        if ($db->connect()) {
            $db->begin();
            $path = dirname(__FILE__) . "\sql";
            if ($dirsql = opendir($path)) {
                while (false !== ($file = readdir($dirsql))) {
                    if ($file != "." and $file != "..") {
                        $sqlfile = implode('', file($path . "\\" . $file));
                        $db->exec($sqlfile);
                        if ($db->error) {
                            $this->error = "Não foi possível instalar o banco de dados, favor verificar o erro a seguir '$db->error'";
                            return false;
                        }
                    }
                }
                closedir($dirsql);
            }
            $db->commit();
            return true;
        }
    }
}
