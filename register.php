<?php
require 'db.php';
session_start();

$success = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO accounts (name, email, password, role) VALUES (?, ?, ?, 'user')");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        $success = "Registered successfully. You may now login.";
    } else {
        $error = "Error: " . $conn->error;
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
  <title>Lifeline | Register</title>
</head>
<body class="bg-green-50 min-h-screen flex items-center justify-center">

  <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
    <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">Create an Account</h2>

    <?php if ($success): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 rounded">
        <?= htmlspecialchars($success) ?> <a href="login.php" class="underline font-medium">Login</a>
      </div>
    <?php elseif ($error): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 rounded">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <div>
        <label class="block text-sm text-gray-700 mb-1">Name</label>
        <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
      </div>

      <div>
        <label class="block text-sm text-gray-700 mb-1">Email</label>
        <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
      </div>

      <div>
        <label class="block text-sm text-gray-700 mb-1">Password</label>
        <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
      </div>

      <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold transition">
        Register
      </button>
    </form>

    <p class="text-sm text-center text-gray-600 mt-4">
      Already have an account? <a href="login.php" class="text-green-600 hover:underline">Login here</a>
    </p>
  </div>

</body>
</html>
