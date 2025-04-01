<?php
require 'auth.php';
require 'db.php';

$search = $_GET['search'] ?? '';
$stmt = $conn->prepare("SELECT * FROM job_offers WHERE title LIKE ? OR description LIKE ? ORDER BY created_at DESC");
$searchParam = "%$search%";
$stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Lifeline | Job Offers</title>
</head>
<body class="bg-green-50 text-gray-800">

  <?php include 'navbar.php'; ?>

  <section class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
      <div>
        <h1 class="text-4xl font-bold text-green-700 mb-4">Discover Opportunities</h1>
        <p class="text-lg text-gray-700 leading-relaxed">
          Lifeline connects individuals to local job opportunities offered by barangays and supporting organizations. Browse listings and apply easily!
        </p>
      </div>
      <div>
        <img src="https://www.tarkett-group.com/app/uploads/2021/12/15164042/people-patchwork-1920x1080-1.jpg"
             alt="Job Opportunities" class="w-full rounded-lg shadow-md">
      </div>
    </div>
  </section>

  <div class="max-w-4xl mx-auto px-4 py-6">
    <form method="GET" class="flex items-center gap-3">
      <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search jobs..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">Search</button>
    </form>
  </div>

  <div class="max-w-7xl mx-auto px-4 pb-16">
    <?php if ($result->num_rows === 0): ?>
      <p class="text-center text-gray-500 text-lg mt-8">No job offers found.</p>
    <?php else: ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition flex flex-col justify-between">
            <div>
              <h2 class="text-xl font-semibold text-green-700"><?= htmlspecialchars($row['title']) ?></h2>
              <p class="text-sm text-gray-600 mt-2"><?= htmlspecialchars($row['description']) ?></p>
              <p class="text-green-600 font-bold text-md mt-4">₱<?= number_format($row['salary'], 2) ?></p>
              <p class="text-xs text-gray-400 mt-1">Posted on <?= date('F j, Y', strtotime($row['created_at'])) ?></p>
            </div>
            <a href="contact.php" class="mt-5 inline-block w-full bg-green-600 text-white text-center py-2 rounded-lg text-sm hover:bg-green-700 transition">
              Apply Now
            </a>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>

  <?php include 'footer.php'; ?>

</body>
</html>
