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
  <title>Travel Log</title>
  <link rel="stylesheet" href="styles.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f9fafb;
      margin: 0;
      padding: 0;
      color: #1f2937;
    }

    main {
      max-width: 900px;
      margin: 2rem auto;
      padding: 2rem;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    section {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    section p {
      font-size: 1.2rem;
      color: #4b5563;
    }

    @media (max-width: 600px) {
      main {
        margin: 1rem;
        padding: 1.5rem;
      }
    }
  </style>
</head>
<body>

<?php include 'header.php'; ?>

<main>
  <section aria-label="Travel Log Entries">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Your travel logs will be displayed here. Start documenting your journeys.</p>
  </section>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
