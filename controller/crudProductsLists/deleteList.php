<?php
include (__DIR__ . "/../../model/connectiondb.php");

session_start();

//es para que no se puedan injectar SQL, ni se pueda accesar sin una sesion iniciada.
if (!isset ($_SESSION['nombreUsuario'])) {
    header("Location: /programDental/index.php");
    exit();
}

if (isset ($_POST['btnConfirmDeleteList'])) { //este nombre proviene del name del boton si,confirmar en modal
    $idPedido = $_POST['idPedido_delete']; //este nombre proviene del name del input del modal
    $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';

    $query = "DELETE FROM listascompras WHERE idPedido='$idPedido'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['deleteListSuccess'] = "Se ha eliminado la lista exitosamente " . $successIcon;
    } else {
        die ("Query falló " . mysqli_error($connection));
    }

    header("Location: /programDental/view/processProductsListsView.php");
    exit();
}
?>