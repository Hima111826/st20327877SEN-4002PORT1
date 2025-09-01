<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['user_id'];
$name = $_SESSION['name'];
$success = "";
$error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $status = "Paid";

    if ($course_id && $amount && $payment_method) {
        
        $stmt = $conn->prepare("SELECT fee FROM courses WHERE id = ?");
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $course = $result->fetch_assoc();
        $stmt->close();

        if ($course) {
            $actual_fee = $course['fee'];

            if (floatval($amount) != floatval($actual_fee)) {
                $error = "❌ Entered amount must match course fee (Rs. " . number_format($actual_fee, 2) . ")";
            } else {
               
                $insert = $conn->prepare("INSERT INTO payments (student_id, course_id, amount, method, status) VALUES (?, ?, ?, ?, ?)");
                $insert->bind_param("iisss", $student_id, $course_id, $amount, $payment_method, $status);
                if ($insert->execute()) {
                    $success = "✅ Payment submitted successfully!";
                } else {
                    $error = "❌ Failed to submit payment.";
                }
            }
        } else {
            $error = "❌ Course not found.";
        }
    } else {
        $error = "❌ All fields are required.";
    }
}


$courses = [];
$course_result = $conn->query("SELECT id, name FROM courses");
while ($row = $course_result->fetch_assoc()) {
    $courses[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Payment</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
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
      background: rgba(255,255,255,0.2);
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
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }

    .form-container {
      
      background: white;
      padding: 30px;
      border-radius: 12px;
      width: 100%;
      max-width: 600px;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
      
    }

    .form-container h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: 500;
    }

    input, select {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 10px;
      margin-top: 6px;
      background: #f0f0f0;
    }

    .radio-group {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 10px;
    }

    .card-fields {
      margin-top: 15px;
      display: none;
       
    }

    .form-container button {
      margin-top: 25px;
      width: 100%;
      padding: 12px;
      background: linear-gradient(to right, #6a11cb, #2575fc);
      border: none;
      color: white;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
    }

    .form-container button:hover {
      background: #5a00c7;
    }

    .success { color: green; text-align: center; }
    .error { color: red; text-align: center; }
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
  <div class="form-container">
    <h2>💳 Make a Payment</h2>

    <?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
    <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>

    <form method="POST">
      <label>Select Course:</label>
      <select name="course_id" required>
        <option value="">-- Select Course --</option>
        <?php foreach ($courses as $course): ?>
          <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['name']) ?></option>
        <?php endforeach; ?>
      </select>

      <label>Amount (Rs.):</label>
      <input type="number" name="amount" step="0.01" required>

      <label>Payment Method:</label>
      <div class="radio-group">
        <label><input type="radio" name="payment_method" value="PayPal" required> PayPal</label>
        <label><input type="radio" name="payment_method" value="Card" required onclick="toggleCard(true)"> Credit / Debit Card</label>
        <label><input type="radio" name="payment_method" value="Bank Transfer" required onclick="toggleCard(false)"> Bank Transfer</label>
      </div>

      <div class="card-fields" id="card-fields">
        <label>Card Number:</label>
        <input type="text" placeholder="1234 5678 9012 3456">
        <label>Name on Card:</label>
        <input type="text" placeholder="John Doe">
        <label>Expiry Date:</label>
        <input type="text" placeholder="MM/YY">
        <label>CVV:</label>
        <input type="password" placeholder="123">
      </div>

      <button type="submit">Confirm Payment</button>
    </form>
  </div>
</div>

<script>
  function toggleCard(show) {
    document.getElementById("card-fields").style.display = show ? "block" : "none";
  }
</script>

</body>
</html>