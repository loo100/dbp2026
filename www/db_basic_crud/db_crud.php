<?php
// Database connection
// $host = 'localhost';
// $dbname = 'U1333000'; // Replace with your database name
// $username = 'root';
// $password = ''; // Replace with your database password if applicable

// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Database connection failed: " . $e->getMessage());
// }
require_once 'db_test.php';
// Handle Create
if (isset($_POST['create'])) {
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $specification = $_POST['specification'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $url = $_POST['url'];

    $stmt = $pdo->prepare("INSERT INTO price (category, brand, specification, price, date, url) VALUES (:category, :brand, :specification, :price, :date, :url)");
    $stmt->execute([
        'category' => $category,
        'brand' => $brand,
        'specification' => $specification,
        'price' => $price,
        'date' => $date,
        'url' => $url
    ]);
    echo "Product added successfully!";
}

// Handle Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $specification = $_POST['specification'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $url = $_POST['url'];

    $stmt = $pdo->prepare("UPDATE price SET category = :category, brand = :brand, specification = :specification, price = :price, date = :date, url = :url WHERE no = :id");
    $stmt->execute([
        'id' => $id,
        'category' => $category,
        'brand' => $brand,
        'specification' => $specification,
        'price' => $price,
        'date' => $date,
        'url' => $url
    ]);
    echo "Product updated successfully!";
}

// Handle Delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM price WHERE no = :id");
    $stmt->execute(['id' => $id]);
    echo "Product deleted successfully!";
}

// Fetch all products
$products = $pdo->query("SELECT * FROM price")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product CRUD</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        form { margin-top: 20px; }
        input, button { padding: 8px; margin: 5px; }
    </style>
</head>
<body>
    <h1>Product CRUD</h1>

    <!-- Create Product -->
    <form method="POST">
        <h2>Create Product</h2>
        <input type="text" name="category" placeholder="Category" required>
        <input type="text" name="brand" placeholder="Brand" required>
        <input type="text" name="specification" placeholder="Specification" required>
        <input type="number" name="price" placeholder="Price" required>
        <input type="date" name="date" required>
        <input type="url" name="url" placeholder="URL" required>
        <button type="submit" name="create">Add Product</button>
    </form>

    <!-- Product Table -->
    <h2>Product List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Specification</th>
                <th>Price</th>
                <th>Date</th>
                <th>URL</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['no']) ?></td>
                    <td><?= htmlspecialchars($product['category']) ?></td>
                    <td><?= htmlspecialchars($product['brand']) ?></td>
                    <td><?= htmlspecialchars($product['specification']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['date']) ?></td>
                    <td><a href="<?= htmlspecialchars($product['url']) ?>" target="_blank">Link</a></td>
                    <td>
                        <!-- Update Form -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $product['no'] ?>">
                            <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" required>
                            <input type="text" name="brand" value="<?= htmlspecialchars($product['brand']) ?>" required>
                            <input type="text" name="specification" value="<?= htmlspecialchars($product['specification']) ?>" required>
                            <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
                            <input type="date" name="date" value="<?= htmlspecialchars($product['date']) ?>" required>
                            <input type="url" name="url" value="<?= htmlspecialchars($product['url']) ?>" required>
                            <button type="submit" name="update">Update</button>
                        </form>

                        <!-- Delete Form -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $product['no'] ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
