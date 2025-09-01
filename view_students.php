<?php
session_start();
require 'db.php';


if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


$sql = "SELECT id, course_id, full_name, email, phone, birthday, address FROM course_registrations ORDER BY id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registered Students - Admin</title>
  <style>
    body {
      margin: 0;
      font-family: "Times New Roman", Times, serif; 
      display: flex;
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
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      margin: 10px 0;
      padding: 10px 15px;
      border-radius: 8px;
    }
    
    .sidebar .logout {
      margin-top: auto;
      border-top: 1px solid rgba(255,255,255,0.3);
      padding-top: 15px;
    }

    .sidebar a:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }

    .main {
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
      border-radius: 10px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
      overflow: hidden;
    }

    th, td {
      padding: 14px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #f3f4f6;
    }

    tr:hover {
      background-color: #f9f9f9;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <div>
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php">📊 Dashboard</a>
    <a href="courses.php">📘 Courses</a>
    <a href="manage_courses.php">🛠 Manage Courses</a>
    <a href="enroll_students.php">🧑‍🎓 Enroll Students</a>
    
    <a href="message.php">📩 Message</a>
    <a href="payment_summary.php">💵 Payment Summary</a>
     <a href="view_students.php">👥 View Students</a>
  </div>
  <div class="logout">
    <a href="logout.php">🚪 Logout</a>
  </div>
</div>

<div class="main">
  <h3>👥 Registered Students</h3>

  <table>
    <tr>
      <th>ID</th>
      <th>Full Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Date of Birth</th>
      <th>Address</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['full_name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= htmlspecialchars($row['birthday']) ?></td>
          <td><?= htmlspecialchars($row['address']) ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="6">No students registered.</td></tr>
    <?php endif; ?>
  </table>
</div>

</body>
</html>