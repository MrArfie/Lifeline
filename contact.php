<?php
require 'auth.php';
require 'db.php';

$name = $_SESSION['name'];
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_name = $_POST['name'];
    $user_email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user_name, $user_email, $message);

    if ($stmt->execute()) {
        $success = true;
    } else {
        $error = $conn->error;
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
  <title>Lifeline | Contact</title>
</head>
<body class="bg-green-50 text-gray-800">

  <?php include 'navbar.php'; ?>

  <section class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
      <div>
        <h1 class="text-4xl font-bold mb-4 text-green-700">Get in Touch</h1>
        <p class="text-gray-700 text-lg">
          Whether you're an individual looking for work or a barangay official posting opportunities — we're here to help. Reach out and let’s connect.
        </p>
        <ul class="mt-6 space-y-2 text-sm text-gray-600">
          <li><strong>📍 Address:</strong> San Fernando, Pampanga, Philippines</li>
          <li><strong>📧 Email:</strong> support@lifelineph.org</li>
          <li><strong>📞 Phone:</strong> +63 912 345 6789</li>
        </ul>
        <div class="mt-6 flex space-x-4">
          <a href="#" target="_blank"><img src="https://img.icons8.com/ios-filled/30/4caf50/facebook--v1.png" alt="Facebook"/></a>
          <a href="#" target="_blank"><img src="https://img.icons8.com/ios-filled/30/4caf50/twitter--v1.png" alt="Twitter"/></a>
          <a href="#" target="_blank"><img src="https://img.icons8.com/ios-filled/30/4caf50/instagram-new--v1.png" alt="Instagram"/></a>
          <a href="#" target="_blank"><img src="https://img.icons8.com/ios-filled/30/4caf50/linkedin.png" alt="LinkedIn"/></a>
        </div>
      </div>
      <div>
        <img src="https://dm0qx8t0i9gc9.cloudfront.net/thumbnails/video/r9E0QYuleiv25jmq9/videoblocks-the-five-happy-people-stand-on-the-background-of-the-city-slow-motion_rifckuzfob_thumbnail-1080_14.png"
             alt="Contact Us" class="w-full rounded-lg shadow-lg">
      </div>
    </div>
  </section>

  <section class="max-w-3xl mx-auto bg-white mt-12 p-8 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-green-700">Send us a message</h2>

    <?php if (isset($success) && $success): ?>
      <div class="mb-4 p-3 rounded bg-green-100 text-green-700 border border-green-300">
        Message sent successfully!
      </div>
    <?php elseif (isset($error)): ?>
      <div class="mb-4 p-3 rounded bg-red-100 text-red-700 border border-red-300">
        Error: <?= $error ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="contact.php" class="space-y-5">
      <div>
        <label class="block text-gray-700 font-medium mb-1">Name</label>
        <input type="text" name="name" required value="<?= htmlspecialchars($name) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
      </div>
      <div>
        <label class="block text-gray-700 font-medium mb-1">Email</label>
        <input type="email" name="email" required value="<?= htmlspecialchars($email) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
      </div>
      <div>
        <label class="block text-gray-700 font-medium mb-1">Message</label>
        <textarea name="message" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
      </div>
      <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
        Send Message
      </button>
    </form>
  </section>

  <?php include 'footer.php'; ?>

</body>
</html>
