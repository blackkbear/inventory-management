<?php
include (__DIR__ . "/../../model/connectiondb.php");

session_start();
//es para que no se puedan injectar SQL, ni se pueda accesar sin una sesion iniciada.
if (!isset ($_SESSION['nombreUsuario'])) {
    header("Location: /programDental/index.php");
    exit();
}

/* Si no hay usuario, nos mandara al login
if (!isset($_SESSION["nombreCompleto"])) {
    header("Location: ../../index.php");
    exit; 
    } previene mas ejecuciones de scripts
    */

/**nombre de boton de agregar user en form es btnAddUser */
if (isset ($_POST['btnAddUser'])) {
    $nombreCompleto = $_POST['nombreCompleto'];
    $cedula = $_POST['cedula'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $contrasena = $_POST['contrasena'];
    $rolUsuario = $_POST['rolUsuario'];

    $errorIcon = '<i class="fa-solid fa-circle-xmark" style="color: #dc3545;"></i>';
    $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';

    // Validación: nombreUsuario no puede ser igual al nombreCompleto
    if ($nombreUsuario == $nombreCompleto) {
        $_SESSION['addUsernameError'] = $errorIcon . " El nombre de usuario no puede ser igual al nombre completo";
        header("Location: /programDental/view/usersView.php");
        exit();
    }

    $query = "SELECT * FROM usuarios WHERE nombreUsuario = '$nombreUsuario'";
    $result = mysqli_query($connection, $query);

    // Check if username exists
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['addUsernameError'] = $errorIcon . " El nombre de usuario ya existe, intente con otro usuario";
    }

    // Revisar si cedula ya existe
    $queryCedula = "SELECT * FROM usuarios WHERE cedula = '$cedula'";
    $resultCedula = mysqli_query($connection, $queryCedula);

    if (mysqli_num_rows($resultCedula) > 0) {
        $_SESSION['addUserCedulaError'] = $errorIcon . " La cédula ya existe, intente con otra cédula";
    }

    // If no errors, insert new info and create user
    if (!isset ($_SESSION['addUsernameError']) && !isset ($_SESSION['addUserCedulaError'])) {
        $query = "INSERT INTO usuarios (nombreCompleto, cedula, nombreUsuario, contrasena, rolUsuario)
                  VALUES ('$nombreCompleto', '$cedula', '$nombreUsuario', '$contrasena', '$rolUsuario')";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $_SESSION['addUserSuccess'] = " Se ha agregado el usuario exitosamente " . $successIcon;
        } else {
            die ("Query falló " . mysqli_error($connection));
        }
    }

    header("Location: /programDental/view/usersView.php");
    exit();
}
?>