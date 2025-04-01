<?php
require 'admin_auth.php';
require 'db.php';
require 'audit_logger.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'accounts';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard | Lifeline</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 text-gray-800">

  <!-- Header -->
  <header class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-green-700">LIFELINE Admin</h1>
    <div>
      <span class="mr-4 text-sm text-gray-700">
        Welcome, <strong><?= $_SESSION['name'] ?></strong> (<?= $_SESSION['role'] ?>)
      </span>
      <a href="logout.php" class="text-sm text-red-500 hover:underline">Logout</a>
    </div>
  </header>


  <div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-6 flex flex-wrap gap-4">
      <a href="admin.php?page=accounts" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Manage Accounts</a>
      <a href="admin.php?page=jobs" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Manage Job Offers</a>
      <a href="admin.php?page=contacts" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">View Contacts</a>
      <a href="admin.php?page=logs" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">View Logs</a>
      <a href="admin.php?page=analytics" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">View Analytics</a>
    </div>

    <div class="bg-white rounded-xl p-6 shadow">
      <?php
        if ($page === 'accounts') {
          include 'admin_accounts.php';
        } elseif ($page === 'jobs') {
          include 'admin_jobs.php';
        } elseif ($page === 'contacts') {
          include 'admin_contact.php';
        } elseif ($page === 'logs') {
          include 'admin_logs.php';
        } else if ($page === 'analytics') {
        include 'admin_analytics.php';
        } else {
          echo "<p class='text-gray-500'>Page not found.</p>";
        }
      ?>
    </div>
  </div>

</body>
</html>
