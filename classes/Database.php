<?php
// Classe Database para gerenciar a conexão com o banco de dados
class Database {
    // Propriedades da classe Database que armazenam os detalhes da conexão
    private $host = "localhost";
    private $db_name = "bank";
    private $username = "root";
    private $password = "root";
    public $conn; // Propriedade que armazenará a conexão com o banco de dados

    // Método para obter a conexão com o banco de dados
    public function getConnection() {
        $this->conn = null; // Inicializa a conexão como nula
        try {
            // Tenta criar uma nova conexão PDO com os detalhes fornecidos
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Define o conjunto de caracteres para utf8
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            // Captura qualquer exceção (erro) e exibe uma mensagem de erro
            echo "Connection error: " . $exception->getMessage();
        }
        // Retorna a conexão
        return $this->conn;
    }
}
?>
