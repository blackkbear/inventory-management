<?php
include (__DIR__ . "/../../model/connectiondb.php");

session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /**nombre de boton sumar cantidad es btnSumar que postea en form modal sum inventory */
    if (isset ($_POST['btnSumarCantidad'])) {

        $idProducto = $_POST['idProducto'];
        $addQuantity = $_POST['sumarCantidad'];
        $errorIcon = '<i class="fa-solid fa-circle-xmark" style="color: #dc3545;"></i>';
        $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';


        $query = "SELECT cantidad FROM inventario WHERE idProducto = $idProducto";
        $result = mysqli_query($connection, $query);

        if (!is_numeric($addQuantity)) {

            $_SESSION['sumCInventoryCantidadError'] = $errorIcon . "La cantidad debe ser un número entero";
            header("Location: /programDental/view/inventoryView.php");
            exit();
        }
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $currentQuantity = $row['cantidad'];

            // Calculate the new total quantity
            $newQuantity = $currentQuantity + $addQuantity;

            // Update the database with the new total quantity
            $updateQuery = "UPDATE inventario SET cantidad = $newQuantity WHERE idProducto = $idProducto";
            $updateResult = mysqli_query($connection, $updateQuery);
            if ($updateResult) {
                // Redirect to the inventory view page with a success message
                $_SESSION['sumCInventoryCantidadSuccess'] = "Cantidad agregada al inventario correctamente " . $successIcon;
                header("Location: /programDental/view/inventoryView.php");
                exit();
            } else {
                // Handle database update error
                $_SESSION['sumCInventoryCantidadUpdError'] = $errorIcon . "Error al actualizar la cantidad en el inventario: " . mysqli_error($connection);
                header("Location: /programDental/view/inventoryView.php");
                exit();
            }
        } else {
            // Handle database query error
            $_SESSION['sumCInventoryCantidadObtError'] = $errorIcon . "Error al obtener la cantidad actual del producto: " . mysqli_error($connection);
            header("Location: /programDental/view/inventoryView.php");
            exit();
        }
    } else {
        // Handle missing sumarCantidad field error
        $_SESSION['sumCInventoryCantidadMissError'] = $errorIcon . "La cantidad a sumar no se ha proporcionado.";
        header("Location: /programDental/view/inventoryView.php");
        exit();
    }
} else {
    // Handle invalid request method error
    $_SESSION['sumCInventoryCantidadInvalidError'] = $errorIcon . "Método de solicitud no válido.";
    header("Location: /programDental/view/inventoryView.php");
    exit();
}
?>