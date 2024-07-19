<?php
include (__DIR__ . "/../../model/connectiondb.php");
include (__DIR__ . "/../validateSession.php");

session_start();

if (!isset ($_SESSION['nombreUsuario'])) {
    header("Location: /programDental/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset ($_POST['btnCrearLista'])) {
        if (isset ($_POST['descriptionListCreation']) && !empty ($_POST['descriptionListCreation']) && isset ($_SESSION['productList']) && !empty ($_SESSION['productList'])) {

            $descriptionListCreation = mysqli_real_escape_string($connection, $_POST['descriptionListCreation']);
            $loggedUser = checkLogin($connection);

            if ($loggedUser) {
                $idEmpleado = $loggedUser['idEmpleado'];

                $errorIcon = '<i class="fa-solid fa-circle-xmark" style="color: #dc3545;"></i>';
                $successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';

                mysqli_autocommit($connection, FALSE);

                $queryInsertList = "INSERT INTO listascompras (idEmpleado, fechaPedido, descripcionLista, estadoPedido) VALUES ('$idEmpleado', NOW(), '$descriptionListCreation', 'Proceso')";
                $resultList = mysqli_query($connection, $queryInsertList);

                if ($resultList) {
                    $idPedido = mysqli_insert_id($connection);

                    foreach ($_SESSION['productList'] as $product) {
                        $productName = mysqli_real_escape_string($connection, $product['productoDetallePedido']);
                        $categoryName = mysqli_real_escape_string($connection, $product['categoriaProductoPedido']);
                        $quantityProduct = $product['cantidadProductoPedido'];

                        $queryInsertDetail = "INSERT INTO detallecompras (idPedido, productoDetallePedido, categoriaProductoPedido, cantidadProductoPedido) VALUES ('$idPedido', '$productName', '$categoryName', '$quantityProduct')";
                        $resultDetail = mysqli_query($connection, $queryInsertDetail);

                        if (!$resultDetail) {
                            $_SESSION['addListError'] = "Error al agregar el detalle de la lista de compras: " . mysqli_error($connection) . ". SQL: " . $queryInsertDetail;
                            mysqli_rollback($connection);
                            break;
                        }
                    }

                    if (!isset ($_SESSION['addListError']) || empty ($_SESSION['addListError'])) {
                        mysqli_commit($connection);
                        $_SESSION['addListSuccess'] = "Se ha creado la lista de compras exitosamente. Visita los pedidos en proceso " . $successIcon;
                        unset($_SESSION['productList']);
                    } else {
                        mysqli_rollback($connection);
                    }
                } else {
                    $_SESSION['addListError'] = "Error al crear la lista de compras: " . mysqli_error($connection) . ". SQL: " . $queryInsertList;
                }
            } else {
                $_SESSION['addListError'] = "Error en la autenticación del usuario.";
            }
        } else {
            $_SESSION['addListError'] = $errorIcon . "No se puede crear una lista sin agregar productos al detalle de la lista";
        }
    }
}

header("Location: ../../view/productsListsView.php");
exit();
?>