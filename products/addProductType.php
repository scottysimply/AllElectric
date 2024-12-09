<?php
// Database connection
$dsn = 'mysql:host=localhost;dbname=ozarktechwebdev_all_electric;charset=utf8mb4';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission for adding a product type
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_type_name = $_POST['product_type_name'];

    // Insert new product type using prepared statements
    $sql = "INSERT INTO Product_Type (product_type_name) VALUES (:product_type_name)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':product_type_name' => $product_type_name,
    ]);

    // Redirect to the editProductType page after adding
    header('Location: editProductType.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product Type</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Add New Product Type</h1>
        
        <!-- Add Product Type Form -->
        <form action="addProductType.php" method="POST">
            <label for="product_type_name">Product Type Name:</label>
            <input type="text" id="product_type_name" name="product_type_name" required>

            <button type="submit">Add Product Type</button>
        </form>

        <!-- Button to go back to the editProductType.php page -->
        <a href="editProductType.php">
            <button type="button">Back to Product Type List</button>
        </a>
    </div>
</body>
</html>
