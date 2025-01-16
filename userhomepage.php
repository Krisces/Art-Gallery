<!DOCTYPE html>
<html lang="en">

<?php
    session_start();
    
    if (!isset($_SESSION['logged_in'])){
        $_SESSION['logged_in'] = False;
    }
    
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    $con = new mysqli('mysql.eecs.ku.edu', '447s24_d007s019', 'oozae7Xo', '447s24_d007s019');
    
    if (!$_SESSION['logged_in']){
        header('Location: https://people.eecs.ku.edu/~h232m035/homepage.php');
    }
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EECS 447 - Art Gallery</title>
   <!-- Link to external CSS file -->
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <div class="container">
      <!-- Page title -->
      <h1>EECS 447 - Art Gallery</h1>
    </div>
  </header>

  <section>
    <div class="container">
      <!-- Display welcome message -->
      <h2>Welcome to your Art Gallery,
        <?php echo $_SESSION['USER_NAME']; ?>!
      </h2 </div>

      <div class="container">
         <!-- Query to view account information -->
        <h3>Account Information</h3>
        <h3>Account Type:</h3>
        <?php echo $_SESSION['ACCOUNT_TYPE'] ?>
        <h3>User Name:</h3>
        <?php echo $_SESSION['USER_NAME'] ?>
        <h3>Password (What could go wrong posting this here? Nothing could.):</h3>
        <?php echo $_SESSION['PASS_WORD'] ?>
        <h3>Creation Date:</h3>
        <?php echo $_SESSION['CREATED_ON'] ?>
        <h3>Account ID:</h3>
        <?php echo $_SESSION['ACCOUNT_ID'] ?>
        <h3>Linked Account ID:</h3>
        <?php echo $_SESSION['LINKED_ACCOUNT_ID'] ?>
        <br>
        <h3>All Linked Payment Methods:</h3>
        <?php
            $query = "SELECT * FROM PROJ_PAYMENT_METHOD WHERE LINKED_ACCOUNT_ID = ?";
            $total = 0;
            $statement = $con->prepare($query);
            $statement->execute([$_SESSION['ACCOUNT_ID']]);
            $result = $statement->get_result();
            $row = $result->fetch_assoc();
            if (!$row){
                echo "(No payment methods found.)<br>";
            }
            while ($row){
                echo "<div class = 'container'>";
                echo "<h2>";
                echo "Payment Method ID:";
                echo htmlentities($row['PAYMENT_METHOD_ID']);
                echo "</h2>";
                echo "<br>";
                echo "BALANCE: ";
                echo htmlentities($row['BALANCE']);
                echo "<br>";
                echo "TYPE: ";
                echo htmlentities($row['TYPE']);
                echo "<br>";
                echo "Routing Info: ";
                echo htmlentities($row['ROUTING_INFO']);
                echo "<br>";
                echo "Opened on: ";
                echo htmlentities($row['OPENED_ON']);
                echo "<br>";
                echo "</div>";
                echo "<br>";
                $total = $total + $row['BALANCE'];
                $row = $result->fetch_assoc();
            }
            echo "<br>";
            echo "Balance Overall: ";
            echo $total;
            echo "<br>";
        ?>
        
        
        <br>
      </div>

      <?php if ($_SESSION['ACCOUNT_TYPE'] === 'Buyer'): ?>
      <div class="container">
        <!-- Query to view most recent purchase -->
        <h3>All Items Most Recently Bought By You:</h3>
        <?php
        $query = "SELECT * FROM PROJ_PRODUCT, PROJ_ACCOUNT WHERE ACCOUNT_ID = SELLER_ACCOUNT_ID AND LAST_BUYER_ACCOUNT_ID = ?;";
        $statement = $con->prepare($query);
        $statement->execute([$_SESSION['ACCOUNT_ID']]);
        $result = $statement->get_result();
        $row = $result->fetch_assoc();
        if (!$row){
            echo "(No items meet this criteria.)<br>";
        }
        
        while ($row){
            echo "<div class = 'container'>";
            echo "<h2>";
            echo htmlentities($row['NAME']);
            echo ":";
            echo "</h2>";
            echo "<br>";
            echo "<img src=".htmlentities($row['IMAGE'])." loading = \"Lazy\" width = \"500\">";
            echo "<br>";
            echo htmlentities($row['DESCRIPTION']);
            echo "<br>";
            echo "Rating: ";
            echo htmlentities($row['RATING']);
            echo "/5";
            echo "<br>";
            echo "Price: ";
            echo htmlentities($row['PRICE']);
            echo " USD";
            echo "<br>";
            echo "Sold by: ";
            echo htmlentities($row['USER_NAME']);
            echo "<br>";
            echo "</div>";
            echo "<br>";
            $row = $result->fetch_assoc();
        }
        ?>
      </div>
      <?php endif; ?>
    
      <?php if ($_SESSION['ACCOUNT_TYPE'] === 'Seller'): ?>
      <div class="container">
        <!-- Query to view sold items -->
        <h3>Here are of your Sold Items:</h3>
        <p>See the items you sold at the art gallery.</p>
        <!-- ADJUST -->
        <form action="searchresults.php" method="get">
          <input type="hidden" name="query" value="username__username" readonly>
          <button type="submit">View Your Items</button>
        </form>
      </div>
      <?php endif; ?>

      <?php if ($_SESSION['ACCOUNT_TYPE'] === 'Buyer'): ?>
      <div class="container">
        <!-- Form to buy item -->
        <h3>Buy an Item</h3>
        <p>Place an order to purchase an available item from the art gallery.</p>
        <!-- ADJUST -->
        <form action="INSERT.php" method="post">
          <input type="text" name="item_name" placeholder="Item Name" required>
          <input type="number" name="quantity" placeholder="Quantity" required>
          <button type="submit">Buy Item</button>
        </form>
      </div>
      <?php endif; ?>

      <?php if ($_SESSION['ACCOUNT_TYPE'] === 'Seller'): ?>
      <div class="container">
        <!-- Form to sell new item -->
        <h3>Sell a New Item</h3>
        <p>Add a new piece of artwork to the gallery for sale.</p>
        <!-- ADJUST -->
        <form action="INSERT.php" method="post">
          <input type="text" name="item_name" placeholder="Item Name" required>
          <input type="text" name="description" placeholder="Description" required>
          <input type="number" name="price" placeholder="Price" required>
          <input type="number" name="stock" placeholder="Stock" required>
          <button type="submit">Sell New Item</button>
        </form>
      </div>
      <?php endif; ?>

      <div class="container">
        <h2>Discover the Art Gallery
        </h2>
        <p>Discover unique pieces of art and bring beauty into your life.</p>
        <nav>
          <div class="container">
            <ul>
              <!-- Link to available artwork. ADJUST -->
              <li><a href="artworks.php">Available Artwork</a></li>

            </ul>
          </div>
        </nav>
      </div>

      <div class="container">
        <h2>Search Artwork</h2>
        <!-- Search artwork section -->
        <p>Explore the available artwork by searching through item names and descriptions.</p>
        <!-- ADJUST -->
        <form action="searchresults.php" method="get">
          <input type="text" name="query" placeholder="Enter search term">
          <button type="submit">Search</button>
        </form>
      </div>
        
      <?php if (!($_SESSION['LINKED_ACCOUNT_ID'] === 00000)): ?>
      <div class="container">
        <!-- Log out button -->
        <h3>Swap to Linked Account</h3>
        <!-- ADJUST -->
        <form action="login.php" method="post">
          <input type="hidden" name="username" value="Swap__Swap" required readonly>
          <input type="hidden" name="password" value="idk" required readonly>
          <button type="submit">Swap</button>
        </form>
      </div>
       <?php endif; ?>

      <div class="container">
        <!-- Log out button -->
        <h3>Log Out</h3>
        <!-- ADJUST -->
        <form action="logout.php" method="post">
          <button type="submit">Log Out</button>
        </form>
      </div>
  </section>
  <br><br><br><br><br><br>

  <footer>
    <div>
      <p>&copy; 2024 EECS 447 - Art Gallery. All rights reserved.</p>
    </div>
  </footer>
</body>

</html>
