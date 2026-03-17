<?php
include 'db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM expenses WHERE id=$id");
$row = $result->fetch_assoc();
?>

<form method="POST">
    <input type="text" name="title" value="<?= $row['title'] ?>">
    <input type="text" name="category" value="<?= $row['category'] ?>">
    <input type="number" step="0.01" name="amount" value="<?= $row['amount'] ?>">
    <input type="date" name="date" value="<?= $row['date'] ?>">
    <textarea name="description"><?= $row['description'] ?></textarea>
    <button type="submit">Update</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn->query("UPDATE expenses SET 
        title='{$_POST['title']}',
        category='{$_POST['category']}',
        amount='{$_POST['amount']}',
        date='{$_POST['date']}',
        description='{$_POST['description']}'
        WHERE id=$id");

    header("Location: index.php");
}
?>