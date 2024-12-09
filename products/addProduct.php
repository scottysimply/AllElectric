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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                
                // try uploading the image
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
    <div class="mt-5 container w-25">
        <h1 class="text-center">Add Product</h1>
        <form method="POST" enctype="multipart/form-data">
            <label class="form-label" for="brand">Brand</label><br/>
            <select name="brand" id="brand" class="w-100 mb-3">
                <?php
                    foreach ($brand_results as $brand) {
                        echo'<option value=' . $brand['brand_id'] . '>' . $brand['brand_name'] . '</option>';
                    }
                ?>
            </select><br/>
            <label class="form-label" for="product-type">Product Type</label><br/>
            <select name="productType" id="product-type" class="w-100 mb-3">
                <?php
                    foreach ($product_type_results as $product_type) {
                        echo'<option value=' . $product_type['product_type_id'] . '>' . $product_type['product_type_name'] . '</option>';
                    }
                ?>
            </select><br/>
            <label class="form-label" for="product-name">Product Name</label><br/>
            <input type="text" name="productName" id="product-name" class="w-100 mb-3"><br/>
            <label class="form-label" for="product-desc">Product Description</label><br/>
            <input type="text" name="productDesc" id="product-desc" class="w-100 mb-3"><br/>
            <label class="form-label" for="product-use">Product Usecase</label><br/>
            <select name="productUse" id="product-use" class="w-100 mb-3">
                <?php
                    foreach ($product_uses as $product_use) {
                        echo "<option value=$product_use>$product_use</option>";
                    }
                ?>
            </select><br/>
            <label class="form-label" for="product-image">Product Preview</label><br/>
            <input type="file" name="productImage" id="product-image" class="form-control"><br/>
            <input type="submit" value="Add Product">
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>