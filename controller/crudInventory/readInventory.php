<?php
include (__DIR__ . "/../../model/connectiondb.php");

if (!isset ($_SESSION["nombreUsuario"])) {
    header("Location: ../../index.php");
    exit;
}

$errorIcon = '<i class="fa-solid fa-circle-exclamation" style="color: #dc3545;"></i>';  // Definición predeterminada

$query = "SELECT i.idProducto, i.nombreProducto, i.cantidad, i.descripcion, i.idCategoria, c.nombreCategoria 
          FROM inventario i
          JOIN categorias c ON i.idCategoria = c.idCategoria";

// Check if the form is submitted and a category is selected
if (isset ($_GET['btnSubmitFilter']) && isset ($_GET['nombreCategoriaFiltro']) && !empty ($_GET['nombreCategoriaFiltro'])) {
    $selectCategoryFilter = $_GET['nombreCategoriaFiltro'];
    $query .= " WHERE i.idCategoria = '$selectCategoryFilter'";
}

$query .= " ORDER BY i.idProducto ASC";

$result = mysqli_query($connection, $query);

if (!$result) {
    die ("Connection failed: " . mysqli_error($connection));
} else {
    // Check if any rows are returned from the query
    if (mysqli_num_rows($result) > 0) {
        // Products found for the selected category, display the table
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
<tr>
    <td>
        <?php echo $row['idProducto'] ?>
    </td>
    <td>
        <?php echo $row['nombreProducto'] ?>
    </td>
    <td>
        <?php echo $row['cantidad'] ?>
    </td>
    <td>
        <?php echo $row['descripcion'] ?>
    </td>
    <td>
        <?php echo $row['nombreCategoria'] ?>
    </td>
    <td>
        <button class="btnSumProduct" data-bs-toggle="modal" data-bs-target="#modalSumCInventory">+</button>
        <button class="btnSubProduct" data-bs-toggle="modal" data-bs-target="#modalSubCInventory">-</button>
        <button class="btnEditInventory" data-bs-toggle="modal" data-bs-target="#modalEditInventory"
            data-id-categoria="<?php echo $row['idCategoria']; ?>">Editar</button>
        <button class="btnDeleteInventory" data-bs-toggle="modal"
            data-bs-target="#modalDeleteInventory">Eliminar</button>
    </td>
</tr>
<?php
        }
    } else {
        //$_SESSION['filterInventoryError'] = $errorIcon . " No se han encontrado productos con esta categoría";
    }
}
?>