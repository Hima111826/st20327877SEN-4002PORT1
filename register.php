<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Registration</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <style>
   body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
  background-image: url('https://woorise.com/wp-content/uploads/2021/03/Online-event-registration.png');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

    .container {
      background: #fff;
      padding: 40px;
      width: 100%;
      max-width: 400px;
      border-radius: 30px;
      box-shadow: 0 0 55px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

  

    h1 {
      color: #7f5fcf;
      margin-bottom: 5px;
      font-family: "Times New Roman", Times, serif;
    }

    h2 {
      color:black;
      font-weight: normal;
      margin-bottom: 25px;
      font-family: "Times New Roman", Times, serif;
    }

    input[type="text"], input[type="email"], input[type="password"], input[type="tel"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      background: #f0f0f0;
      border-radius: 10px;
      outline: none;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #7f5fcf;
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 10px;
      cursor: pointer;
    }

    button:hover {
      background-color: #6c49b8;
    }

    .login-link {
      text-align: center;
      margin-top: 15px;
    }

    .login-link a {
      color: #7f5fcf;
      text-decoration: none;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="register-container">
  
  <div class="left-panel">
    <div style="font-size: 60px;">📝</div>

  <h1>Bright Future Academy</h1>
  <h2>Student Registration</h2>
  <form action="register_process.php" method="POST">
    <input type="text" name="name" placeholder="Full Name" required />
    <input type="email" name="email" placeholder="Email Address" required />
    <input type="password" name="password" placeholder="Password" required />
    <input type="tel" name="phone" placeholder="Phone Number" required />
    <button type="submit">Create Account</button>
  </form>
  <div class="login-link">
    Already have an account? <a href="login.php">Login Now</a>
  </div>
</div>

</body>
</html>