<?php

if (!isset($conn)) {
    header("Location: admin.php");
    exit();
}

$jobs = $conn->query("SELECT * FROM job_offers ORDER BY created_at DESC");

if (isset($_GET['delete_job'])) {
    $id = $_GET['delete_job'];
    $conn->query("DELETE FROM job_offers WHERE id=$id");
    log_action($conn, $_SESSION['user_id'], 'delete_job', "Deleted job ID #{$id}");
    header("Location: admin.php?page=jobs");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_job'])) {
    $id = $_POST['job_id'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $salary = $_POST['salary'];

    $stmt = $conn->prepare("UPDATE job_offers SET title=?, description=?, salary=? WHERE id=?");
    $stmt->bind_param("ssdi", $title, $desc, $salary, $id);
    $stmt->execute();
    log_action($conn, $_SESSION['user_id'], 'edit_job', "Edited job ID #{$id} - {$title}");
    header("Location: admin.php?page=jobs");
    exit();
}
?>

<h2 class="text-2xl font-bold text-green-700 mb-6">Manage Job Offers</h2>

<div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
  <table class="min-w-full table-auto text-sm text-left">
    <thead class="bg-green-100 text-green-900 font-semibold">
      <tr>
        <th class="px-4 py-3 border-b">Title</th>
        <th class="px-4 py-3 border-b">Description</th>
        <th class="px-4 py-3 border-b">Salary</th>
        <th class="px-4 py-3 border-b">Created At</th>
        <th class="px-4 py-3 border-b">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($job = $jobs->fetch_assoc()): ?>
        <tr class="hover:bg-green-50 transition">
          <td class="px-4 py-2 border-b"><?= htmlspecialchars($job['title']) ?></td>
          <td class="px-4 py-2 border-b"><?= htmlspecialchars($job['description']) ?></td>
          <td class="px-4 py-2 border-b text-green-700 font-medium">₱<?= number_format($job['salary'], 2) ?></td>
          <td class="px-4 py-2 border-b"><?= date('F j, Y', strtotime($job['created_at'])) ?></td>
          <td class="px-4 py-2 border-b">
            <button onclick="openEditModal(<?= $job['id'] ?>, '<?= htmlspecialchars(addslashes($job['title'])) ?>', '<?= htmlspecialchars(addslashes($job['description'])) ?>', <?= $job['salary'] ?>)" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600 transition">Edit</button>
            <a href="admin.php?page=jobs&delete_job=<?= $job['id'] ?>" onclick="return confirm('Are you sure?')" class="bg-red-500 text-white px-3 py-1 rounded text-sm ml-2 hover:bg-red-600 transition">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white p-6 rounded-lg w-full max-w-lg shadow-lg relative">
    <h3 class="text-xl font-bold text-green-700 mb-4">Edit Job Offer</h3>
    <form method="POST">
      <input type="hidden" name="job_id" id="editJobId">
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Title</label>
        <input type="text" name="title" id="editTitle" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-400">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Description</label>
        <textarea name="description" id="editDesc" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Salary</label>
        <input type="number" name="salary" id="editSalary" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-400">
      </div>
      <div class="flex justify-end gap-3">
        <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
        <button type="submit" name="edit_job" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
function openEditModal(id, title, desc, salary) {
  document.getElementById('editJobId').value = id;
  document.getElementById('editTitle').value = title;
  document.getElementById('editDesc').value = desc;
  document.getElementById('editSalary').value = salary;
  document.getElementById('editModal').classList.remove('hidden');
}
function closeEditModal() {
  document.getElementById('editModal').classList.add('hidden');
}
</script>
