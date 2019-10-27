<?php
class Database{
    private $host = "localhost";
    private $pass = "";
    private $dbname = "api_db";
    private $user = "root";
    public $dbcon;

    //função para conectar com o banco

    public function getConnection(){
        $this->dbcon = null;

        try{
            $this->dbcon = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user,$this->pass);
            $this->dbcon->exec("set-names-utf8");
        }
        catch(PDOException $ex){

            echo "Erro de conexão" . $ex->getMessage();

        }

        return $this->dbcon;

    }
}

?>