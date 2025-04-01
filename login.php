<?php
require 'db.php';
require 'analytics_tracker.php';
require 'audit_logger.php';
track_user_analytics($conn, $_SESSION['user_id'] ?? null);
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, role FROM accounts WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $role);
        $stmt->fetch();

        $_SESSION['user_id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['role'] = $role;

        if ($role === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: about.php");
        }
        log_action($conn, $id, 'login', "User {$name} logged in");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Lifeline | Login</title>
</head>
<body class="bg-green-50 min-h-screen flex items-center justify-center">

  <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
    <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">Lifeline Login</h2>

    <?php if (isset($error)): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 rounded">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="login.php" class="space-y-4">
      <div>
        <label class="block text-sm text-gray-700 mb-1">Email</label>
        <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
      </div>

      <div>
        <label class="block text-sm text-gray-700 mb-1">Password</label>
        <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
      </div>

      <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold transition">
        Login
      </button>
    </form>

    <p class="text-sm text-center text-gray-600 mt-4">
      Don't have an account? <a href="register.php" class="text-green-600 hover:underline">Register here</a>
    </p>
  </div>

</body>
</html>
