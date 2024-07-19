<?php

include (__DIR__ . "/../../model/connectiondb.php");

session_start();

if (!isset ($_SESSION["nombreUsuario"])) {
    header("Location: ../../index.php");
    exit; /*previene mas ejecuciones de scripts*/
}

/**nombre de boton es btnSaveUser que postea en form modal edit user */
if (isset ($_POST['btnSaveUser'])) {

    $idEmpleado = $_POST['idEmpleado'];
    $nombreCompleto = $_POST['nombreCompleto'];
    $cedula = $_POST['cedula'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $contrasena = $_POST['contrasena'];
    $rolUsuario = $_POST['rolUsuario'];

    $errorIcon = '<i class="fa-solid fa-circle-xmark" style="color: #dc3545;"></i>';
    $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';


    $query = "SELECT * FROM usuarios WHERE cedula = '$cedula' AND idEmpleado != '$idEmpleado'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // if cedula exists, display an error message
        $_SESSION['editUserCedulaError'] = $errorIcon . "La cédula ya existe, intente con otra";
    } else {
        // update user, if it doesn't already exist
        $queryUpdate = "UPDATE usuarios SET idEmpleado='$idEmpleado',nombreCompleto='$nombreCompleto', cedula='$cedula', nombreUsuario='$nombreUsuario', contrasena='$contrasena', rolUsuario='$rolUsuario' WHERE idEmpleado= '$idEmpleado'";
        $resultUpdate = mysqli_query($connection, $queryUpdate);

        if ($resultUpdate) {
            $_SESSION['editUserSuccess'] = "Se ha editado el usuario exitosamente " . $successIcon;
        } else {
            die ("Query falló " . mysqli_error($connection));
        }

    }
    header("Location: /programDental/view/usersView.php");
    exit();
}

?>