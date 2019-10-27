<?php
class Produto{

    private $dbcon;
    private $nome_tb = "products";

    //propriedades do objeto

    public $produto_id = "";
    public $prod_nome;
    public $prod_desc;
    public $prod_preco;
    public $catego_id;
    public $catego_name;
    public $created;

    public function __construct($db){
        $this->dbcon = $db;
    }

    public function read(){

        //seleciona todas queries

        $query = "SELECT
        c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
    FROM
        " . $this->nome_tb . " p
        LEFT JOIN
            categories c
                ON p.category_id = c.id
    ORDER BY
        p.created DESC";

// prepare query statement
$stmt = $this->dbcon->prepare($query);

// execute query
$stmt->execute();

return $stmt;
}

    public function create(){
        //query para inserir dados

        $query = "INSERT INTO " . $this->nome_tb . " SET name=:prod_nome, price=:prod_preco, description=:prod_desc, category_id=:catego_id, created=:created;";
        $stmt = $this->dbcon->prepare($query);

        //sanitize

        $this->prod_nome=htmlspecialchars(strip_tags($this->prod_name));
        $this->prod_preco=htmlspecialchars(strip_tags($this->prod_preco));
        $this->prod_desc=htmlspecialchars(strip_tags($this->prod_desc));
        $this->catego_id=htmlspecialchars(strip_tags($this->catego_id));
        $this->created=htmlspecialchars(strip_tags($this->created));

        //bind values

        $stmt->bindParam(":prod_nome", $this->prod_nome);
        $stmt->bindParam(":prod_preco", $this->prod_preco);
        $stmt->bindParam(":prod_desc", $this->prod_desc);
        $stmt->bindParam(":catego_id", $this->catego_id);
        $stmt->bindParam(":created", $this->created);

        //execute query

        if($stmt->execute()){
            return true;
        }
        return false;


    }
}

   

?>