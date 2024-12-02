<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Input Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Brand Input Form</h1>
        <form action="process_brand.php" method="POST" enctype="multipart/form-data">
            <!-- Brand Name -->
            <label for="brand_name">Brand Name:</label>
            <input type="text" id="brand_name" name="brand_name" maxlength="255" required>

            <!-- Brand Logo -->
            <label for="brand_logo">Brand Logo:</label>
            <input type="file" id="brand_logo" name="brand_logo" accept="image/*">

            <!-- Submit Button -->
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
