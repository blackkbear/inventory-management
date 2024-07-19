<?php

include (__DIR__ . "/../../model/connectiondb.php");

if (!isset ($_SESSION["nombreUsuario"])) {
    header("Location: ../../index.php");
    exit;
}

$loggedUser = checkLogin($connection);
$errorIcon = '<i class="fa-solid fa-circle-xmark" style="color: #dc3545;"></i>';
$query = "SELECT l.idPedido, u.nombreCompleto as idEmpleado, l.fechaPedido, l.descripcionLista, l.estadoPedido 
          FROM listascompras l
          JOIN usuarios u ON l.idEmpleado = u.idEmpleado
          WHERE u.idEmpleado = '{$loggedUser['idEmpleado']}' AND l.estadoPedido = 'Proceso'";

$result = mysqli_query($connection, $query);
if (!$result) {
    die ("Connection failed: " . mysqli_error($connection));
} else {
    // Check if any rows are returned from the query
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td>
                    <?php echo $row['idPedido']; ?>
                </td>
                <td>
                    <?php echo $row['idEmpleado']; ?>
                </td>
                <td>
                    <?php echo $row['fechaPedido']; ?>
                </td>
                <td>
                    <?php echo $row['descripcionLista']; ?>
                </td>
                <!--<td>
                    <?//php echo $row['estadoPedido'];     ?>
                </td>-->
                <script>
                    function generatePDF(idPedido) {
                        window.open(
                            `../../programDental/controller/crudProductsLists/pdfList.php?generatePdf=true&idPedido=${idPedido}`, '_blank');
                    }
                </script>

                <td>
                    <button class="btnStatusList" data-bs-toggle="modal" data-bs-target="#modalEditStatus">Listo</button>

                    <button class="btnPdfList" onclick="generatePDF(<?= $row['idPedido']; ?>)">
                        <i class="fa-regular fa-file-pdf fa-lg"
                            style="color: #f2f3f4; font-size: 22px; width: 45px; height: 10px; text-align: center;"></i>
                    </button>

                    <button class="btnDeleteList" data-bs-toggle="modal" data-bs-target="#modalDeleteList"
                        data-id-pedido="<?php echo $row['idPedido']; ?>">Eliminar</button>
                </td>
            </tr>
            <?php
        }
    } else {
        $_SESSION['readProductsError'] = $errorIcon . "No se han encontrado listas de compras";

    }

}
?>