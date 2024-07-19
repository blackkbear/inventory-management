<?php
session_start();
if (isset ($_SESSION['nombreUsuario'])) {
    unset($_SESSION['nombreUsuario']);
    session_destroy();
}
header("Location: /programDental/index.php");
?>