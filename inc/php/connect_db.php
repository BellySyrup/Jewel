<?php

try
{
    $user = "stephan";
    $pass = "stxK2ocePfCd";
    $dbh = new PDO('mysql:host=localhost;dbname=stephan_jewel', $user, $pass);
}
catch (PDOException $e)
{
   print("Error: ".$e->getMessage()."<br />
    ");
}

?>