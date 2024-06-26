<?php
// Classe Client para gerenciar clientes
class Client {
    private $conn; // Conexão com o banco de dados
    private $table_name = "clients"; // Nome da tabela no banco de dados

    // Propriedades da classe Client
    public $id;
    public $name;
    public $email;

    // Construtor da classe, recebe a conexão com o banco de dados como parâmetro
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para criar um novo cliente no banco de dados
    public function create() {
        // Query SQL para inserir dados na tabela clients
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, email=:email";
        $stmt = $this->conn->prepare($query); // Prepara a query

        // Sanitiza os valores das propriedades da classe para evitar injeção de SQL
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Liga os parâmetros com os valores das propriedades da classe
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);

        // Executa a query e retorna true se bem-sucedido, caso contrário, false
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para ler todos os clientes do banco de dados
    public function read() {
        // Query SQL para selecionar todos os dados da tabela clients
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query); // Prepara a query
        $stmt->execute(); // Executa a query
        return $stmt; // Retorna o resultado da query
    }

    // Método para atualizar um cliente existente no banco de dados
    public function update() {
        // Query SQL para atualizar dados na tabela clients
        $query = "UPDATE " . $this->table_name . " SET name=:name, email=:email WHERE id=:id";
        $stmt = $this->conn->prepare($query); // Prepara a query

        // Sanitiza os valores das propriedades da classe para evitar injeção de SQL
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Liga os parâmetros com os valores das propriedades da classe
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":id", $this->id);

        // Executa a query e retorna true se bem-sucedido, caso contrário, false
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para deletar um cliente do banco de dados
    public function delete() {
        // Query SQL para deletar um registro da tabela clients
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query); // Prepara a query

        // Sanitiza o valor da propriedade id para evitar injeção de SQL
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id); // Liga o id do cliente como parâmetro

        // Executa a query e retorna true se bem-sucedido, caso contrário, false
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
