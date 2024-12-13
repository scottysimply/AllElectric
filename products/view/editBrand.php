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

// Handle form submission for editing brand
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_brand_id'])) {
    $brand_id = $_POST['edit_brand_id'];
    $brand_name = $_POST['brand_name'];
    $brand_logo = $_FILES['brand_logo']['name'] ?? null;

    // Handle file upload (optional)
    if ($brand_logo) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['brand_logo']['name']);
        move_uploaded_file($_FILES['brand_logo']['tmp_name'], $target_file);
    } else {
        $brand_logo = $_POST['existing_logo']; // Keep the existing logo if no new one is uploaded
    }

    // Update the brand information
    $sql = "UPDATE Brands SET brand_name = :brand_name, brand_logo = :brand_logo WHERE brand_id = :brand_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':brand_name' => $brand_name,
        ':brand_logo' => $brand_logo,
        ':brand_id' => $brand_id,
    ]);

    header('Location: editBrand.php'); // Redirect after update
    exit();
}

// Handle delete brand request
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $sql = "DELETE FROM Brands WHERE brand_id = :brand_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':brand_id' => $delete_id]);

    header('Location: editBrand.php'); // Redirect after deletion
    exit();
}

// Fetch all brands for listing, ordered alphabetically by brand_name
$sql = "SELECT * FROM Brands ORDER BY brand_name ASC";
$stmt = $pdo->query($sql);
$brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Brands</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h1>Manage Brands</h1>

        <!-- Brand List -->
        <h2>Existing Brands</h2>
        <ul>
            <?php foreach ($brands as $brand): ?>
                <li>
                    <?= htmlspecialchars($brand['brand_name']); ?> 
                    <a href="editBrand.php?edit=<?= $brand['brand_id']; ?>">Edit</a>
                    <a href="editBrand.php?delete=<?= $brand['brand_id']; ?>" onclick="return confirm('Are you sure you want to delete this brand?');">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Button to Add Brand -->
        <a href="./addBrand.php">
            <button>Add Brand</button>
        </a>

        <!-- Check if brand is being edited -->
        <?php if (isset($_GET['edit'])): ?>
            <?php 
                $edit_id = $_GET['edit'];
                $sql = "SELECT * FROM Brands WHERE brand_id = :brand_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':brand_id' => $edit_id]);
                $brand = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <?php if ($brand): ?>
                <h2>Edit Brand: <?= htmlspecialchars($brand['brand_name']); ?></h2>
                <!-- Edit Form -->
                <form action="./editBrand.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="edit_brand_id" value="<?= $brand['brand_id']; ?>">

                    <label for="brand_name">Brand Name:</label>
                    <input type="text" id="brand_name" name="brand_name" value="<?= htmlspecialchars($brand['brand_name']); ?>" required>

                    <label for="brand_logo">Brand Logo:</label>
                    <input type="file" id="brand_logo" name="brand_logo">
                    <input type="hidden" name="existing_logo" value="<?= htmlspecialchars($brand['brand_logo']); ?>">

                    <?php if ($brand['brand_logo']): ?>
                        <p>Current Logo: <?= htmlspecialchars($brand['brand_logo']); ?></p>
                    <?php endif; ?>

                    <button type="submit">Update Brand</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
