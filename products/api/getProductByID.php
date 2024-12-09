<?php
    try {
        header('Content-Type: application/json');
        include_once $_SERVER['DOCUMENT_ROOT'].'/all-electric/products/productDb.php';
        $query = "SELECT * FROM products WHERE product_id = :id;";
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $preparedQuery = $pdo->prepare($query, [':id' => $id]);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo(json_encode($results));        
    }
    catch (Exception $ex) {
        echo("An error has occured with the API. Error message: \n");
        echo($ex->getMessage());
    }

?>