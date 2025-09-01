<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$search = isset($_GET['search']) ? trim($_GET['search']) : "";

$sql = "SELECT c.id, c.name, COUNT(r.id) AS student_count
        FROM courses c
        LEFT JOIN course_registrations r ON c.id = r.course_id";

if (!empty($search)) {
    $sql .= " WHERE c.id = ?";
}

$sql .= " GROUP BY c.id, c.name ORDER BY c.id ASC";
$stmt = $conn->prepare($sql);

if (!empty($search)) {
    $stmt->bind_param("i", $search);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Enroll Students - Admin</title>
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

    .sidebar a:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }

    .sidebar .logout {
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

    .search-box {
      margin-bottom: 20px;
    }

    .search-box input {
      padding: 10px;
      width: 250px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 14px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 0 8px rgba(0,0,0,0.05);
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 14px;
      border-bottom: 1px solid #eee;
      text-align: center;
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

<div class="dashboard-container">

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
    <a href="logout.php">🚪 Logout</a>
  </div>
</div>

  <div class="main-panel">
    <h3>📋 Enrolled Students</h3>

    <form class="search-box" method="GET">
      <input type="text" name="search" placeholder="Search by Course ID..." value="<?= htmlspecialchars($search) ?>">
    </form>

    <table>
      <tr>
        <th>Course ID</th>
        <th>Course Name</th>
        <th>Enrolled Students</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= $row['student_count'] ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
    

  </div>
</div>

</body>
</html>