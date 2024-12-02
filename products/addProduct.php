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
        function showErrorBanner(string $message) {
            // TODO: Show error message banner
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // Show error if the dated image exists on the server
                $uploaded_img = $_FILES['productImage'];
                $output_image_name = $uploaded_img['tmpname'] . date("mdY-His") . ".png";
                if (file_exists("./images/" . $output_image_name)) {
                    showErrorBanner("The file already exists on the web server!");
                    return;
                }
                // This abomination uploads the image
                imagepng(imagecreatefromstring(file_get_contents($uploaded_img['tmpname'])), "./images/" . $output_image_name);
                
                $unprepared_query = "INSERT INTO products VALUES = (:brand_id, :product_type_id, :product_name, :product_desc, :prod_intended_use, :img_url)";


            }
            catch (Exception $ex) {
                // NEXT TIME: Add warning banner on error
                showErrorBanner($ex->getMessage());
                return;
            }
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