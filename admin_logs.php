<?php

if (!isset($conn)) {
    header("Location: admin.php");
    exit();
}

$search = $_GET['search'] ?? '';
$action_filter = $_GET['action'] ?? '';
$user_filter = $_GET['user_id'] ?? '';
$date_filter = $_GET['date'] ?? '';

$where = [];
$params = [];
$types = '';

if ($search !== '') {
    $where[] = "(details LIKE ? OR action LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= 'ss';
}
if ($action_filter !== '') {
    $where[] = "action = ?";
    $params[] = $action_filter;
    $types .= 's';
}
if ($user_filter !== '') {
    $where[] = "user_id = ?";
    $params[] = $user_filter;
    $types .= 'i';
}
if ($date_filter !== '') {
    $where[] = "DATE(timestamp) = ?";
    $params[] = $date_filter;
    $types .= 's';
}

$query = "SELECT audit_logs.*, accounts.name FROM audit_logs 
          LEFT JOIN accounts ON audit_logs.user_id = accounts.id";
if ($where) {
    $query .= " WHERE " . implode(' AND ', $where);
}
$query .= " ORDER BY timestamp DESC";

$stmt = $conn->prepare($query);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$users = $conn->query("SELECT id, name FROM accounts ORDER BY name ASC");
$actions = $conn->query("SELECT DISTINCT action FROM audit_logs");

?>

<h2 class="text-2xl font-bold text-green-700 mb-6">Audit Logs</h2>

<!-- Filters -->
<form method="GET" action="admin.php" class="grid md:grid-cols-4 gap-4 mb-6">
  <input type="hidden" name="page" value="logs">

  <input type="text" name="search" placeholder="Search details..." value="<?= htmlspecialchars($search) ?>"
         class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 w-full">

  <select name="action" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 w-full">
    <option value="">All Actions</option>
    <?php while ($a = $actions->fetch_assoc()): ?>
      <option value="<?= $a['action'] ?>" <?= $a['action'] === $action_filter ? 'selected' : '' ?>>
        <?= ucfirst($a['action']) ?>
      </option>
    <?php endwhile; ?>
  </select>

  <select name="user_id" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 w-full">
    <option value="">All Users</option>
    <?php while ($u = $users->fetch_assoc()): ?>
      <option value="<?= $u['id'] ?>" <?= $u['id'] == $user_filter ? 'selected' : '' ?>>
        <?= $u['name'] ?>
      </option>
    <?php endwhile; ?>
  </select>

  <input type="date" name="date" value="<?= htmlspecialchars($date_filter) ?>"
         class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 w-full">
</form>

<div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
  <table class="min-w-full table-auto text-sm text-left">
    <thead class="bg-green-100 text-green-900 font-semibold">
      <tr>
        <th class="px-4 py-3 border-b">User</th>
        <th class="px-4 py-3 border-b">Action</th>
        <th class="px-4 py-3 border-b">Details</th>
        <th class="px-4 py-3 border-b">Timestamp</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows === 0): ?>
        <tr>
          <td colspan="4" class="text-center py-6 text-gray-500">No logs found.</td>
        </tr>
      <?php else: ?>
        <?php while ($log = $result->fetch_assoc()): ?>
          <tr class="hover:bg-green-50 transition">
            <td class="px-4 py-2 border-b"><?= htmlspecialchars($log['name'] ?? 'Unknown') ?></td>
            <td class="px-4 py-2 border-b"><?= htmlspecialchars($log['action']) ?></td>
            <td class="px-4 py-2 border-b"><?= htmlspecialchars($log['details']) ?></td>
            <td class="px-4 py-2 border-b"><?= date('F j, Y g:i A', strtotime($log['timestamp'])) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>
