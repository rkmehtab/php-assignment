<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
      $_SESSION['user_id'] = $user_id;
      $_SESSION['username'] = $username;
      header("Location: index.php");
      exit;
    } else {
      $error = "Invalid password.";
    }
  } else {
    $error = "No account found with that username.";
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="auth-form-container">
    <div class="auth-form">
      <h2>Login</h2>
      <form action="login.php" method="post">
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <button type="submit">Login</button>
      </form>
      <a href="register.php">Don't have an account? Register here.</a>
    </div>
  </div>
</body>

</html>