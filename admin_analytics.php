<?php
if (!isset($conn)) {
    header("Location: admin.php");
    exit();
}

$result = $conn->query("SELECT analytics.*, accounts.name FROM analytics 
                        LEFT JOIN accounts ON analytics.user_id = accounts.id 
                        ORDER BY accessed_at DESC");


$search = $_GET['search'] ?? '';
$os_filter = $_GET['os'] ?? '';
$browser_filter = $_GET['browser'] ?? '';
$device_filter = $_GET['device'] ?? '';

$where = [];
$params = [];
$types = '';

if ($search !== '') {
    $where[] = "(accounts.name LIKE ? OR analytics.ip_address LIKE ? OR analytics.location LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= 'sss';
}
if ($os_filter !== '') {
    $where[] = "analytics.os = ?";
    $params[] = $os_filter;
    $types .= 's';
}
if ($browser_filter !== '') {
    $where[] = "analytics.browser = ?";
    $params[] = $browser_filter;
    $types .= 's';
}
if ($device_filter !== '') {
    $where[] = "analytics.device_type = ?";
    $params[] = $device_filter;
    $types .= 's';
}

$query = "SELECT analytics.*, accounts.name FROM analytics 
          LEFT JOIN accounts ON analytics.user_id = accounts.id";

if ($where) {
    $query .= " WHERE " . implode(' AND ', $where);
}

$query .= " ORDER BY accessed_at DESC";

$stmt = $conn->prepare($query);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();


?>

<h2 class="text-2xl font-bold text-green-700 mb-6">User Analytics</h2>


<form method="GET" action="admin.php" class="grid md:grid-cols-4 gap-4 mb-6">
<input type="hidden" name="page" value="analytics">

<input type="text" name="search" placeholder="Search name, IP, location..." value="<?= htmlspecialchars($search) ?>"
        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400">

<select name="os" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400">
    <option value="">All OS</option>
    <option value="Windows 10" <?= $os_filter === 'Windows 10' ? 'selected' : '' ?>>Windows 10</option>
    <option value="Android" <?= $os_filter === 'Android' ? 'selected' : '' ?>>Android</option>
    <option value="iOS" <?= $os_filter === 'iOS' ? 'selected' : '' ?>>iOS</option>
    <option value="macOS" <?= $os_filter === 'macOS' ? 'selected' : '' ?>>macOS</option>
    <option value="Linux" <?= $os_filter === 'Linux' ? 'selected' : '' ?>>Linux</option>
</select>

<select name="browser" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400">
    <option value="">All Browsers</option>
    <option value="Chrome" <?= $browser_filter === 'Chrome' ? 'selected' : '' ?>>Chrome</option>
    <option value="Firefox" <?= $browser_filter === 'Firefox' ? 'selected' : '' ?>>Firefox</option>
    <option value="Safari" <?= $browser_filter === 'Safari' ? 'selected' : '' ?>>Safari</option>
    <option value="Edge" <?= $browser_filter === 'Edge' ? 'selected' : '' ?>>Edge</option>
</select>

<select name="device" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400">
    <option value="">All Devices</option>
    <option value="Desktop" <?= $device_filter === 'Desktop' ? 'selected' : '' ?>>Desktop</option>
    <option value="Mobile" <?= $device_filter === 'Mobile' ? 'selected' : '' ?>>Mobile</option>
</select>
</form>


<div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
  <table class="min-w-full table-auto text-sm text-left">
    <thead class="bg-green-100 text-green-900 font-semibold">
      <tr>
        <th class="px-4 py-3 border-b">User</th>
        <th class="px-4 py-3 border-b">IP Address</th>
        <th class="px-4 py-3 border-b">OS</th>
        <th class="px-4 py-3 border-b">Browser</th>
        <th class="px-4 py-3 border-b">Device</th>
        <th class="px-4 py-3 border-b">Location</th>
        <th class="px-4 py-3 border-b">Timestamp</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr class="hover:bg-green-50 transition">
          <td class="px-4 py-2 border-b"><?= htmlspecialchars($row['name'] ?? 'Guest') ?></td>
          <td class="px-4 py-2 border-b"><?= htmlspecialchars($row['ip_address']) ?></td>
          <td class="px-4 py-2 border-b"><?= htmlspecialchars($row['os']) ?></td>
          <td class="px-4 py-2 border-b"><?= htmlspecialchars($row['browser']) ?></td>
          <td class="px-4 py-2 border-b"><?= htmlspecialchars($row['device_type']) ?></td>
          <td class="px-4 py-2 border-b"><?= htmlspecialchars($row['location']) ?></td>
          <td class="px-4 py-2 border-b"><?= date('F j, Y g:i A', strtotime($row['accessed_at'])) ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
