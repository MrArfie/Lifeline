<?php

if (!isset($conn)) {
    header("Location: admin.php");
    exit();
}

$contacts = $conn->query("SELECT * FROM contact ORDER BY created_at DESC");

if (isset($_GET['delete_contact'])) {
    $id = $_GET['delete_contact'];
    $conn->query("DELETE FROM contact WHERE id=$id");
    log_action($conn, $_SESSION['user_id'], 'delete_contact', "Deleted contact ID #{$id}");
    header("Location: admin.php?page=contacts");
    exit();
}
?>

<h2 class="text-2xl font-bold text-green-700 mb-6">Contact Messages</h2>

<div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
  <table class="min-w-full table-auto text-sm text-left">
    <thead class="bg-green-100 text-green-900 font-semibold">
      <tr>
        <th class="px-4 py-3 border-b">Name</th>
        <th class="px-4 py-3 border-b">Email</th>
        <th class="px-4 py-3 border-b">Message</th>
        <th class="px-4 py-3 border-b">Created At</th>
        <th class="px-4 py-3 border-b">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($c = $contacts->fetch_assoc()): ?>
        <tr class="hover:bg-green-50 transition">
          <td class="px-4 py-2 border-b"><?= htmlspecialchars($c['name']) ?></td>
          <td class="px-4 py-2 border-b"><?= htmlspecialchars($c['email']) ?></td>
          <td class="px-4 py-2 border-b"><?= htmlspecialchars($c['message']) ?></td>
          <td class="px-4 py-2 border-b"><?= date('F j, Y', strtotime($c['created_at'])) ?></td>
          <td class="px-4 py-2 border-b">
            <a href="admin.php?page=contacts&delete_contact=<?= $c['id'] ?>"
               onclick="return confirm('Delete this message?')"
               class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">
               Delete
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
