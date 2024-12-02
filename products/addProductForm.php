<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Input Form</title>
</head>
<body>
    <h1>Product Input Form</h1>
    <form action="process_product.php" method="POST" enctype="multipart/form-data">
        <!-- Product Name -->
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" maxlength="255" required>
        <br><br>

        <!-- Product Type -->
        <label for="prod_type_id">Product Type:</label>
        <select id="prod_type_id" name="prod_type_id" required>
            <option value="">Select Product Type</option>
            <option value="1">Type 1</option>
            <option value="2">Type 2</option>
            <option value="3">Type 3</option>
            <!-- Add more options dynamically -->
        </select>
        <br><br>

        <!-- Brand -->
        <label for="brand_id">Brand:</label>
        <select id="brand_id" name="brand_id" required>
            <option value="">Select Brand</option>
            <option value="1">Brand A</option>
            <option value="2">Brand B</option>
            <option value="3">Brand C</option>
            <!-- Add more options dynamically -->
        </select>
        <br><br>

        <!-- Product Description -->
        <label for="product_desc">Product Description:</label>
        <textarea id="product_desc" name="product_desc" maxlength="500" rows="4"></textarea>
        <br><br>

        <!-- Product Image -->
        <label for="product_img">Product Image:</label>
        <input type="file" id="product_img" name="product_img" accept="image/*">
        <br><br>

        <!-- Intended Use -->
        <label for="product_intended_use">Intended Use:</label>
        <input type="text" id="product_intended_use" name="product_intended_use" maxlength="255">
        <br><br>

        <!-- Submit Button -->
        <button type="submit">Submit</button>
    </form>
</body>
</html>
