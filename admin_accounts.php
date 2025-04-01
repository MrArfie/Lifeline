<?php

if (!isset($conn)) {
    header("Location: admin.php");
    exit();
}

$result = $conn->query("SELECT id, name, email, role, created_at FROM accounts ORDER BY created_at DESC");
?>

<h2 class="text-2xl font-bold text-green-700 mb-6">User Accounts</h2>

<div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
  <table class="min-w-full table-auto text-sm text-left">
    <thead class="bg-green-100 text-green-900 font-semibold">
      <tr>
        <th class="px-4 py-3 border-b">ID</th>
        <th class="px-4 py-3 border-b">Name</th>
        <th class="px-4 py-3 border-b">Email</th>
        <th class="px-4 py-3 border-b">Password</th>
        <th class="px-4 py-3 border-b">Role</th>
        <th class="px-4 py-3 border-b">Created At</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr class="hover:bg-green-50 transition">
          <td class="px-4 py-2 border-b"><?= $row['id'] ?></td>
          <td class="px-4 py-2 border-b"><?= htmlspecialchars($row['name']) ?></td>
          <td class="px-4 py-2 border-b"><?= htmlspecialchars($row['email']) ?></td>
          <td class="px-4 py-2 border-b text-center text-gray-500 italic">Encrypted</td>
          <td class="px-4 py-2 border-b"><?= $row['role'] ?></td>
          <td class="px-4 py-2 border-b"><?= date('F j, Y', strtotime($row['created_at'])) ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
