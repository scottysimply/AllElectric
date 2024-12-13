<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'ozarktechwebdev_all_electric');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle edit form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_product_type_id'])) {
    $product_type_id = $_POST['edit_product_type_id'];
    $product_type_name = $_POST['product_type_name'];

    // Update the product type in the database
    $sql = "UPDATE Product_Type SET product_type_name = ? WHERE product_type_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $product_type_name, $product_type_id);
    $stmt->execute();

    header('Location: editProductType.php'); // Redirect to refresh the page after update
    exit();
}

// Handle delete operation
if (isset($_GET['delete'])) {
    $product_type_id = $_GET['delete'];
    $sql = "DELETE FROM Product_Type WHERE product_type_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_type_id);
    $stmt->execute();
    header('Location: editProductType.php'); // Refresh the page after deletion
    exit();
}

// Fetch all product types from the database
$sql = "SELECT * FROM Product_Type ORDER BY product_type_name ASC";
$result = $conn->query($sql);

// Fetch the product type to edit (if edit is clicked)
$product_type = null;
if (isset($_GET['edit'])) {
    $product_type_id = $_GET['edit'];
    $sql = "SELECT * FROM Product_Type WHERE product_type_id = $product_type_id";
    $result = $conn->query($sql);
    $product_type = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product Types</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h1>Manage Product Types</h1>

        <!-- Button to add a new product type -->
        <a href="addProductType.php">
            <button type="button">Add New Product Type</button>
        </a>

        <!-- Display existing product types -->
        <h2>Existing Product Types</h2>
        <table>
            <thead>
                <tr>
                    <th>Product Type Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
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

        <!-- Edit form (appears when 'Edit' is clicked) -->
        <?php if ($product_type): ?>
            <h2>Edit Product Type</h2>
            <form action="editProductType.php" method="POST">
                <input type="hidden" name="edit_product_type_id" value="<?= $product_type['product_type_id']; ?>">
                <label for="product_type_name">Product Type Name:</label>
                <input type="text" id="product_type_name" name="product_type_name" value="<?= htmlspecialchars($product_type['product_type_name']); ?>" required>
                <button type="submit">Update Product Type</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
