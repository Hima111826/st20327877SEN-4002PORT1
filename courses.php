<?php
session_start();
include("db.php");


if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}


$name = $_SESSION['name'] ?? $_SESSION['username'];
$role = $_SESSION['role'] ?? 'student';


$sql = "SELECT * FROM courses";
$result = $conn->query($sql);

$main_courses = [];
$foundation_courses = [];

while ($row = $result->fetch_assoc()) {
    if (stripos($row['name'], 'foundation') !== false || stripos($row['id'], 'FND') !== false) {
        $foundation_courses[] = $row;
    } else {
        $main_courses[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Courses - Bright Future Academy</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
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
      font-size: 20px;
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 25px 20px;
    }
 .sidebar h2 {
      font-size: 25px;
      margin-bottom: 8px;
    }

    .sidebar p {
      margin-bottom: 30px;
      font-size: 18px;
    }

    .sidebar a {
      display: block;
      color: #fff;
      text-decoration: none;
      padding: 10px;
      margin: 6px 0;
      border-radius: 10px;
      transition: 0.3s;
    }

    .sidebar a:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }

    .logout {
      margin-top: 20px;
      border-top: 1px solid rgba(255,255,255,0.3);
      padding-top: 15px;
    }

    .main {
      background-image: url('https://images.unsplash.com/photo-1724405143873-cdaa5cac918e?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8bGlnaHQlMjBibHVlJTIwYmFja2dyb3VuZHxlbnwwfHwwfHx8MA%3D%3D');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      flex: 1;
      padding: 40px;
    }

    h1 {
      font-size: 28px;
      color: #333;
    }
     h3 {
      margin-top: 0;
      color: #fff;
    }

    .section {
      margin-top: 40px;
    }

    .section h2 {
      font-size: 22px;
      margin-bottom: 20px;
      color: #444;
    }

    .card-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 20px;
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
      transition: 0.3s;
      border-left: 6px solid #7f5fcf;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
    }

    .card h3 {
      margin: 0;
      font-size: 18px;
      color: #333;
    }

    .card p {
      margin: 8px 0;
      font-size: 14px;
      color: #666;
    }
  </style>
</head>
<body>


<div class="sidebar">
  <div>
    
    <?php if ($role === 'admin'): ?>
      <h3>Admin Panel</h3>
      <br>
      <a href="admin_dashboard.php">🏠 Dashboard</a>
      <a href="courses.php">📘 Courses</a>
      <a href="manage_courses.php">🛠 Manage Courses</a>
      <a href="enroll_students.php">🧑‍🎓 Enroll Students</a>
    <a href="message.php">📩 Message</a>
      <a href="payment_summary.php">💵 Payment Summary</a>
      <a href="view_students.php">👥 View Students</a>
    <?php else: ?>
       <h2>Bright Future Academy</h2>
      <p>Welcome, <strong><?php echo htmlspecialchars($name); ?></strong></p>
      <a href="dashboard.php">🏠 Dashboard</a>
      <a href="profile.php">👤 Student Profile</a>
      <a href="courses.php">📘 Courses</a>
      <a href="enrollment.php">📝 Enrollment</a>
      <a href="register_course.php">✅ Course Registration</a>
      <a href="payment.php">💳 Student Payment</a>
      <a href="message.php">📩 Message</a>
    <?php endif; ?>
  </div>
  <div class="logout">
    <a href="logout.php">🚪 Log Out</a>
  </div>
</div>

<div class="main">
  <h1>Course Catalog</h1>

  
  <div class="section">
    <h2>📚 Main Academic Courses</h2>
    <div class="card-container">
      <?php foreach ($main_courses as $course): ?>
        <div class="card">
          <h3><?php echo htmlspecialchars($course['name']); ?></h3>
          <p><strong>ID:</strong> <?php echo htmlspecialchars($course['id']); ?></p>
          <p><strong>Fee:</strong> Rs. <?php echo number_format($course['fee'], 2); ?></p>
          <p><strong>Duration:</strong> <?php echo htmlspecialchars($course['duration']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

 
  <div class="section">
    <h2>🔰 Foundation Courses</h2>
    <div class="card-container">
      <?php foreach ($foundation_courses as $course): ?>
        <div class="card">
          <h3><?php echo htmlspecialchars($course['name']); ?></h3>
          <p><strong>ID:</strong> <?php echo htmlspecialchars($course['id']); ?></p>
          <p><strong>Fee:</strong> Rs. <?php echo number_format($course['fee'], 2); ?></p>
          <p><strong>Duration:</strong> <?php echo htmlspecialchars($course['duration']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

</body>
</html>