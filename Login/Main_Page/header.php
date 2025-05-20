<?php
// header.php
// NO session_start() here!
$username = $_SESSION['username'] ?? 'Guest';
?>
<header role="banner">
  <div class="logo">
    <a href="CompassHome.php" aria-label="Compass Home">
      <img src="Compass_Site/Assets/images/compass_logo.gif" alt="Compass logo" />
    </a>
  </div>

  <nav role="navigation" aria-label="Main menu">
    <ul>
      <li><a href="TripPlanner.php" class="tripplanner-btn" aria-label="Trip Planner">Trip Planner</a></li>
      <li><a href="Destinations.php" class="destinations-btn" aria-current="page" aria-label="Destinations">Destinations</a></li>
      <li><a href="Travelog.php" class="travelog-btn" aria-label="Travel Log">Travel Log</a></li>
    </ul>
  </nav>

  <div class="user-info" tabindex="0" role="button" aria-haspopup="true" aria-expanded="false" aria-label="User menu">
    <?= htmlspecialchars($username) ?>
    <div id="dropdownMenu" role="menu" aria-label="User options">
      <a href="profile.php" role="menuitem">Profile</a>
      <a href="../logout.php" role="menuitem">Logout</a>
    </div>
  </div>
</header>
