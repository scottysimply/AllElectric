<?php
//include database connection
require_once 'productDb.php';

//check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $brand_id = $_POST['brand'];
    $product_type_id = $_POST['productType'];
    $product_name = $_POST['product_name'];
    $product_desc = $_POST['product_desc'];
    $product_use = $_POST['product_use'];
    
    
    // Handle file upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $product_image_name = $_FILES["product_image"]["name"];
        $target_dir = "./uploaded_images/";
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if ($check !== false) {
            // Check file size (5MB maximum)
            if ($_FILES["product_image"]["size"] <= 5000000) {
                // Allow certain file formats
                if (in_array($imageFileType, ["jpg", "jpeg", "png"])) {
                    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                        $product_image = $target_file;
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                        exit;
                    }
                } else {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    exit;
                }
            } else {
                echo "Sorry, your file is too large.";
                exit;
            }
        } else {
            echo "File is not an image.";
            exit;
        }
    } else {
        $product_image = null; // No new image uploaded
    }

    $query = "UPDATE products SET brand_id = ?, product_type_id = ?, product_name = ?, product_desc = ?, product_intended_use = ?, product_image = ? WHERE product_id = ?";
    
    
    $stmt = $pdo->prepare($query);
    
    
    $stmt->bindValue(1, $brand_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $product_type_id, PDO::PARAM_INT);
    $stmt->bindValue(3, $product_name, PDO::PARAM_STR);
    $stmt->bindValue(4, $product_desc, PDO::PARAM_STR);
    $stmt->bindValue(5, $product_use, PDO::PARAM_STR);
    $stmt->bindValue(6, $product_image_name, PDO::PARAM_STR);
    $stmt->bindValue(7, $product_id, PDO::PARAM_INT);
    
    

    // Execute the statement
    if ($stmt->execute()) {
        echo "Product updated successfully.";
    } else {
        echo "Error updating product:";
    }
}
?>
