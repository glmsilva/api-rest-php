<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/bancodedados.php';
 
// instantiate product object
include_once '../objects/produtos.php';
 
$database = new Database();
$db = $database->getConnection();
 
$product = new Produto($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->prod_nome) &&
    !empty($data->prod_preco) &&
    !empty($data->prod_desc) &&
    !empty($data->catego_id)
){
 
    // set product property values
    $product->prod_nome = $data->prod_nome;
    $product->prod_preco = $data->prod_preco;
    $product->prod_desc = $data->prod_desc;
    $product->catego_id = $data->catego_id;
    $product->created = date('Y-m-d H:i:s');
 
    // create the product
    if($product->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Product was created."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create product."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
?>