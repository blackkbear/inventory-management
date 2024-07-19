<?php
include (__DIR__ . "/../../model/connectiondb.php");


if (!isset ($_SESSION["nombreUsuario"])) {
    header("Location: ../../index.php");
    exit;
}
$errorIcon = '<i class="fa-solid fa-circle-xmark" style="color: #dc3545;"></i>';

$loggedUser = checkLogin($connection);

$query = "SELECT l.idPedido, u.nombreCompleto as idEmpleado, l.fechaPedido, l.descripcionLista, l.estadoPedido 
          FROM listascompras l
          JOIN usuarios u ON l.idEmpleado = u.idEmpleado
          WHERE u.idEmpleado = '{$loggedUser['idEmpleado']}' AND l.estadoPedido = 'Completado'";

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
    <script>
    function generatePDF(idPedido) {
        window.open(
            `../../programDental/controller/crudProductsLists/pdfList.php?generatePdf=true&idPedido=${idPedido}`,
            '_blank');
    }
    </script>
    <td>
        <button class="btnPdfList" onclick="generatePDF(<?= $row['idPedido']; ?>)">
            <i class="fa-regular fa-file-pdf fa-lg"
                style="color: #f2f3f4; font-size: 22px; width: 45px; height: 10px; text-align: center;"></i>
        </button>

        <button class="btnDeleteHistoryList" data-bs-toggle="modal" data-bs-target="#modalDeleteHistoryList"
            data-id-pedido="<?php echo $row['idPedido']; ?>">Eliminar</button>
    </td>
</tr>
<?php
        }
    } else {
        $_SESSION['readReadyError'] = $errorIcon . "No se han encontrado listas completadas";
    }
}
?>