<?php
    include_once 'productDb.php';
    $product_type_results = $db->query($product_type_query)->fetchAll(PDO::FETCH_ASSOC);
    $brand_reults = $db->query($brand_query)->fetchAll();
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
                echo '<option value='$brand[""]'></option>';
                }
            ?>
        </select>
        <select name="productType" id="product-type">

        </select>
        <input type="text" name="productName" id="product-name">
        <input type="text" name="productDesc" id="product-desc">
        <select name="productUse" id="product-use">
            
        </select>
        <input type="file" name="productImage" id="product-image">
    </form>
</body>
</html>