<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'ozarktechwebdev_all_electric');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding a product type
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_type_name = $_POST['product_type_name'];

    // Insert new product type
    $sql = "INSERT INTO Product_Type (product_type_name) VALUES ('$product_type_name')";
    $conn->query($sql);
    header('Location: editProductType.php'); // Redirect to the editProductType page after adding
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
