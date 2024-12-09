<?php
    try {
        header('Content-Type: application/json');
        include_once $_SERVER['DOCUMENT_ROOT'].'/all-electric/products/productDb.php';
        $query = "SELECT * FROM product_type";
        $statement = $pdo->query($query);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo(json_encode($results));        
    }
    catch (Exception $ex) {
        echo("An error has occured with the API. Error message: \n");
        echo($ex->getMessage());
    }

?>