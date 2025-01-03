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

// Handle form submission for adding a brand
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brand_name = $_POST['brand_name'];
    $brand_logo = $_FILES['brand_logo']['name'] ?? null;

    // Handle file upload (optional)
    if ($brand_logo) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['brand_logo']['name']);
        move_uploaded_file($_FILES['brand_logo']['tmp_name'], $target_file);
    }

    // Insert new brand using prepared statements
    $sql = "INSERT INTO Brands (brand_name, brand_logo) VALUES (:brand_name, :brand_logo)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':brand_name' => $brand_name,
        ':brand_logo' => $brand_logo,
    ]);

    // Redirect to the editBrand page after adding
    header('Location: ./editBrand.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Brand</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h1>Add New Brand</h1>
        
        <!-- Add Brand Form -->
        <form action="addBrand.php" method="POST" enctype="multipart/form-data">
            <label for="brand_name">Brand Name:</label>
            <input type="text" id="brand_name" name="brand_name" required>

            <label for="brand_logo">Brand Logo:</label>
            <input type="file" id="brand_logo" name="brand_logo">

            <button type="submit">Add Brand</button>
        </form>

        <!-- Button to go back to the editBrand.php page -->
        <a href="./editBrand.php">
            <button type="button">Back to Brand List</button>
        </a>
    </div>
</body>
</html>
