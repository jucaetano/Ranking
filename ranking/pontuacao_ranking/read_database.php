<?php
class Ranking{
  
    // conexao banco 
    private $conn;
    private $table_name = "personal_record";
  
    public $pontuacao;
    public $nome_pessoa;
    public $nome_movimento;
    public $data_ranking;

  
    // construtor conexao banco
    public function __construct($db){
        $this->conn = $db;
    }
    // lendo o ranking
    function read(){

        $query = "SELECT
                    MAX(value) AS pontuacao, DATE_FORMAT(pr.date,'%d-%m-%Y') as data_ranking, u.name as nome_pessoa, m.name as nome_movimento
                FROM
                    " . $this->table_name . " pr
                    INNER JOIN user u ON pr.user_id=u.id 
                    INNER JOIN movement m ON pr.movement_id=m.id
                    GROUP BY user_id 
                    ORDER BY MAX(value) DESC";
    
        // preparar declaração de consulta
        $stmt = $this->conn->prepare($query);
    
        // executa consulta
        $stmt->execute();
    
        return $stmt;
    }
}
?>