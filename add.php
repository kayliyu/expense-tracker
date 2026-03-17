<?php
include 'db.php';

$title = $_POST['title'];
$category = $_POST['category'];
$amount = $_POST['amount'];
$date = $_POST['date'];
$description = $_POST['description'];

$conn->query("INSERT INTO expenses (title, category, amount, date, description)
VALUES ('$title', '$category', '$amount', '$date', '$description')");

header("Location: index.php");
?>