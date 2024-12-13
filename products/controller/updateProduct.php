<?php
// Include database connection
require_once '../model/productDb.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $updates = [];
    $params = [];

    //check each field and add it to the updates if it's provided
    if (!empty($_POST['brand'])) {
        $updates[] = "brand_id = ?";
        $params[] = $_POST['brand'];
    }

    if (!empty($_POST['productType'])) {
        $updates[] = "product_type_id = ?";
        $params[] = $_POST['productType'];
    }

    if (!empty($_POST['product_name'])) {
        $updates[] = "product_name = ?";
        $params[] = $_POST['product_name'];
    }

    if (!empty($_POST['product_desc'])) {
        $updates[] = "product_desc = ?";
        $params[] = $_POST['product_desc'];
    }

    if (!empty($_POST['product_use'])) {
        $updates[] = "product_intended_use = ?";
        $params[] = $_POST['product_use'];
    }

    //handle image upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $product_image_name = $_FILES["product_image"]["name"];
        $target_dir = "../uploaded_imagds/";
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        //validate image
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if ($check !== false) {
            if ($_FILES["product_image"]["size"] <= 5000000) {
                if (in_array($imageFileType, ["jpg", "jpeg", "png"])) {
                    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                        $updates[] = "product_image = ?";
                        $params[] = $target_file; // Save the file path
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                        exit;
                    }
                } else {
                    echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
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
    }

    //add productID param
    $params[] = $product_id;

    //build the query only if there are things to update
    if (!empty($updates)) {
        $query = "UPDATE products SET " . implode(', ', $updates) . " WHERE product_id = ?";
        $stmt = $pdo->prepare($query);

        //execute the statement with the parameters
        if ($stmt->execute($params)) {
            header('Location: ../view/editProduct.php'); //go back to edit product
            exit;
        } else {
            echo "Error updating product.";
        }
    } else {
        echo "No fields to update.";
    }
}
?>