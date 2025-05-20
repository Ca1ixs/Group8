<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch saved trips for logged in user by user_id
$stmt = $conn->prepare("SELECT id, tripName, destination, start_date, end_date FROM trips WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$savedTrips = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Travel Destinations</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>

<?php include 'header.php'; ?>

<main>
  <section class="destinations" aria-label="Travel Destinations">
    <article>
      <img src="images/mountain_biking.jpg" alt="Mountain Biking Adventure" />
      <h2><a href="Detail_mtnBike.htm">Mountain Biking</a></h2>
      <p>Ride through scenic trails and rugged landscapes. Perfect for thrill-seekers and nature lovers.</p>
    </article>
    <article>
      <img src="images/beach_relax.jpg" alt="Relaxing Beach" />
      <h2>Beach Relaxation</h2>
      <p>Sunbathe, swim, and unwind at pristine beach resorts. Ideal for a calm, rejuvenating escape.</p>
    </article>
    <article>
      <img src="images/cultural_tour.jpg" alt="Cultural Tour" />
      <h2>Cultural Tours</h2>
      <p>Explore history, art, and cuisine in top global destinations with expert guides.</p>
    </article>
  </section>

  <section class="saved-trips" aria-live="polite">
    <h2>Your Saved Trips</h2>
    <?php if (count($savedTrips) > 0): ?>
      <ul>
        <?php foreach ($savedTrips as $trip): ?>
          <li>
            <strong><?= htmlspecialchars($trip['tripName']) ?></strong> — <?= htmlspecialchars($trip['destination']) ?>
            (<?= htmlspecialchars($trip['start_date']) ?> to <?= htmlspecialchars($trip['end_date']) ?>)
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>You have no saved trips yet. <a href="TripPlanner.php">Plan your first trip!</a></p>
    <?php endif; ?>
  </section>
</main>

<footer>
  <p>&copy; 2025 TravelNow Inc. | <a onclick="toggleContactInfo()" href="javascript:void(0)" aria-expanded="false" aria-controls="contactInfo">Contact Us</a></p>
  <div id="contactInfo" style="display: none;" aria-hidden="true">
    <p>Email: support@travelnow.com</p>
    <p>Phone: +1 (800) 123-4567</p>
    <p>Address: 123 Explorer Ave, Wander City, WC 45678</p>
  </div>
</footer>

<script>
  const contactToggle = document.querySelector("footer a");
  const contactInfo = document.getElementById("contactInfo");

  function toggleContactInfo() {
    if (contactInfo.style.display === "block") {
      contactInfo.style.display = "none";
      contactToggle.setAttribute("aria-expanded", "false");
      contactInfo.setAttribute("aria-hidden", "true");
    } else {
      contactInfo.style.display = "block";
      contactToggle.setAttribute("aria-expanded", "true");
      contactInfo.setAttribute("aria-hidden", "false");
    }
  }
</script>

</body>
</html>
