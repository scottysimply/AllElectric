<?php
    include_once 'productDb.php';
    $product_type_query = "SELECT * FROM product_type";
    $brand_query = "SELECT * FROM brands";
    $product_type_results = $db->query($product_type_query)->fetchAll(PDO::FETCH_ASSOC);
    $brand_reults = $db->query($brand_query)->fetchAll();
    $product_uses = ['Commercial', 'Residential'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Product</title>
</head>
<body>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "<h1>Product Successfully Added</h1>";
        }

    ?>
    <form method="POST" action=".">
        <select name="brand" id="brand">
            <?php
                foreach ($brand_reults as $brand) {
                    echo '<option value=' . $brand['brand_id'] . '></option>';
                }
            ?>
        </select>
        <select name="productType" id="product-type">
            <?php
                foreach ($product_type_reults as $product_type) {
                    echo '<option value=' . $product_type['product_type_id'] . '></option>';
                }
            ?>
        </select>
        <input type="text" name="productName" id="product-name">
        <input type="text" name="productDesc" id="product-desc">
        <select name="productUse" id="product-use">
            <?php
                foreach ($product_uses as $product_use) {
                    echo 'option value=' . $product_use . '></option>';
                }
            ?>
        </select>
        <input type="file" name="productImage" id="product-image">
    </form>
</body>
</html>