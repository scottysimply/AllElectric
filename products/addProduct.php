<?php
    include_once 'productDb.php';
    $product_type_query = "SELECT * FROM product_type";
    $brand_query = "SELECT * FROM brands";
    $product_type_results = $pdo->query($product_type_query)->fetchAll(PDO::FETCH_ASSOC);
    $brand_results = $pdo->query($brand_query)->fetchAll();
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
            echo $message;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // Show error if the dated image exists on the server
                $uploaded_img = $_FILES['productImage'];
                $output_image_name = pathinfo($uploaded_img['name'], PATHINFO_FILENAME) . date("mdY-His") . ".png";
                if (file_exists("./images/" . $output_image_name)) {
                    showErrorBanner("The file already exists on the web server!");
                    return;
                }
                // This abomination uploads the image
                if (!imagepng(imagecreatefromstring(file_get_contents($uploaded_img['tmp_name'])), './images/' . $output_image_name)) {
                    showErrorBanner("The file could not be uploaded");
                    return; 
                }
                
                $unprepared_query = "INSERT INTO products (brand_id, product_type_id, product_name, product_desc, product_intended_use, product_image)VALUES (:brand_id, :product_type_id, :product_name, :product_desc, :product_intended_use, :img_url)";
                $prepared_statement = $pdo->prepare($unprepared_query);
                $prepared_statement->execute([':brand_id' => $_POST['brand'], ':product_type_id' => $_POST['productType'], ':product_name' => $_POST['productName'], ':product_desc' => $_POST['productType'], ':product_intended_use' => $_POST['productUse'], ':img_url' => "./images/$output_image_name"]);
        
                // if control got to here, then it executed successfully. unset post values
                unset($_POST['brand']);
                unset($_POST['productType']);
                unset($_POST['productName']);
                unset($_POST['productDesc']);
                unset($_POST['productUse']);
                unset($_FILES['productImage']);
                showErrorBanner("Product successfully added!");
            }
            catch (Exception $ex) {
                // NEXT TIME: Add warning banner on error
                showErrorBanner($ex->getMessage());
                return;
            }
        }

    ?>
    <form method="POST" enctype="multipart/form-data">

        <select name="brand" id="brand">
            <?php
                foreach ($brand_results as $brand) {
                    echo'<option value=' . $brand['brand_id'] . '>' . $brand['brand_name'] . '</option>';
                }
            ?>
        </select>
        <select name="productType" id="product-type">
            <?php
                foreach ($product_type_results as $product_type) {
                    echo'<option value=' . $product_type['product_type_id'] . '>' . $product_type['product_type_name'] . '</option>';
                }
            ?>
        </select>
        <input type="text" name="productName" id="product-name">
        <input type="text" name="productDesc" id="product-desc">
        <select name="productUse" id="product-use">
            <?php
                foreach ($product_uses as $product_use) {
                    echo "<option value=$product_use>$product_use</option>";
                }
            ?>
        </select>
        <input type="file" name="productImage" id="product-image">
        <input type="submit" value="Add Product">
    </form>
</body>
</html>