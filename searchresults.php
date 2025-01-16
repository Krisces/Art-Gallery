<!DOCTYPE html>

<?php
    session_start();
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Available Artwork</title>
    <link rel="stylesheet" href="style.css"/>
  </head>

  <body>
    <!Get the artworks with a query.>
    <?php
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    $con = new mysqli('mysql.eecs.ku.edu', '447s24_d007s019', 'oozae7Xo', '447s24_d007s019');
    $query = "SELECT DISTINCT * FROM PROJ_PRODUCT, PROJ_ACCOUNT WHERE QUANTITY > 0 AND ACCOUNT_ID = SELLER_ACCOUNT_ID AND (NAME LIKE ? OR DESCRIPTION LIKE ? OR USER_NAME LIKE ?) ORDER BY PRODUCT_ID ASC;";
    if ($con){
        $statement = $con->prepare($query);
        $target = $_REQUEST['query'];
        if ($target === "username__username"){
            $target = $_SESSION['USER_NAME'];
        }
        $statement->execute(["%".$target."%", "%".$target."%", "%".$target."%"]);
        $result = $statement->get_result();
        $row = $result->fetch_assoc();
        if (!$row){
            echo "(No results match that search.)<br>";
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
    }
    else {
        echo "That's an error.";
    }

    ?>

    <div>
        <br>End of results!<br>
    </div>
  </body>

</html>
