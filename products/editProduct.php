<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Product</h1>
        <?php
        include 'productDb.php';

        if (isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
            $query = "SELECT * FROM products WHERE product_id = :product_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        ?>

        <form action="updateProduct.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="product_id" placeholder="<?php echo htmlspecialchars($product['product_id']); ?>">

            <div class="form-group">
                <label for="brand_id">Brand ID:</label>
                <input type="text" class="form-control" id="brand_id" name="brand_id" placeholder="<?php echo htmlspecialchars($product['brand_id']); ?>">
            </div>

            <div class="form-group">
                <label for="product_type_id">Product Type ID:</label>
                <input type="text" class="form-control" id="product_type_id" name="product_type_id" placeholder="<?php echo htmlspecialchars($product['product_type_id']); ?>">
            </div>

            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="<?php echo htmlspecialchars($product['product_name']); ?>">
            </div>

            <div class="form-group">
                <label for="product_desc">Product Description:</label>
                <textarea class="form-control" id="product_desc" name="product_desc" placeholder="<?php echo htmlspecialchars($product['product_desc']); ?>"></textarea>
            </div>

            <div class="form-group">
                <label for="product_intended_use">Product Intended Use:</label>
                <textarea class="form-control" id="product_intended_use" name="product_intended_use" placeholder="<?php echo htmlspecialchars($product['product_intended_use']); ?>"></textarea>
            </div>

            <div class="form-group">
                <label for="product_image">Product Image URL:</label>
                <input type="file" class="form-control-file" id="product_image" name="product_image">
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>