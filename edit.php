<?php
include 'db.php';

// 1. Get the ID from the URL safely
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Define your categories (Must match index.php)
$categories = ['Food', 'Transport', 'Rent', 'Utilities', 'Entertainment', 'Shopping', 'Health', 'Other'];

// 2. Fetch the current data for this expense
$stmt = $conn->prepare("SELECT * FROM expenses WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Expense not found.");
}

// 3. Handle the Update Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title       = $_POST['title'];
    $category    = $_POST['category'];
    $amount      = $_POST['amount'];
    $date        = $_POST['date'];
    $description = $_POST['description'];

    $update_stmt = $conn->prepare("UPDATE expenses SET title=?, category=?, amount=?, date=?, description=? WHERE id=?");
    $update_stmt->bind_param("ssdssi", $title, $category, $amount, $date, $description, $id);

    if ($update_stmt->execute()) {
        header("Location: index.php?updated=1");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expense</title>
    <link rel="stylesheet" href="style-edit.css">
</head>
<body>

    <div class="container">
        <h2>✏️ Edit Expense</h2>
        
        <form method="POST" class="edit-form">
            <div class="form-group">
                <label>Expense Name</label>
                <input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>" required>
            </div>

            <div class="form-group">
                <label>Category</label>
                <select name="category" required>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?= $cat ?>" <?= ($row['category'] == $cat) ? 'selected' : '' ?>>
                            <?= $cat ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Amount</label>
                <input type="number" step="0.01" name="amount" value="<?= $row['amount'] ?>" required>
            </div>

            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" value="<?= $row['date'] ?>" required>
            </div>

            <div class="form-group full-width">
                <label>Description</label>
                <textarea name="description"><?= htmlspecialchars($row['description']) ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-update">Update Expense</button>
                <a href="index.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>