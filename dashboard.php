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
  <title>Student Dashboard - Bright Future Academy</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: "Times New Roman", Times, serif;
      background-image: url('https://www.master-meta4-0.eu/wp-content/uploads/bibliotheque-universite-bichro.webp');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      display: flex;
      height:100%;
    }




.logout a {
  display: block;
  background-color:rgb(24, 11, 73);
  text-align: center;
  color: white;
  padding:20px 10px;
  border-radius: 50px;
  text-decoration: none;
  font-weight: bold;
  transition: background 0.3s ease;
}

.logout a:hover {
  background-color:rgb(61, 69, 223);
}

  
    .main {
      flex: 1;
      padding: 40px 50px;
      display: flex;
      flex-direction: column;
      

    }

    .main h1 {
      text-align:center;
      margin-bottom: 10px;
      font-weight: 600;
      font-size: 35px;
      color: black;
    }

    .main h2 {
      text-align:center;
      margin-bottom: 30px;
      font-weight: 400;
      font-size: 23px;
      color: black;
    }

    .grid {
      flex: 1;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-template-rows: repeat(3, 1fr);
      gap: 65px;
    }

    .card {
      padding: 25px;
      border-radius: 20px;
      box-shadow: 0 25px 35px rgba(0, 0, 0, 0.77);
      transition: 0.3s ease;
      text-align: center;
      text-decoration: none;
      display: flex;
      flex-direction: column;
      justify-content: center;
    
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.12);
    }

    .card h3 {
      font-size: 45px;
      font-weight: 600;
      margin-bottom: 8px;
      color: #3a3e40;
    }

    .card p {
      font-size: 18px;
      opacity: 0.9;
      color: #1e0466;
    }

    .courses { background: linear-gradient(to right,#3db8f5,#fff); }
    .payment { background: linear-gradient(to right,#fff,#3db8f5); }
    .profile { background: linear-gradient(to right,#fff,#3db8f5); }
    .enrollment { background: linear-gradient(to right,#3db8f5,#fff); }
    .register { background: linear-gradient(to right,#3db8f5,#fff); }
    .message { background: linear-gradient(to right,#fff,#3db8f5);  }
  </style>
</head>
<body>




<div class="main">
  <h1>BRIGHT FUTURE ACADEMY</h1>
  <h2>Welcome, <strong><?php echo htmlspecialchars($name); ?></strong> 👋</h2>
  <div class="grid">
    <a href="courses.php" class="card courses">
      <h3>Courses</h3>
      <p>View your available course list</p>
    </a>
    <a href="payment.php" class="card payment">
      <h3>Payment</h3>
      <p>Check your payment history</p>
    </a>
       <a href="profile.php" class="card profile">
      <h3>profile</h3>
      <p>Your personal details and payment receipt</p>
    </a>
    <a href="enrollment.php" class="card enrollment">
      <h3>Enrollment</h3>
      <p>Review enrollment rules & apply</p>
    </a>
       <a href="register_course.php" class="card register">
      <h3>Registration</h3>
      <p>Course Registration</p>
    </a>
    <a href="message.php" class="card message">
      <h3>Message</h3>
      <p>Read alerts or contact admin</p>
    </a>
      <div class="logout">
       <a href="logout.php">Log Out</a>
  </div>
  </div>
</div>

</body>
</html>