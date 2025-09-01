<?php
session_start();
require 'db.php';
$name=$_SESSION['name'];

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['user_id'];


$reg_stmt = $conn->prepare("SELECT cr.*, c.name AS course_name
                            FROM course_registrations cr
                            JOIN courses c ON cr.course_id = c.id
                            WHERE cr.student_id = ?
                            ORDER BY cr.created_at DESC LIMIT 1");
$reg_stmt->bind_param("i", $student_id);
$reg_stmt->execute();
$registration = $reg_stmt->get_result()->fetch_assoc();
$reg_stmt->close();


$courses_stmt = $conn->prepare("SELECT cr.course_id, c.name AS course_name
                                FROM course_registrations cr
                                JOIN courses c ON cr.course_id = c.id
                                WHERE cr.student_id = ?");
$courses_stmt->bind_param("i", $student_id);
$courses_stmt->execute();
$courses_result = $courses_stmt->get_result();
$courses_stmt->close();


$payments_stmt = $conn->prepare("SELECT p.*, c.name AS course_name
                                FROM payments p
                                JOIN courses c ON p.course_id = c.id
                                WHERE p.student_id = ?");
$payments_stmt->bind_param("i", $student_id);
$payments_stmt->execute();
$payments_result = $payments_stmt->get_result();
$payments_stmt->close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Profile</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      margin: 0;
      font-family: "Times New Roman", Times, serif; 
      
    }
    .dashboard-container {
      display: flex;
      height: 100vh;
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
      font-size: 25px;
      margin-bottom: 8px;
      color:#fff;
    }

    .sidebar p {
      margin-bottom: 30px;
      font-size: 18px;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 10px 15px;
      display: block;
      border-radius: 10px;
      margin-bottom: 10px;
    }
    .sidebar a:hover {
      background: rgba(255, 255, 255, 0.2);
    }
    .logout {
      margin-top: auto;
      border-top: 1px solid rgba(255,255,255,0.3);
      padding-top: 20px;
    }
    .main-panel {
      background-image: url('https://images.unsplash.com/photo-1724405143873-cdaa5cac918e?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8bGlnaHQlMjBibHVlJTIwYmFja2dyb3VuZHxlbnwwfHwwfHx8MA%3D%3D');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      flex: 1;
      padding: 40px;
      height: 800px;
   
    }
    .card-grid {
      display: flex;
      gap: 20px;
      margin-bottom: 30px;
      
    }
    .card-option {
      flex: 1;
      background: linear-gradient(to right, #667eea, #764ba2);
      color: white;
      padding: 25px;
      text-align: center;
      font-size: 16px;
      border-radius: 12px;
      cursor: pointer;
      transition: transform 0.3s;
    }
    .card-option:hover {
      transform: translateY(-4px);
    }
    .section-box {
      display: none;
      background: white;
      padding: 50px;
      border-radius: 20px;
      box-shadow: 0 100px 20px rgba(0,0,0,0.05);
    }
    .active {
      display: block;
    }
    .label { font-weight: bold; }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 12px;
    }
    th {
      background-color: #f2f2f2;
    }
    .paid {
      color: green;
      font-weight: bold;
    }
    .not-paid {
      color: red;
      font-weight: bold;
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
    <h2>👤 Student Profile</h2>

    <div class="card-grid">
      <div class="card-option" onclick="showSection('personal')">👤 Personal Details</div>
      <div class="card-option" onclick="showSection('payment')">💳 Payment Receipts</div>
    </div>

   
    <div id="personal" class="section-box active">
      <h3>Personal Details</h3>
      <?php if ($registration): ?>
        <p><span class="label">Full Name:</span> <?= htmlspecialchars($registration['full_name']) ?></p>
        <p><span class="label">Student ID:</span> <?= $student_id ?></p>
        <p><span class="label">Email:</span> <?= htmlspecialchars($registration['email']) ?></p>
        <p><span class="label">Phone:</span> <?= htmlspecialchars($registration['phone']) ?></p>
        <p><span class="label">Birthday:</span> <?= htmlspecialchars($registration['birthday']) ?></p>
        <p><span class="label">Age:</span> <?= htmlspecialchars($registration['age']) ?></p>
        <p><span class="label">Gender:</span> <?= htmlspecialchars($registration['gender']) ?></p>
        <p><span class="label">Address:</span> <?= htmlspecialchars($registration['address']) ?></p>
        
      <?php else: ?>
        <p>No registration data found.</p>
      <?php endif; ?>
    </div>

    
    <div id="payment" class="section-box">
      <h3>Payment Receipts</h3>
      <table>
        <tr>
          <th>Course Name</th>
          <th>Amount</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
        <?php
        if ($payments_result->num_rows > 0):
            while ($p = $payments_result->fetch_assoc()):
              $status = strtolower(trim($p['status']));
              $class = ($status === 'paid') ? 'paid' : 'not-paid';
        ?>
          <tr>
            <td><?= htmlspecialchars($p['course_name']) ?></td>
            <td>Rs. <?= number_format($p['amount'], 2) ?></td>
            <td class="<?= $class ?>"><?= ucfirst($status) ?></td>
            <td><?= date("Y-m-d", strtotime($p['created_at'])) ?></td>
          </tr>
        <?php endwhile; else: ?>
          <tr><td colspan="4">No payments found.</td></tr>
        <?php endif; ?>
      </table>
    </div>

  </div>
</div>

<script>
function showSection(section) {
  document.getElementById('personal').classList.remove('active');
  document.getElementById('payment').classList.remove('active');
  document.getElementById(section).classList.add('active');
}
</script>

</body>
</html>