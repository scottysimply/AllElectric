<?php
include '../model/productDb.php';

if (isset($_GET['id'])) {
    
    $product_id = $_GET['id'];
    echo "here";
    $sql = "DELETE FROM products WHERE product_id = :product_id";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Product deleted successfully.";
            header("Location: ../view/showProducts.php");
        } else {
            echo "Error deleting product: " . $stmt->errorInfo()[2];
        }
    } else {
        echo "Error preparing statement: " . $pdo->errorInfo()[2];
    }

    $pdo = null;
} else {
    echo "No product ID provided.";
}
?>