<?php

include (__DIR__ . "/../../model/connectiondb.php");

session_start();
//es para que no se puedan injectar SQL, ni se pueda accesar sin una sesion iniciada.
if (!isset ($_SESSION['nombreUsuario'])) {
    header("Location: /programDental/index.php");
    exit();
}


/**nombre de boton confirmar cambios que postea en form modal edit status*/
if (isset ($_POST['btnConfirmEditStatus'])) {

    $idPedido = $_POST['idPedido'];
    $estadoPedido = 'Completado';

    $errorIcon = '<i class="fa-solid fa-circle-xmark" style="color: #dc3545;"></i>';
    $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';


    // Update the category if it doesn't already exist
    $queryUpdate = "UPDATE listascompras SET estadoPedido = '$estadoPedido' WHERE idPedido = '$idPedido'";
    $resultUpdate = mysqli_query($connection, $queryUpdate);

    if ($resultUpdate) {
        $_SESSION['editStatusSuccess'] = "Se ha completado el pedido exitosamente. Visita el historial de pedidos " . $successIcon;
    } else {
        die ("Query falló " . mysqli_error($connection));
    }

    header("Location: /programDental/view/processProductsListsView.php");
    exit();

}



?>