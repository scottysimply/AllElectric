<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'ozarktechwebdev_all_electric');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all product types from the database
$sql = "SELECT * FROM Product_Type ORDER BY product_type_name ASC";
$result = $conn->query($sql);

// Handle delete operation
if (isset($_GET['delete'])) {
    $product_type_id = $_GET['delete'];
    $sql = "DELETE FROM Product_Type WHERE product_type_id = $product_type_id";
    $conn->query($sql);
    header('Location: editProductType.php'); // Refresh the page after deletion
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product Types</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Manage Product Types</h1>

        <!-- Button to add a new product type -->
        <a href="addProductType.php">
            <button type="button">Add New Product Type</button>
        </a>

        <!-- Display existing product types -->
        <table>
            <thead>
                <tr>
                    <th>Product Type Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the results and display them
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['product_type_name'] . "</td>";
                        echo "<td>
                                <a href='editProductType.php?edit=" . $row['product_type_id'] . "'>
                                    <button type='button'>Edit</button>
                                </a>
                                <a href='editProductType.php?delete=" . $row['product_type_id'] . "' onclick='return confirm(\"Are you sure you want to delete this product type?\")'>
                                    <button type='button'>Delete</button>
                                </a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No product types found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
