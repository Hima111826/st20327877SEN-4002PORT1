<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$query = "
    SELECT p.*, s.name AS student_name, c.name AS course_name 
    FROM payments p
    JOIN students s ON p.student_id = s.id
    JOIN courses c ON p.course_id = c.id
    ORDER BY p.created_at DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Summary</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: "Times New Roman", Times, serif; 
      display: flex;
      min-height: 100vh;
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

    .sidebar h2 {
      font-size: 22px;
      margin-bottom: 15px;
    }

    .sidebar p {
      margin-bottom: 20px;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 10px 15px;
      margin-bottom: 10px;
      display: block;
      border-radius: 8px;
    }

    .sidebar a:hover {
      background: rgba(255,255,255,0.2);
    }

    .logout {
      margin-top: auto;
      border-top: 1px solid rgba(255,255,255,0.3);
      padding-top: 15px;
    }

    .main-panel {
      flex: 1;
      padding: 40px;
      background-image: url('https://images.unsplash.com/photo-1724405143873-cdaa5cac918e?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8bGlnaHQlMjBibHVlJTIwYmFja2dyb3VuZHxlbnwwfHwwfHx8MA%3D%3D');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
     
    }

    h2 {
      color: #fff; 
      margin-bottom: 25px;
    }

    h3 {
      color: #333; 
      font-size:25px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 15px 20px;
      text-align: left;
    }

    th {
      background: #f0f0f0;
      font-weight: 600;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .status-paid {
      color: green;
      font-weight: 600;
    }

    .status-unpaid {
      color: red;
      font-weight: 600;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <div>
    <h2>Admin Panel</h2>
      <br>
    <a href="admin_dashboard.php">📊 Dashboard</a>
    <a href="courses.php">📘 Courses</a>
    <a href="manage_courses.php">🛠 Manage Courses</a>
    <a href="enroll_students.php">🧑‍🎓 Enroll Students</a>
    <a href="message.php">📩 Message</a>
    <a href="payment_summary.php">💵 Payment Summary</a>
    <a href="view_students.php">👥 View Students</a>
  </div>
  <div class="logout">
    <a href="logout.php">🚪 Log Out</a>
  </div>
</div>


<div class="main-panel">
  <h3>📋 Student Payment Summary</h3>
  <table>
    <tr>
      <th>Student Name</th>
      <th>Course</th>
      <th>Amount</th>
      <th>Payment Method</th>
      <th>Status</th>
      <th>Date</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): 
      $status = $row['status'] ?? 'Not Paid';
      $class = strtolower($status) === 'paid' ? 'status-paid' : 'status-unpaid';
    ?>
    <tr>
      <td><?= htmlspecialchars($row['student_name']) ?></td>
      <td><?= htmlspecialchars($row['course_name']) ?></td>
      <td>Rs. <?= number_format($row['amount'], 2) ?></td>
      <td><?= htmlspecialchars($row['method']) ?></td>
      <td class="<?= $class ?>"><?= htmlspecialchars($status) ?></td>
      <td><?= htmlspecialchars($row['created_at']) ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

</body>
</html>