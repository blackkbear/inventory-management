<?php
include (__DIR__ . "/../model/connectiondb.php");

function checkLogin($connection)
{
    if (isset ($_SESSION['nombreUsuario'])) {
        $name = $_SESSION['nombreUsuario'];

        $query = "SELECT * FROM usuarios WHERE nombreUsuario = '$name' LIMIT 1";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $loggedUser = mysqli_fetch_assoc($result);
            return $loggedUser;
        }
    }

    // If the session doesn't exist or the user isn't found in the database
    header("Location: /programDental/index.php");
    exit(); // Ensure script stops executing after redirection
}
?>