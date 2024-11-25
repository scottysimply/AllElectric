<?php
    $product_query = "";
    $product_type_query = "";
    $brand_query = "";

    $product_results = $db->query($product_query)->fetchAll();
    $product_type_results = $db->query($product_type_query)->fetchAll();
    $brand_reults = $db->query($brand_query)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
</head>
<body>
    <!--Show products as table-->
    <!--Use a form with button to allow POSTing to edit or delete a product-->
</body>
</html>