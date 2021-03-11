<?php
// CONECTA AO BANCO DE DADOS COM OS DADOS PARAMETRIZADOS
class Database
{
    private $servername = "localhost";
    private $username = "locacaoUser";
    private $password = "userdalocacao";
    private $dbname  = "locacao";

    public $conn = null;
    public $result = null;
    public $error = null;
    public $stmt = null;

    function connect()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $this->conn->set_charset('utf8');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        } else return true;
    }

    function queryPrepared($sql, array $args)
    {
        $stmt = $this->conn->stmt_init();
        $stmt->prepare($sql);
        $params = [];
        $types  = array_reduce($args, function ($string, &$arg) use (&$params) {
            $params[] = &$arg;
            if (is_float($arg))         $string .= 'd';
            elseif (is_integer($arg))   $string .= 'i';
            elseif (is_string($arg))    $string .= 's';
            else                        $string .= 'b';
            return $string;
        }, '');
        array_unshift($params, $types);
        call_user_func_array(array($stmt, 'bind_param'), $params);
        $stmt->execute();
        $this->result = $stmt->get_result();
        $this->stmt = $stmt;
    }

    function exec($sql, array $args = array())
    {
        if ($args) {
            $this->queryPrepared($sql, $args);
        } else {
            $this->result = $this->conn->query($sql);
            if ($this->conn->errno != 0) {
                $this->result = null;
                $this->error = $this->conn->error;
            }
        }
    }

    function begin()
    {
        $this->result = $this->conn->begin_transaction();
    }

    function commit()
    {
        if ($this->error) $this->result = $this->conn->rollback();
        else $this->result = $this->conn->commit();
    }

    // function fetch()
    // {
    //     if ($this->result) {
    //         if ($this->result->num_rows > 0) {
    //             print($this->result->num_rows);
    //             return $this->result->fetch_assoc();
    //         } else return null;
    //     }
    // }

    function close()
    {
        $this->conn->close();
    }
}
