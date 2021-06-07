<?php
// headers requeridos
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database conexao
include_once '../config/database.php';
include_once 'read_database.php';
  
// instanciando database 
$database = new Database();
$db = $database->getConnection();
  
// instanciando o objeto
$ranking = new Ranking($db);
  
// lendo o ranking
$stmt = $ranking->read();
$num = $stmt->rowCount();

if($num>0){
  
    $data=array();
    $data["records"]=array();
  
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
  
        $data_item=array(
            "pontuacao" => $pontuacao,
            "nome_pessoa" => $nome_pessoa,
            "nome_movimento" => $nome_movimento,
            "data_ranking" => $data_ranking
        );
  
        array_push($data["records"], $data_item);
    }
  
    //definindo response code - 200 OK
    http_response_code(200);
  
    // mostrando o ranking no formato json
    echo json_encode($data, JSON_PRETTY_PRINT);
    print_r($data);
}
  
else{
  
    // definindo response code - 404 Not found
    http_response_code(404);
  
    echo json_encode(
        array("message" => "Nenhum ranking encontrado.")
    );
}