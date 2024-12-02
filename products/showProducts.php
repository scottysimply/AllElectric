<?php
    include 'productDb.php';
    $product_results = [];
    try {
        $stmt = $pdo->query('SELECT * FROM products');
        $product_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Database error: ' . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Brand ID</th>
                <th>Product Type ID</th>
                <th>Product Name</th>
                <th>Product Description</th>
                <th>Product Intended Use</th>
                <th>Product Image</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($product_results as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                    <td><?php echo htmlspecialchars($product['brand_id']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_type_id']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_desc']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_intended_use']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" width="100"></td>
                    <td><a href="editProduct.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>">Edit</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>