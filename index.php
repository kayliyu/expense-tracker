<?php 
include 'db.php'; 

// Define your categories here
$categories = ['Food', 'Transport', 'Rent', 'Utilities', 'Entertainment', 'Shopping', 'Health', 'Other'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h2>💰 Add New Expense</h2>
        <form method="POST" action="add.php">
            <input type="text" name="title" placeholder="Expense Name" required>
            
            <select name="category" required>
                <option value="" disabled selected>Select Category</option>
                <?php foreach($categories as $cat): ?>
                    <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
                <?php endforeach; ?>
            </select>

            <input type="number" step="0.01" name="amount" placeholder="0.00" required>
            <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
            <textarea name="description" placeholder="Optional description..."></textarea>
            <button type="submit">Add Expense</button>
        </form>

        <hr>

        <div class="header-flex">
            <h2>Expense List</h2>
            <?php
            $total_query = $conn->query("SELECT SUM(amount) as total FROM expenses");
            $total_data = $total_query->fetch_assoc();
            $display_total = number_format($total_data['total'] ?? 0, 2);
            echo "<h3>Total: <span class='total-amount'>$" . $display_total . "</span></h3>";
            ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM expenses ORDER BY date DESC");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td><strong>" . htmlspecialchars($row['title']) . "</strong></td>
                        <td><span class='badge'>" . htmlspecialchars($row['category']) . "</span></td>
                        <td>$" . number_format($row['amount'], 2) . "</td>
                        <td>" . date("M d, Y", strtotime($row['date'])) . "</td>
                        <td style='text-align: center;'>
                            <a href='edit.php?id={$row['id']}' class='btn-edit'>Edit</a>
                            <a href='delete.php?id={$row['id']}' class='btn-delete' onclick=\"return confirm('Are you sure?')\">Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>