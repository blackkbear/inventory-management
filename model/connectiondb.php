<?php
/**hostname, username, password, database */
$connection = mysqli_connect("localhost", "root", "", "modulosdb"); //or die (mysqli_error($conection));
mysqli_select_db($connection, "modulosdb"); //or die (mysqli_error($connection));
mysqli_set_charset($connection, 'utf8');
mysqli_query($connection, "SET time_zone = '-6:00';");

if (!$connection) {

    die ("Connection Failed" . mysqli_connect_error());

}
/*else{
    echo "succesful";
}*/
?>