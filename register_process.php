<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone    = $_POST['phone'];

    $check = $conn->prepare("SELECT * FROM students WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already registered'); window.location='register.php';</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO students (name, email, password, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $phone);
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Please login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Error occurred while registering.'); window.location='register.php';</script>";
        }
    }
}
?>