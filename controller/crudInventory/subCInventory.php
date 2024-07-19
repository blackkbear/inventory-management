<?php
include (__DIR__ . "/../../model/connectiondb.php");

session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /**nombre de boton sumar cantidad es btnSumar que postea en form modal sum inventory */
    if (isset ($_POST['btnRestarCantidad'])) {

        $idProducto = $_POST['idProducto'];
        $subtractQuantity = $_POST['restarCantidad'];
        $errorIcon = '<i class="fa-solid fa-circle-xmark" style="color: #dc3545;"></i>';
        $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';


        $query = "SELECT cantidad FROM inventario WHERE idProducto = $idProducto";
        $result = mysqli_query($connection, $query);

        if (!is_numeric($subtractQuantity)) {

            $_SESSION['subCInventoryCantidadError'] = $errorIcon . "La cantidad debe ser un número entero";
            header("Location: /programDental/view/inventoryView.php");
            exit();
        }
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $currentQuantity = $row['cantidad'];

            if ($currentQuantity < $subtractQuantity) {
                $_SESSION['subCInventoryInventoryIs0'] = $errorIcon . "No se puede restar, ya que el inventario del producto es 0";
                header("Location: /programDental/view/inventoryView.php");
                exit();
            }

            $newQuantity = $currentQuantity - $subtractQuantity;


            $updateQuery = "UPDATE inventario SET cantidad = $newQuantity WHERE idProducto = $idProducto";
            $updateResult = mysqli_query($connection, $updateQuery);
            if ($updateResult) {

                $_SESSION['subCInventoryCantidadSuccess'] = "Cantidad restada del inventario correctamente " . $successIcon;
                header("Location: /programDental/view/inventoryView.php");
                exit();
            } else {

                $_SESSION['subCInventoryCantidadUpdError'] = $errorIcon . "Error al actualizar la cantidad en el inventario: " . mysqli_error($connection);
                header("Location: /programDental/view/inventoryView.php");
                exit();
            }
        } else {

            $_SESSION['subCInventoryCantidadObtError'] = $errorIcon . "Error al obtener la cantidad actual del producto: " . mysqli_error($connection);
            header("Location: /programDental/view/inventoryView.php");
            exit();
        }
    } else {

        $_SESSION['subCInventoryCantidadInvalidError'] = $errorIcon . "Método de solicitud no válido.";
        header("Location: /programDental/view/inventoryView.php");
        exit();
    }
}
?>