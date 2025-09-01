<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Bright Future Academy</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
  <style>
     body {
      margin: 0;
      font-family: "Times New Roman", Times, serif;
      background-image: url('https://images.squarespace-cdn.com/content/v1/619541f73704307b87772a18/c9a4a04a-b367-4e4a-9481-f2f6570da369/lukas-blazek-GnvurwJsKaY-unsplash.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      display: flex;
      height: 100%;
     
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
      align-items: center;
    }

    .main h1 {
      margin-bottom: 10px;
      font-weight: 600;
      font-size: 40px;
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
      width: 400px;
      height:180px;
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
      font-size: 30px;
      font-weight: 600;
      margin-bottom: 8px;
      color: #3a3e40;
    }

        .card p {
      font-size: 15px;
      opacity: 0.9;
      color: #1e0466
    }

    h3{
      font-size: 30px;

    }

    .courses { background: linear-gradient(to right,#fff,#d2c3fa); }
    .manage { background: linear-gradient(to right,#fff,#d2c3fa);}
    .enroll { background: linear-gradient(to right,#fff,#d2c3fa);}
    .massege { background: linear-gradient(to right,#fff,#d2c3fa); }
    .payment { background: linear-gradient(to right,#fff,#d2c3fa);}
    .student { background: linear-gradient(to right,#fff,#d2c3fa);}
    

  </style>
</head>
<body>



<div class="main">
  <h1>BRIGHT  FUTURE  ACADEMY</h1>
   <h3>Admin Panel</h3>
 <br>
 
  <div class="grid">
    <a href="courses.php" class="card courses">
      <h3>Courses</h3>
      <p>View all available courses</p>
    </a>
    <a href="manage_courses.php" class="card manage">
      <h3>Manage Courses</h3>
      <p>Add, edit, or remove courses</p>
    </a>
    <a href="enroll_students.php" class="card enroll">
      <h3>Enroll Students</h3>
      <p>Register students into the system</p>
    </a>
      <a href="massege.php" class="card massege">
      <h3>Message</h3>
      <p>Give messages to students</p>
    </a>
    <a href="payment_summary.php" class="card payment">
      <h3>Payment Summary</h3>
      <p>Review all student payment records</p>
    </a>
        <a href="view_students.php" class="card student">
      <h3>View Students</h3>
      <p>View all Registerd students</p>
    </a>
       <div class="logout">
       <a href="logout.php">Log Out</a>
  </div>
  </div>
</div>
   

</body>
</html>