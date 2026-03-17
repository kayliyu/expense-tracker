<?php include 'db.php'; ?>

<form method="POST" action="add.php">
    <input type="text" name="title" placeholder="Expense Name" required>
    <input type="text" name="category" placeholder="Category" required>
    <input type="number" step="0.01" name="amount" required>
    <input type="date" name="date" required>
    <textarea name="description"></textarea>
    <button type="submit">Add Expense</button>
</form>

<hr>

<h2>Expense List</h2>

<?php
$total = $conn->query("SELECT SUM(amount) as total FROM expenses")->fetch_assoc();
echo "<h3>Total Expenses: " . $total['total'] . "</h3>";
?>

<table border="1">
<tr>
    <th>Title</th>
    <th>Category</th>
    <th>Amount</th>
    <th>Date</th>
    <th>Actions</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM expenses");

while($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['title']}</td>
        <td>{$row['category']}</td>
        <td>{$row['amount']}</td>
        <td>{$row['date']}</td>
        <td>
            <a href='edit.php?id={$row['id']}'>Edit</a>
            <a href='delete.php?id={$row['id']}'>Delete</a>
        </td>
    </tr>";
}
?>
</table>

