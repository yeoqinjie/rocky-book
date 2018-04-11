<?php
/**
 * Function to create a new MySQL DB connection
 */
function connect_pdo() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "test123";
    $dbh = "";
    try {
      $dbh = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    return $dbh;
}


