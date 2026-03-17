<?php
include 'db.php';

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // 1. Collect and sanitize input
        $title       = $_POST['title'] ?? 'Untitled';
        $category    = $_POST['category'] ?? 'General';
        $amount      = $_POST['amount'] ?? 0;
        $date        = $_POST['date'] ?? date('Y-m-d');
        $description = $_POST['description'] ?? '';

        // 2. Prepare the SQL Statement
        // Count: 1.title, 2.category, 3.amount, 4.date, 5.description
        $sql = "INSERT INTO expenses (title, category, amount, date, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // 3. Bind the parameters
        // "ssds s" -> string, string, double, string, string (Total 5)
        $stmt->bind_param("ssdss", $title, $category, $amount, $date, $description);

        // 4. Execute
        $stmt->execute();

        // 5. Close and Redirect
        $stmt->close();
        $conn->close();
        header("Location: index.php?success=1");
        exit();

    } catch (Exception $e) {
        // If it fails, this will tell you WHY (e.g., "Unknown column 'description'")
        die("Database Error: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}
?>