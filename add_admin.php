<?php
include("db.php");

$username = "systemuser";
$plain_password = "admin123";
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);


$stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    echo "✅ Admin created successfully!";
} else {
    echo "❌ Error: " . $conn->error;
}
?>