<?php
include (__DIR__ . "/../../model/connectiondb.php");

session_start();
//es para que no se puedan injectar SQL, ni se pueda accesar sin una sesion iniciada.
if (!isset ($_SESSION['nombreUsuario'])) {
    header("Location: /programDental/index.php");
    exit();
}

if (isset ($_POST['btnConfirmDeleteUser'])) {
    $idEmpleado = $_POST['idEmpleado_delete'];
    $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';
    $errorIcon = '<i class="fa-solid fa-circle-xmark" style="color: #dc3545;"></i>';

    if ($idEmpleado == 1) {
        $_SESSION['deleteUserError'] = $errorIcon . "No se puede eliminar el usuario principal del sistema, cuyo ID es 1";
        header("Location: /programDental/view/usersView.php");
        exit();
    }

    $query = "DELETE FROM usuarios WHERE idEmpleado='$idEmpleado'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['deleteUserSuccess'] = "Se ha eliminado el usuario exitosamente " . $successIcon;
    } else {
        die ("Query falló " . mysqli_error($connection));
    }

    header("Location: /programDental/view/usersView.php");
    exit();
}
?>