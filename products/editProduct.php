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
        $product_type_query = "SELECT * FROM product_type";
        $brand_query = "SELECT * FROM brands";
        $product_type_results = $pdo->query($product_type_query)->fetchAll(PDO::FETCH_ASSOC);
        $brand_results = $pdo->query($brand_query)->fetchAll();
        $product_uses = ['Commercial', 'Residential'];
        if (isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
            $query = "SELECT * FROM products WHERE product_id = :product_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        if (isset($_GET['brand_id'])) {
            $brand_id = $_GET['brand_id'];
            $query = "SELECT * FROM brands WHERE brand_id = :brand_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);
            $stmt->execute();
            $brand = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        if (isset($_GET['product_type_id'])) {
            $product_type_id = $_GET['product_type_id'];
            $query = "SELECT * FROM product_type WHERE product_type_id = :product_type_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':product_type_id', $product_type_id, PDO::PARAM_INT);
            $stmt->execute();
            $product_type = $stmt->fetch(PDO::FETCH_ASSOC);
        }  
        $product_uses = ['Commercial', 'Residential'];
        ?>

        <form action="updateProduct.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">

            <div class="form-group">
                <label for="brand">Brand:</label>
                <select name="brand" id="brand" class="form-control">
                    <?php
                        foreach ($brand_results as $brand) {
                            echo '<option value="' . $brand['brand_id'] . '">' . $brand['brand_name'] . '</option>';
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="product-type">Product Type:</label>
                <select name="productType" id="product-type" class="form-control">
                    <?php
                        foreach ($product_type_results as $product_type) {
                            echo '<option value="' . $product_type['product_type_id'] . '">' . $product_type['product_type_name'] . '</option>';
                        }
                    ?>
                </select>
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
                <label for="product_use">Product Use:</label>
                <select name="product_use" id="product_use" class="form-control">
                    <?php
                        foreach ($product_uses as $product_use) {
                            echo '<option value="' . $product_use . '">' . $product_use . '</option>';
                        }
                    ?>
                </select>
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