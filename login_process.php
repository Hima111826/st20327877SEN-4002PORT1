<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $role = $_POST['role'];
    $input = trim($_POST['username_or_email']);
    $password = trim($_POST['password']);

    if ($role === "admin") {

        
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->bind_param("s", $input);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['username'] = $admin['username'];
                $_SESSION['role'] = 'admin';
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "<p style='color:red; text-align:center;'>❌ Incorrect password.</p>";
                echo "<p style='text-align:center;'><a href='login.php'>Try Again</a></p>";
            }
        } else {
            echo "<p style='color:red; text-align:center;'>❌ Admin not found.</p>";
            echo "<p style='text-align:center;'><a href='login.php'>Try Again</a></p>";
        }

    } elseif ($role === "student") {
        
        
        $stmt = $conn->prepare("SELECT * FROM students WHERE email = ?");
        $stmt->bind_param("s", $input);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $student = $result->fetch_assoc();

            if (password_verify($password, $student['password'])) {
                $_SESSION['user_id'] = $student['id'];
                $_SESSION['name'] = $student['name'];
                $_SESSION['role'] = 'student';
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<p style='color:red; text-align:center;'>❌ Incorrect password.</p>";
                echo "<p style='text-align:center;'><a href='login.php'>Try Again</a></p>";
            }
        } else {
            echo "<p style='color:red; text-align:center;'>❌ Student not found.</p>";
            echo "<p style='text-align:center;'><a href='login.php'>Try Again</a></p>";
        }

    } else {
        echo "<p style='color:red; text-align:center;'>❌ Please select a valid role.</p>";
        echo "<p style='text-align:center;'><a href='login.php'>Back</a></p>";
    }
}