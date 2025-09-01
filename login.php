<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
  background-image: url('https://www.master-meta4-0.eu/wp-content/uploads/bibliotheque-universite-bichro.webp');
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

    h2 {
      color: #7f5fcf;
      margin-bottom: 25px;
       font-family: "Times New Roman", Times, serif;
       
    }

    select, input[type="text"], input[type="password"] {
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

    .signup-link {
      margin-top: 15px;
    }

    .signup-link a {
      color: #7f5fcf;
      text-decoration: none;
    }
  </style>
</head>
<body>

<div class="container">
  <div style="font-size: 40px;">📝</div>
  <h2>Welcome to</h2>
  <h2>Bright Future Academy</h2>
  <form action="login_process.php" method="POST">
    <select name="role" required>
      <option value="" disabled selected>Select Role</option>
      <option value="student">Student</option>
      <option value="admin">Admin</option>
    </select>

    <input type="text" name="username_or_email" placeholder="Username or Email" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Login</button>
  </form>

  <div class="signup-link">
    Don’t have an account? <a href="register.php">Sign Up</a>
  </div>
</div>

</body>
</html>