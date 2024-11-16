<?php
session_start();
require 'config.php';

$is_logged_in = isset($_SESSION['username']);

if (!$is_logged_in) {
  header("Location: login.php");
  exit;
}

$username = $is_logged_in ? $_SESSION['username'] : "";

$query = "SELECT id, title, content FROM lessons";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  $lessons = $result->fetch_all(MYSQLI_ASSOC);
} else {
  $lessons = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>All Lessons</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <nav class="navbar">
    <div class="navbar-brand">Language Learning App</div>
    <div class="navbar-links">
      <span>Welcome, <?php echo htmlspecialchars($username); ?></span>
      <a href="logout.php" class="btn">Logout</a>
    </div>
  </nav>

  <div class="content">
    <h1>All Lessons</h1>
    <?php if (!empty($lessons)): ?>
      <?php foreach ($lessons as $lesson): ?>
        <div class="lesson-card">
          <h2><?php echo htmlspecialchars($lesson['title']); ?></h2>
          <p><?php echo nl2br(htmlspecialchars(substr($lesson['content'], 0, 100))) . '...'; ?></p>
          <a href="exercise.php?lesson_id=<?php echo $lesson['id']; ?>" class="btn">Start Exercise</a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No lessons available.</p>
    <?php endif; ?>
  </div>
</body>

</html>