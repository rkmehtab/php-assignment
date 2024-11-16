<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $email, $password);

  try {
    if ($stmt->execute()) {
      $message =  "Registration successful!";
    } else {
      $error = $stmt->error;
    }
  } catch (Exception $e) {
    $error = $e->getMessage();
  } finally {
    $stmt->close();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="auth-form-container">
    <div>

      <h2>Register</h2>
      <form action="register.php" method="post">
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <?php if (!empty($message)) echo "<p style='color: green;'>$message</p>"; ?>
        <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <button type="submit">Register</button>
      </form>
      <a href="login.php">Already have an account? Login here.</a>
    </div>
  </div>
</body>

</html>