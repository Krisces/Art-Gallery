<!DOCTYPE html>
<html lang="en">

<?php
    session_start();
    
    if (!isset($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = False;
    }
    
    if ($_SESSION['logged_in']){
        header('Location: https://people.eecs.ku.edu/~h232m035/userhomepage.php');
    }
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EECS 447 - Art Gallery</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    $con = new mysqli('mysql.eecs.ku.edu', '447s24_d007s019', 'oozae7Xo', '447s24_d007s019');
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    }
    ?>

  <header>
    <div class="container">
      <h1>EECS 447 - Art Gallery</h1>
    </div>
  </header>

  <section>
    <div class="container">
      <h2>Welcome to our Art Gallery!</h2>
      <p>Discover unique pieces of art and bring beauty into your life.</p>
      <nav>
        <div class="container">
          <ul>
            <!-- ADJUST -->
            <li><a href="artworks.php">Available Artwork</a></li>

          </ul>
        </div>
      </nav>
    </div>

    <div class="container">
      <h2>Search Artwork</h2>
      <p>Explore the available artwork by searching through item names and descriptions.</p>
      <!-- ADJUST -->
      <form action="searchresults.php" method="get">
        <input type="text" name="query" placeholder="Enter search term">
        <button type="submit">Search</button>
      </form>
    </div>
  </section>

  <div class="container">
    <h2>Sign In</h2>
    <!-- ADJUST. IN PHP, REDIRECT TO userhomepage.html  -->
    <form action="login.php" method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" value="Sign In">
    </form>
  </div>

  <footer>
    <div>
      <p>&copy; 2024 EECS 447 - Art Gallery. All rights reserved.</p>
    </div>
  </footer>
</body>

</html>
