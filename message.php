<?php  
session_start();  
require 'db.php';  
  
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'student'])) {  
    header("Location: login.php");  
    exit();  
}  
  
$role = $_SESSION['role'];  
$user_id = $role === 'admin' ? $_SESSION['admin_id'] : $_SESSION['user_id'];  
$name = $_SESSION['name'] ?? $_SESSION['username'];  
$success = "";  
  
 
if ($role === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'], $_POST['student_id'])) {  
    $content = trim($_POST['message']);  
    $student_id = intval($_POST['student_id']);  
    if (!empty($content)) {  
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, role, content) VALUES (?, ?, 'admin', ?)");  
        $stmt->bind_param("iis", $user_id, $student_id, $content);  
        $stmt->execute();  
        $success = "\u2705 Message sent to student!";  
    }  
}  
  

if ($role === 'student' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_message'])) {  
    $student_message = trim($_POST['student_message']);  
    if (!empty($student_message)) {  
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, role, content) VALUES (?, 0, 'student', ?)");  
        $stmt->bind_param("is", $user_id, $student_message);  
        $stmt->execute();  
        $success = "\u2705 Message sent to admin!";  
    }  
}  
  

if ($role === 'admin' && isset($_GET['delete'])) {  
    $msg_id = intval($_GET['delete']);  
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");  
    $stmt->bind_param("i", $msg_id);  
    $stmt->execute();  
    header("Location: message.php");  
    exit();  
}  

if ($role === 'admin') {  
    $stmt = $conn->prepare("SELECT m.*, s.name AS student_name FROM messages m LEFT JOIN students s ON m.sender_id = s.id WHERE m.role = 'student' ORDER BY m.created_at DESC");  
    $stmt->execute();  
    $admin_msgs = $stmt->get_result();  
} else {  
    $stmt = $conn->prepare("SELECT * FROM messages WHERE receiver_id = ? AND role = 'admin' ORDER BY created_at DESC");  
    $stmt->bind_param("i", $user_id);  
    $stmt->execute();  
    $student_msgs = $stmt->get_result();  
}  
?><!DOCTYPE html><html lang="en">  <head>  
  <meta charset="UTF-8">  
  <title>Message</title>  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">  
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
      margin: 10px 0;  
      padding: 10px 15px;  
      border-radius: 8px;  
    }  
    .sidebar a:hover {  
      background: rgba(255, 255, 255, 0.2);  
    }  
    h2 {
      color: #333;
      margin-bottom: 25px;
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
     h3 {  
      color: #fff;  
    }  
    .message-box {  
      background: white;  
      padding: 20px;  
      border-radius: 10px;  
      box-shadow: 0 0 10px rgba(0,0,0,0.1);  
      margin-bottom: 25px;  
      position: relative;  
    }  
    textarea, input[type="text"] {  
      width: 100%;  
      padding: 12px;  
      border-radius: 8px;  
      border: 1px solid #ccc;  
      margin-top: 10px;  
      font-family: 'Poppins', sans-serif;  
    }  
    button {  
      background: linear-gradient(to right, #6a11cb, #2575fc);  
      color: white;  
      padding: 10px 20px;  
      border: none;  
      border-radius: 8px;  
      margin-top: 10px;  
      cursor: pointer;  
      font-weight: bold;  
    }  
    .success {  
      background: #e6ffed;  
      color: #2d8a5e;  
      padding: 10px;  
      border-radius: 8px;  
      margin-bottom: 15px;  
    }  
    .delete-btn {  
      position: absolute;  
      top: 10px;  
      right: 10px;  
      background: crimson;  
      padding: 5px 10px;  
      border-radius: 6px;  
      font-size: 12px;  
    }  
    .delete-btn:hover {  
      background: darkred;  
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
      <a href="enrollment.php">📄 Enrollment</a>
      <a href="register_course.php">📝 Course Registration</a>
      <a href="payment.php">💳 Student Payment</a>
        <a href="message.php">📩 Message</a>  
      <?php endif; ?>  
    </div>  
<div class="logout">
    <a href="logout.php">🚪 Log Out</a>
  </div> 
  </div>  <div class="main-panel">  
    <h2>📩 Message Center</h2>  
    <?php if ($success): ?><div class="success"> <?= $success ?> </div><?php endif; ?><?php if ($role === 'admin'): ?>  
  <form method="POST">  
    <input type="text" name="student_id" placeholder="Enter Student ID" required>  
    <textarea name="message" placeholder="Type message to student..." required></textarea>  
    <button type="submit">Send</button>  
  </form>  
  
  <h2>💬 Student Messages</h2>  
  <?php while ($row = $admin_msgs->fetch_assoc()): ?>  
    <div class="message-box">  
      <strong>From:</strong> <?= htmlspecialchars($row['student_name'] ?? 'Unknown') ?><br>  
      <strong>Message:</strong> <?= htmlspecialchars($row['content']) ?><br>  
      <small>Sent: <?= $row['created_at'] ?></small>  
      <a href="?delete=<?= $row['id'] ?>" class="delete-btn">Delete</a>  
    </div>  
  <?php endwhile; ?>  
<?php else: ?>  
  <form method="POST">  
    <textarea name="student_message" placeholder="Type message to admin..." required></textarea>  
    <button type="submit">Send</button>  
  </form>  
  
  <h2>💬 Messages from Admin</h2>  
  <?php while ($row = $student_msgs->fetch_assoc()): ?>  
    <div class="message-box">  
      <strong>Message:</strong> <?= htmlspecialchars($row['content']) ?><br>  
      <small>Sent: <?= $row['created_at'] ?></small>  
    </div>  
  <?php endwhile; ?>  
<?php endif; ?>    </div>  
</div>  
</body>  
</html>