<?php include '../controller/db_connection.php'; 
$query = $pdo->query("SELECT * FROM PRODUCTS");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="output.css">
    <title>Admin Dashboard | ShowProducts</title>
</head>
<body style="font-family: 'Josefin Sans', sans-serif;">
    <h1 class="text-center text-5xl mt-8">Admin Dashboard</h1>
    <div class="text-center">
        <table>
            
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
            <?php while($item = $query->fetch(PDO::FETCH_ASSOC)){ ?>
            <tr>
                <td><?php echo htmlspecialchars($item['product_id']); ?></td>
                <td><?php echo htmlspecialchars($item['brand_id']); ?></td>
                <td><?php echo htmlspecialchars($item['product_type_id']); ?></td>
                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                <td><?php echo htmlspecialchars($item['product_desc']); ?></td>
                <td><?php echo htmlspecialchars($item['product_intended_use']); ?></td>
                <td><?php echo htmlspecialchars($item['product_image']); ?></td>
                <td><a href="editProduct.php?id=<?php echo $item['product_id']; ?>">Edit</a></td>
            </tr>
            <?php } ?>
        </table>
        <button onclick="window.location.href='addProduct.php';" class="button mt-4">Add New Plant</button>
    </div>
</body>
</html>
