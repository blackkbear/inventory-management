<?php

include (__DIR__ . "/../../model/connectiondb.php");

session_start();


/**nombre de boton guardarcambios es btnSaveEditInventory que postea en form modal edit inventory */
if (isset ($_POST['btnSaveEditInventory'])) {
    $idProducto = $_POST['idProducto'];
    $nombreProducto = $_POST['nombreProducto'];
    $cantidad = $_POST['cantidad'];
    $descripcion = $_POST['descripcion'];
    $idCategoria = $_POST['idCategoria'];

    $errorIcon = '<i class="fa-solid fa-circle-xmark" style="color: #dc3545;"></i>';
    $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';


    $query = "SELECT * FROM inventario WHERE nombreProducto = '$nombreProducto' AND idProducto != '$idProducto'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {

        $_SESSION['editInventoryNameError'] = $errorIcon . "El nombre de producto ya existe, intente con otro nombre";
    }

    if (!is_numeric($cantidad)) {

        $_SESSION['editInventoryCantidadError'] = $errorIcon . "La cantidad debe ser un número entero";
    }


    if (!isset ($_SESSION['editInventoryNameError']) && !isset ($_SESSION['editInventoryCantidadError'])) {
        $queryUpdate = "UPDATE inventario SET nombreProducto='$nombreProducto', cantidad='$cantidad', descripcion='$descripcion', idCategoria='$idCategoria' WHERE idProducto ='$idProducto'";
        $resultUpdate = mysqli_query($connection, $queryUpdate);

        if ($resultUpdate) {
            $_SESSION['editInventorySuccess'] = "Se ha editado el producto exitosamente " . $successIcon;
        } else {
            die ("Query falló " . mysqli_error($connection));
        }
    }

    header("Location: /programDental/view/inventoryView.php");
    exit();
}



?>