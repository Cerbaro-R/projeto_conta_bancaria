<?php
// Classe Account para gerenciar contas bancárias
class Account {
    private $conn; // Conexão com o banco de dados
    private $table_name = "accounts"; // Nome da tabela no banco de dados

    // Propriedades da classe Account
    private $id;
    private $account_number;
    private $balance;
    private $client_id;

    // Construtor da classe, recebe a conexão com o banco de dados como parâmetro
    public function __construct($db) {
        $this->conn = $db;
    }

    // Métodos getters e setters para acessar e definir as propriedades de forma segura

    // Retorna o id da conta
    public function getId() {
        return $this->id;
    }

    // Define o id da conta
    public function setId($id) {
        $this->id = htmlspecialchars(strip_tags($id));
    }

    // Retorna o número da conta
    public function getAccountNumber() {
        return $this->account_number;
    }

    // Define o número da conta
    public function setAccountNumber($account_number) {
        $this->account_number = htmlspecialchars(strip_tags($account_number));
    }

    // Retorna o saldo da conta
    public function getBalance() {
        return $this->balance;
    }

    // Define o saldo da conta
    public function setBalance($balance) {
        $this->balance = htmlspecialchars(strip_tags($balance));
    }

    // Retorna o id do cliente associado à conta
    public function getClientId() {
        return $this->client_id;
    }

    // Define o id do cliente associado à conta
    public function setClientId($client_id) {
        $this->client_id = htmlspecialchars(strip_tags($client_id));
    }

    // Métodos CRUD (Create, Read, Update, Delete)

    // Método para criar uma nova conta no banco de dados
    public function create() {
        // Query SQL para inserir dados na tabela accounts
        $query = "INSERT INTO " . $this->table_name . " SET account_number=:account_number, balance=:balance, client_id=:client_id";
        $stmt = $this->conn->prepare($query); // Prepara a query

        // Liga os parâmetros com os valores das propriedades da classe
        $stmt->bindParam(":account_number", $this->account_number);
        $stmt->bindParam(":balance", $this->balance);
        $stmt->bindParam(":client_id", $this->client_id);

        // Executa a query e retorna true se bem-sucedido, caso contrário, false
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para ler todas as contas do banco de dados
    public function read() {
        // Query SQL para selecionar dados da tabela accounts com junção na tabela clients
        $query = "SELECT a.id, a.account_number, a.balance, c.name as client_name, c.email as client_email 
                  FROM " . $this->table_name . " a 
                  LEFT JOIN clients c ON a.client_id = c.id";
        $stmt = $this->conn->prepare($query); // Prepara a query
        $stmt->execute(); // Executa a query
        return $stmt; // Retorna o resultado da query
    }

    // Método para atualizar uma conta existente no banco de dados
    public function update() {
        // Query SQL para atualizar dados na tabela accounts
        $query = "UPDATE " . $this->table_name . " SET account_number=:account_number, balance=:balance, client_id=:client_id WHERE id=:id";
        $stmt = $this->conn->prepare($query); // Prepara a query

        // Liga os parâmetros com os valores das propriedades da classe
        $stmt->bindParam(":account_number", $this->account_number);
        $stmt->bindParam(":balance", $this->balance);
        $stmt->bindParam(":client_id", $this->client_id);
        $stmt->bindParam(":id", $this->id);

        // Executa a query e retorna true se bem-sucedido, caso contrário, false
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para deletar uma conta do banco de dados
    public function delete() {
        // Query SQL para deletar um registro da tabela accounts
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query); // Prepara a query

        $stmt->bindParam(1, $this->id); // Liga o id da conta como parâmetro

        // Executa a query e retorna true se bem-sucedido, caso contrário, false
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Métodos adicionais

    // Método para depositar um valor na conta
    public function deposit($amount) {
        $this->balance += $amount; // Adiciona o valor ao saldo atual
        return $this->updateBalance(); // Atualiza o saldo no banco de dados
    }

    // Método para sacar um valor da conta
    public function withdraw($amount) {
        // Verifica se há saldo suficiente
        if ($this->balance >= $amount) {
            $this->balance -= $amount; // Subtrai o valor do saldo atual
            return $this->updateBalance(); // Atualiza o saldo no banco de dados
        }
        return false; // Retorna false se não houver saldo suficiente
    }

    // Método privado para atualizar o saldo no banco de dados
    private function updateBalance() {
        // Query SQL para atualizar o saldo na tabela accounts
        $query = "UPDATE " . $this->table_name . " SET balance=:balance WHERE id=:id";
        $stmt = $this->conn->prepare($query); // Prepara a query

        // Liga os parâmetros com os valores das propriedades da classe
        $stmt->bindParam(":balance", $this->balance);
        $stmt->bindParam(":id", $this->id);

        // Executa a query e retorna true se bem-sucedido, caso contrário, false
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
