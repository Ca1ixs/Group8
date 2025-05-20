<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

require_once '../db.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Trip Planner</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>

<?php include 'header.php'; ?>

<main>
  <section class="trip-planner-container">
    <div class="trip-planner-form">
      <h1>Plan Your Next Adventure</h1>
      <form method="post" action="save_trip.php">
        <label for="tripName">Trip Name:</label>
        <input type="text" id="tripName" name="tripName" required />

        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" required />

        <label for="startDate">Start Date:</label>
        <input type="date" id="startDate" name="startDate" required />

        <label for="endDate">End Date:</label>
        <input type="date" id="endDate" name="endDate" required />

        <label for="notes">Notes:</label>
        <textarea id="notes" name="notes"></textarea>

        <button type="submit">Save Trip</button>
      </form>
    </div>

    <div class="saved-trips-list">
      <h2>Your Saved Trips</h2>
      <?php
      $stmt = $conn->prepare("SELECT * FROM trips WHERE user_id = ? ORDER BY create_at DESC");
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows === 0) {
          echo "<p>No trips saved yet.</p>";
      } else {
          while ($trip = $result->fetch_assoc()) {
              echo "<div class='trip'>";
              echo "<h3>" . htmlspecialchars($trip['tripName']) . "</h3>";
              echo "<p><strong>Destination:</strong> " . htmlspecialchars($trip['destination']) . "</p>";
              echo "<p><strong>Dates:</strong> " . htmlspecialchars($trip['start_date']) . " to " . htmlspecialchars($trip['end_date']) . "</p>";
              echo "<p><strong>Notes:</strong> " . nl2br(htmlspecialchars($trip['notes'])) . "</p>";
              echo "<p><a href='delete_trip.php?id=" . $trip['id'] . "' onclick='return confirm(\"Are you sure you want to delete this trip?\");'>Delete</a></p>";
              echo "</div>";
          }
      }
      ?>
    </div>
  </section>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
