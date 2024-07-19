<?php
include (__DIR__ . "/../../model/connectiondb.php");

session_start();

if (isset ($_POST['btnConfirmDeleteInventory'])) { //este nombre proviene del name del boton si,confirmar
    $idProducto = $_POST['idProducto_delete']; //este nombre proviene del name del input
    $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';
    $deleteAlertasQuery = "DELETE FROM alertasproductos WHERE idProducto='$idProducto'";
    $deleteAlertasResult = mysqli_query($connection, $deleteAlertasQuery);

    if (!$deleteAlertasResult) {
        die ("Query failed to delete related alerts: " . mysqli_error($connection));
    }
    $query = "DELETE FROM inventario WHERE idProducto='$idProducto'";
    $result = mysqli_query($connection, $query);
    if ($result) {
        $_SESSION['deleteInventorySuccess'] = "Se ha eliminado el producto exitosamente " . $successIcon;
    } else {
        die ("Query falló " . mysqli_error($connection));
    }
    header("Location: /programDental/view/inventoryView.php");
    exit();
}
?>