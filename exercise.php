<?php
session_start();
require 'config.php';

$lesson_id = $_GET['lesson_id'] ?? 1;

$query = "SELECT * FROM exercises WHERE lesson_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $lesson_id);
$stmt->execute();
$result = $stmt->get_result();
$exercises = $result->fetch_all(MYSQLI_ASSOC);

$is_logged_in = isset($_SESSION['username']);
if (!$is_logged_in) {
  header("Location: login.php");
  exit;
}

$username = $is_logged_in ? $_SESSION['username'] : "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $lesson_id = $_POST['lesson_id'];
  $answers = $_POST['answers'];

  $score = 0;

  foreach ($answers as $exercise_id => $user_answer) {
    $stmt = $conn->prepare("SELECT correct_answer FROM exercises WHERE id = ?");
    $stmt->bind_param("i", $exercise_id);
    $stmt->execute();
    $stmt->bind_result($correct_answer);
    $stmt->fetch();

    if (strtolower($user_answer) == strtolower($correct_answer)) {
      $score++;
    }

    $stmt->close();
  }

  $score_result = "Your score: $score / " . count($answers);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Exercise</title>
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
    <h1>Exercise</h1>
    <form method="post">
      <input type="hidden" name="lesson_id" value="<?php echo $lesson_id; ?>">
      <?php foreach ($exercises as $exercise): ?>
        <div class="lesson-card">
          <p><?php echo htmlspecialchars($exercise['question']); ?></p>
          <input type="text" name="answers[<?php echo $exercise['id']; ?>]" required placeholder="Your answer">
        </div>
      <?php endforeach; ?>
      <?php if (!empty($score_result)) echo "<p style='color: green;'>$score_result</p>"; ?>
      <button type="submit" class="btn">Submit Answers</button>
    </form>
  </div>
</body>

</html>