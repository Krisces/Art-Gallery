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
    
    if ($_SESSION['logged_in'] and $_REQUEST['username'] === "Swap__Swap"){
        $_SESSION['logged_in'] = False;
        $query = "SELECT * FROM PROJ_ACCOUNT WHERE ACCOUNT_ID = ?;";
        $statement = $con->prepare($query);
        $statement->execute([$_SESSION['LINKED_ACCOUNT_ID']]);
        $result = $statement->get_result();
        $row = $result->fetch_assoc();
        if (!$row){
           header('Location: https://people.eecs.ku.edu/~h232m035/failedLogin.php');
        }
        $_REQUEST['username'] = htmlentities($row['USER_NAME']);
        $_REQUEST['password'] = htmlentities($row['PASS_WORD']);
    }
    
    if (!$_SESSION['logged_in']){
        $query = "SELECT * FROM PROJ_ACCOUNT WHERE USER_NAME = ? AND PASS_WORD = ?";
        if ($con){
            $statement = $con->prepare($query);
            $statement->execute([$_REQUEST['username'],$_REQUEST['password']]);
            $result = $statement->get_result();
            $row = $result->fetch_assoc();
            if (!$row){
                header('Location: https://people.eecs.ku.edu/~h232m035/failedLogin.php');
            }
            else {
                //success
                $_SESSION['logged_in'] = True;
                $_SESSION['ACCOUNT_ID'] = htmlentities($row['ACCOUNT_ID']);
                $_SESSION['USER_NAME'] = htmlentities($row['USER_NAME']);
                $_SESSION['PASS_WORD'] = htmlentities($row['PASS_WORD']);
                $_SESSION['CREATED_ON'] = htmlentities($row['CREATED_ON']);
                $_SESSION['LINKED_ACCOUNT_ID'] = htmlentities($row['LINKED_ACCOUNT_ID']);
                
                //Get account type
                $query2 = "SELECT * FROM PROJ_ACCOUNT, PROJ_BUYER WHERE USER_NAME = ? AND PASS_WORD = ? AND PROJ_ACCOUNT.ACCOUNT_ID = PROJ_BUYER.ACCOUNT_ID";
                $query3 = "SELECT * FROM PROJ_ACCOUNT, PROJ_SELLER WHERE USER_NAME = ? AND PASS_WORD = ? AND PROJ_ACCOUNT.ACCOUNT_ID = PROJ_SELLER.ACCOUNT_ID";
                $statement2 = $con->prepare($query2);
                $statement2->execute([$_REQUEST['username'],$_REQUEST['password']]);
                $result2 = $statement2->get_result();
                $row2 = $result2->fetch_assoc();
                $statement3 = $con->prepare($query3);
                $statement3->execute([$_REQUEST['username'],$_REQUEST['password']]);
                $result3 = $statement3->get_result();
                $row3 = $result3->fetch_assoc();
                if ($row2 and !$row3){
                    $_SESSION['ACCOUNT_TYPE'] = 'Buyer';
                }
                else if (!$row2 and $row3){
                    $_SESSION['ACCOUNT_TYPE'] = 'Seller';
                }
                else {
                    $_SESSION['ACCOUNT_TYPE'] = 'Unknown';
                }
            }
        }
        else {
            echo "That's an error.";
        }
    }
    header('Location: https://people.eecs.ku.edu/~h232m035/userhomepage.php');
?>
