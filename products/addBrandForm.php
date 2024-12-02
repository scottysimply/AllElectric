<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Input Form</title>
</head>
<body>
    <h1>Brand Input Form</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <!-- Brand Name -->
        <label for="brand_name">Brand Name:</label>
        <input type="text" id="brand_name" name="brand_name" maxlength="255" required>
        <br><br>

        <!-- Brand Logo -->
        <label for="brand_logo">Brand Logo:</label>
        <input type="file" id="brand_logo" name="brand_logo" accept="image/*">
        <br><br>

        <!-- Submit Button -->
        <button type="submit">Submit</button>
    </form>
</body>
</html>
