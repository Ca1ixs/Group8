<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Featured Destinations</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>

<?php include 'header.php'; ?>

<main>
  <section class="destinations">
    <h2>Featured Destinations (Coming Soon!)</h2>
    <p>We’re hand-picking some amazing trips just for you. Here’s a sneak peek:</p>

    <article>
      <img src="images/sample1.jpg" alt="Tropical Beach Preview"/>
      <h3>Paradise Beach</h3>
      <p>Relax under the palm trees and swim in crystal-clear waters. Coming soon to our top picks!</p>
    </article>

    <article>
      <img src="images/sample2.jpg" alt="Mountain Retreat Preview"/>
      <h3>Alpine Escape</h3>
      <p>Escape the everyday with this mountain adventure. Hiking, cozy lodges, and fresh alpine air await.</p>
    </article>
  </section>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
