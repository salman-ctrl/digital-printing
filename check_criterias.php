<?php
include 'vendor/autoload.php';
$pdo = new PDO('mysql:host=127.0.0.1;dbname=digital-printing', 'root', '');
$stmt = $pdo->query('SELECT id, name, type FROM criterias');
while($row = $stmt->fetch()) {
    echo "Criteria ID {$row['id']} ({$row['name']}): Type={$row['type']}\n";
}
?>