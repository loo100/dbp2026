<?php
require_once 'db_test.php';

// Pagination settings
$recordsPerPage = 7;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Fetch total record count
$totalRecords = $pdo->query("SELECT COUNT(*) FROM price")->fetchColumn();
$totalPages = ceil($totalRecords / $recordsPerPage);

// Fetch data for the current page
$stmt = $pdo->prepare("SELECT * FROM price LIMIT :offset, :recordsPerPage");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .pagination { margin-top: 20px; text-align: center; }
        .pagination a { margin: 0 5px; text-decoration: none; padding: 5px 10px; border: 1px solid #ddd; color: #007bff; }
        .pagination a.active { background-color: #007bff; color: white; }
        .pagination a:hover { background-color: #0056b3; color: white; }
    </style>
</head>
<body>
    <h1>Product List</h1>
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
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>">&laquo; Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
</body>
</html>
