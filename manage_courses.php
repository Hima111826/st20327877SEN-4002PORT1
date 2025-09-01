<?php
include("db.php");
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_course'])) {
    $name = $_POST['name'];
    $fee = $_POST['fee'];
    $duration = $_POST['duration'];
    $type = $_POST['type'];

    
    $full_name = $type . '|' . $name;

    $stmt = $conn->prepare("INSERT INTO courses (name, fee, duration) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $full_name, $fee, $duration);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_courses.php");
    exit();
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_courses.php");
    exit();
}


$result = $conn->query("SELECT * FROM courses ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Courses - Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: "Times New Roman", Times, serif; 
      margin: 0;
      padding: 0;
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

    .sidebar a:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }

    .sidebar .logout {
      margin-top: auto;
      border-top: 1px solid rgba(255,255,255,0.3);
      padding-top: 15px;
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
      margin-top: 0;
      color: #fff; 
    }

   h3 {
      color: #333; 
      font-size:25px;
    }

    form {
      margin-bottom: 30px;
    }

    input, select {
      padding: 10px;
      margin: 8px 10px 8px 0;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    button {
      padding: 10px 20px;
      background: #764ba2;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
    }

    th, td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
    }

    a.delete {
      color: red;
      text-decoration: none;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
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
    <a href="logout.php">🚪 Logout</a>
  </div>
</div>


<div class="main">
  <div class="header">
    <h3>📘 Add New Course</h3>
    
  </div>
  <form method="POST">
    <input type="text" name="name" placeholder="Course Name" required>
    <input type="text" name="fee" placeholder="Fee" required>
    <input type="text" name="duration" placeholder="Duration" required>
    <select name="type" required>
      <option value="main">Main</option>
      <option value="foundation">Foundation</option>
    </select>
    <button type="submit" name="add_course">Add</button>
  </form>

  <h3>Course List</h3>
  <table>
    <tr>
      <th>ID</th>
      <th>Course Name</th>
      <th>Type</th>
      <th>Fee</th>
      <th>Duration</th>
      <th>Action</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): 
      $parts = explode('|', $row['name']);
      $type = ucfirst($parts[0]);
      $name = $parts[1];
    ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($name) ?></td>
      <td><?= htmlspecialchars($type) ?></td>
      <td><?= htmlspecialchars($row['fee']) ?></td>
      <td><?= htmlspecialchars($row['duration']) ?></td>
      <td><a class="delete" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a></td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

</body>
</html>