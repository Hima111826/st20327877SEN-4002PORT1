<?php
session_start();
require 'db.php';
$name=$_SESSION['name'];


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['user_id'];
$student_name = $_SESSION['name'] ?? 'Student';

$success = "";
$error = "";


$courses = [];
$result = $conn->query("SELECT id, name FROM courses");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $subject_taken = $_POST['subject_taken'];
    $level_result = $_POST['level_result'];
    $english_result = $_POST['english_result'];
    $course_id = $_POST['course_id'];

    $stmt = $conn->prepare("INSERT INTO course_registrations 
        (student_id, full_name, email, phone, birthday, age, gender, address, subject_taken, level_result, english_result, course_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("issssisssssi", 
        $student_id, $full_name, $email, $phone, $birthday, $age, 
        $gender, $address, $subject_taken, $level_result, $english_result, $course_id);

    if ($stmt->execute()) {
        $success = "✅ Course registration submitted successfully!";
    } else {
        $error = "❌ Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register Course</title>
  <link rel="stylesheet" href="style.css">
  <style>
  body {
      margin: 0;
      font-family: "Times New Roman", Times, serif; 
      display: flex; 
    }
    .dashboard-container {
      display: flex;
      width: 100%;
    }
      .sidebar {  
      width: 240px;  
      background-image: url('https://img.freepik.com/free-vector/abstract-background-gradient-colorful-design_677411-3431.jpg?semt=ais_hybrid&w=740&q=80');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      font-family: "Times New Roman", Times, serif;
      font-size: 20px;;  
      color: white;  
      padding: 25px 20px;  
      min-height: 100vh;  
      display: flex;  
      flex-direction: column;  
      justify-content: space-between;  
    } 
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      margin: 12px 0;
      padding: 10px 15px;
      border-radius: 8px;
    }
    .sidebar a:hover {
      background: rgba(255, 255, 255, 0.2);
    }
     .sidebar h2 {
      font-size: 25px;
      margin-bottom: 8px;
      color:#fff;
    }

    .sidebar p {
      margin-bottom: 30px;
      font-size: 18px;
    }
     .logout {
      margin-top: auto;
      border-top: 1px solid rgba(255,255,255,0.3);
      padding-top: 15px;
    }

    .main-panel {
      background-image: url('https://images.unsplash.com/photo-1724405143873-cdaa5cac918e?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8bGlnaHQlMjBibHVlJTIwYmFja2dyb3VuZHxlbnwwfHwwfHx8MA%3D%3D');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      flex: 1;
      padding: 40px;
    }
    .form-container {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    h2 {
      margin-top: 0;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: 500;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }
    button {
      margin-top: 20px;
      padding: 12px 20px;
      background: linear-gradient(to right, #6a11cb, #2575fc);
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
    }
    .success {
      color: green;
      font-weight: bold;
      margin-bottom: 15px;
    }
    .error {
      color: red;
      font-weight: bold;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<div class="dashboard-container">

  
  <div class="sidebar">
  <div>
    <h2>Bright Future Academy</h2>
    <p>Welcome, <strong><?php echo htmlspecialchars($name); ?></strong></p>
       <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 Student Profile</a>
    <a href="courses.php">📘 Courses</a>
    <a href="enrollment.php">📝 Enrollment</a>
    <a href="register_course.php">✅ Course Registration</a>
    <a href="payment.php">💳 Student Payment</a>
    <a href="message.php">📩 Message</a>
  </div>
  <div class="logout">
    <a href="logout.php">🚪 Log Out</a>
  </div>
</div>

  
  <div class="main-panel">
    <div class="form-container">
      <h2>📝 Course Registration</h2>

      <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
      <?php elseif ($error): ?>
        <div class="error"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST">
        <label>Full Name:</label>
        <input type="text" name="full_name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Phone Number:</label>
        <input type="text" name="phone" required>

        <label>Birthday:</label>
        <input type="date" name="birthday" required>

        <label>Age:</label>
        <input type="number" name="age" required>

        <label>Gender:</label>
        <select name="gender" required>
          <option value="">-- Select --</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>

        <label>Address:</label>
        <textarea name="address" required></textarea>

        <label>Subject Taken:</label>
        <div>
          <label><input type="radio" name="subject_taken" value="Science" required> Science</label>
          <label><input type="radio" name="subject_taken" value="Maths" required> Maths</label>
        </div>

        <label>A/Level Result:</label>
        <input type="text" name="level_result" required>

        <label>O/L English Result:</label>
        <input type="text" name="english_result" required>

        <label>Select Course:</label>
        <select name="course_id" required>
          <option value="">-- Choose Course --</option>
          <?php foreach ($courses as $course): ?>
            <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['name']) ?></option>
          <?php endforeach; ?>
        </select>

        <button type="submit">Submit</button>
      </form>
    </div>
  </div>

</div>

</body>
</html>