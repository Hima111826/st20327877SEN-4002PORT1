<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Enrollment Rules - Bright Future Academy</title>
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
      color: white;
      text-decoration: none;
      display: block;
      margin: 8px 0;
      padding: 10px;
      border-radius: 10px;
      transition: background 0.3s;
    }

    .sidebar a:hover {
      background: rgba(255, 255, 255, 0.2);
    }

    .logout {
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

    .main h1 {
      color: #333;
      font-size: 30px;
      margin-bottom: 10px;
    }

    .main h2 {
      font-size: 25px;
      margin-top: 30px;
      color: #5a4cdb;
    }

    .section {
      background: linear-gradient(to right,#d2c3fa,#fff);
      border-radius: 12px;
      padding: 25px 30px;
      box-shadow: 0 10px 12px rgba(0,0,0,0.05);
      margin-bottom: 25px;
      line-height: 1.7;
    }

    ul {
      padding-left: 20px;
       font-size: 20px;
    }

    p{
       font-size: 20px;
    }

    .section table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      
    }

    .section table th, .section table td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: center;
    }

    .section table th {
      background-color: #eef;
    }

    .highlight {
      background: #f0f8ff;
      border-left: 5px solid #6a5acd;
      padding: 10px 15px;
      margin-top: 15px;
      border-radius: 6px;
    }
  </style>
</head>
<body>


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


<div class="main">
  <h1>📜 Rules and Regulations for Course Enrollment</h1>

  <div class="section">
    <h2>🎓 Eligibility Criteria</h2>
    <p>All students must meet both academic and English proficiency requirements to be eligible for direct enrollment into academic courses. If not, they will be placed into the Foundation Course stream.</p>
  </div>

  <div class="section">
    <h2>✅ Academic Requirements</h2>
    <ul>
      <li>Must pass the A/L (Advanced Level) examination in either:
        <ul>
          <li>Science stream, or</li>
          <li>Mathematics stream</li>
        </ul>
      </li>
      <li>If you fail the A/L examination, you will be assigned to Foundation Courses.</li>
    </ul>
  </div>

  <div class="section">
    <h2>✅ English Language Requirements</h2>
    <ul>
      <li>Must obtain at least one of the following grades in O/L (Ordinary Level) English: <strong>A, B, or C</strong></li>
      <li>If your O/L English result is <strong>S</strong> (Simple pass) or <strong>Fail</strong>, you will be assigned to Foundation Courses.</li>
    </ul>
  </div>

  <div class="section">
    <h2>📘 Course Placement</h2>
    <table>
      <tr>
        <th>Category</th>
        <th>Academic Result</th>
        <th>English Result</th>
        <th>Assigned Courses</th>
      </tr>
      <tr>
        <td>Main Academic Courses</td>
        <td>Pass in A/L (Sci/Math)</td>
        <td>A / B / C</td>
        <td>✅ Eligible for main courses</td>
      </tr>
      <tr>
        <td>Foundation Courses</td>
        <td>Fail in A/L</td>
        <td>Any</td>
        <td>❌ Must do foundation first</td>
      </tr>
      <tr>
        <td>Foundation Courses</td>
        <td>Pass in A/L</td>
        <td>S / Fail</td>
        <td>❌ Must do foundation first</td>
      </tr>
    </table>
  </div>

  <div class="section">
    <h2>📝 Additional Notes</h2>
    <div class="highlight">
      <ul>
        <li>All Foundation Course students must complete the foundation program before enrolling in main academic courses.</li>
        <li>Course fees and durations vary depending on course type. Please check the “View Courses” section in your dashboard.</li>
        <li>Final registration depends on availability and verification of documents.</li>
      </ul>
    </div>
  </div>

</div>

</body>
</html>