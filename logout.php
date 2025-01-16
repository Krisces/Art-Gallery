<!DOCTYPE html>
<html lang="en">

<?php
    session_start();
    session_destroy();
    header('Location: https://people.eecs.ku.edu/~h232m035/homepage.php');
?>
