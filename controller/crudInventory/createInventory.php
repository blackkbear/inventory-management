<?php
include (__DIR__ . "/../../model/connectiondb.php");

session_start();

unset($_SESSION['addInventoryNameError']);
unset($_SESSION['addInventorySuccess']);

/**nombre de boton de agregar producto en form es btnAddInventory */
if (isset ($_POST['btnAddInventory'])) {
    $nombreProducto = $_POST['nombreProducto'];
    $cantidad = $_POST['cantidad'];
    $descripcion = $_POST['descripcion'];
    $idCategoria = $_POST['idCategoria'];

    $errorIcon = '<i class="fa-solid fa-circle-xmark" style="color: #dc3545;"></i>';
    $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';



    // Check if product name exists
    $query = "SELECT * FROM inventario WHERE nombreProducto = '$nombreProducto'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // If product exists, display an error message
        $_SESSION['addInventoryNameError'] = $errorIcon . "El nombre de producto ya existe, intente con otro nombre";
    }

    if (!is_numeric($cantidad)) {
        $_SESSION['addInventoryCantidadError'] = $errorIcon . "La cantidad debe ser un número entero";
    }

    if ($cantidad == 0) {
        $_SESSION['addInventoryCantidad0Error'] = $errorIcon . "La cantidad del producto no puede ser 0";
    }


    // If both validations pass, insert the product
    if (!isset ($_SESSION['addInventoryCantidadError']) && !isset ($_SESSION['addInventoryNameError']) && ($cantidad != 0)) {
        $query = "INSERT INTO inventario (nombreProducto, cantidad, descripcion, idCategoria) VALUES ('$nombreProducto','$cantidad','$descripcion','$idCategoria')";
        $result = mysqli_query($connection, $query);
        if ($result) {
            $_SESSION['addInventorySuccess'] = "Se ha agregado el producto exitosamente " . $successIcon;
        } else {
            die ("Query falló " . mysqli_error($connection));
        }
    }

    header("Location: /programDental/view/inventoryView.php");
    exit();
}