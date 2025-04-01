<?php
require 'auth.php';
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Lifeline | About</title>
</head>
<body class="bg-gray-50 text-gray-800">

  <?php include 'navbar.php'; ?>

  <section class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
      <div>
        <h1 class="text-4xl font-bold mb-4 text-green-700">About Lifeline Pampanga</h1>
        <p class="text-lg text-gray-700 leading-relaxed">
          Lifeline Pampanga is a simple, yet impactful application designed to help individuals and
          families in need by connecting them with job opportunities. Barangay officials can post job
          openings through the app, ensuring that opportunities reach those who need them most.
        </p>
        <p class="text-lg text-gray-700 mt-4 leading-relaxed">
          Private organizations interested in contributing can contact barangay officials to have
          their job listings posted, making it easier for people to find employment and uplift their
          livelihoods.
        </p>
      </div>
      <div>
        <img src="https://img-cdn.inc.com/image/upload/f_webp,q_auto,c_fit/images/panoramic/GettyImages-1374879082_530288_ktipyy.jpg"
             alt="Community Jobs" class="rounded-lg shadow-lg w-full">
      </div>
    </div>
  </section>

  <section class="bg-green-50 py-16">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
      <div>
        <h2 class="text-3xl font-bold text-green-700 mb-4">Our Vision & Mission</h2>
        <p class="text-gray-700 text-lg leading-relaxed">
          Our vision is to build a strong, inclusive, and empowered community where every person has access to dignified work and economic opportunity.
        </p>
        <p class="text-gray-700 text-lg leading-relaxed mt-4">
          Our mission is to bridge the gap between job providers and those seeking employment by leveraging the strength of local barangays and digital technology.
        </p>
      </div>
      <div>
        <img src="https://images.unsplash.com/photo-1556761175-129418cb2dfe?auto=format&fit=crop&w=870&q=80"
             alt="Vision and Mission" class="rounded-lg shadow-md w-full">
      </div>
    </div>
  </section>

  <section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">
      <h2 class="text-3xl font-bold text-center text-green-700 mb-12">How It Works</h2>
      <div class="grid md:grid-cols-3 gap-8 text-center">
        <div class="bg-green-100 p-6 rounded-xl shadow">
          <img src="https://img.icons8.com/color/64/create-new.png" class="mx-auto mb-4" />
          <h3 class="text-xl font-semibold mb-2 text-green-800">1. Job Posting</h3>
          <p class="text-gray-600">Barangay officials or verified orgs post job openings through the app.</p>
        </div>
        <div class="bg-green-100 p-6 rounded-xl shadow">
          <img src="https://img.icons8.com/color/64/handshake.png" class="mx-auto mb-4" />
          <h3 class="text-xl font-semibold mb-2 text-green-800">2. Community Access</h3>
          <p class="text-gray-600">Users browse open job listings and find those that match their skills.</p>
        </div>
        <div class="bg-green-100 p-6 rounded-xl shadow">
          <img src="https://img.icons8.com/color/64/send-letter.png" class="mx-auto mb-4" />
          <h3 class="text-xl font-semibold mb-2 text-green-800">3. Contact & Apply</h3>
          <p class="text-gray-600">Applicants send their inquiries directly to barangays through the contact page.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="py-16 bg-green-50">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
      <div>
        <img src="https://spark.school/wp-content/uploads/2022/08/teamwork-community-and-portrait-of-people-cleanin-2023-11-27-05-04-02-utc-scaled.webp"
             alt="Community Impact" class="rounded-lg shadow-md w-full">
      </div>
      <div>
        <h2 class="text-3xl font-bold text-green-700 mb-4">Making a Difference</h2>
        <p class="text-lg text-gray-700 leading-relaxed">
          Lifeline isn't just an app — it's a platform for change. We aim to reduce unemployment, promote local economic development, and empower individuals to support their families and communities through meaningful work.
        </p>
      </div>
    </div>
  </section>

  <section class="text-center py-16 bg-white">
    <h2 class="text-2xl font-semibold mb-3 text-gray-800">Want to post job opportunities?</h2>
    <p class="text-gray-600 mb-5">Reach out to your local barangay officials or <a href="contact.php" class="text-green-600 hover:underline">contact us</a>.</p>
    <a href="job_offers.php" class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">Browse Job Listings</a>
  </section>

  <?php include 'footer.php'; ?>

</body>
</html>
