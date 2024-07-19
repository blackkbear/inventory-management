<?php
include (__DIR__ . "/../../model/connectiondb.php");

if (!isset($_SESSION["nombreUsuario"])) {
    header("Location: ../../index.php");
    exit;
}

$successIcon = '<i class="fa-solid fa-circle-check" style="color: #198754;"></i>';
$query = "SELECT i.idProducto, i.nombreProducto, i.cantidad, i.descripcion, i.idCategoria, c.nombreCategoria 
          FROM inventario i
          JOIN categorias c ON i.idCategoria = c.idCategoria";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Connection failed: " . mysqli_error($connection));
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $checkQuery = "SELECT * FROM alertasProductos WHERE idProducto = '{$row['idProducto']}'";
        $checkResult = mysqli_query($connection, $checkQuery);

        if (!$checkResult) {
            die("Error: " . mysqli_error($connection));
        }

        $alert = mysqli_fetch_assoc($checkResult);

        if ($row['cantidad'] < 5 && $row['cantidad'] > 0) {
            $descripcionAlerta = "Producto limitado";
        } elseif ($row['cantidad'] <= 0) {
            $descripcionAlerta = "Producto AGOTADO";
        } else {
            $descripcionAlerta = "";
        }

        if ($alert) {
            if ($row['cantidad'] >= 5) {
                // Eliminar la alerta si el producto tiene más de 10 unidades
                $deleteQuery = "DELETE FROM alertasProductos WHERE idProducto = '{$row['idProducto']}'";
                $deleteResult = mysqli_query($connection, $deleteQuery);

                if (!$deleteResult) {
                    die("Error: " . mysqli_error($connection));
                }
            } else {
                // Si la descripción ha cambiado, actualiza la alerta
                $updateQuery = "UPDATE alertasProductos 
                                SET descripcionAlerta = '$descripcionAlerta' 
                                WHERE idProducto = '{$row['idProducto']}'";
                $updateResult = mysqli_query($connection, $updateQuery);

                if (!$updateResult) {
                    die("Error: " . mysqli_error($connection));
                }
            }
        } elseif ($descripcionAlerta !== "") {
            // Insert new alert if description is not empty
            $insertQuery = "INSERT INTO alertasProductos (descripcionAlerta, idProducto) 
                            VALUES ('$descripcionAlerta', '{$row['idProducto']}')";
            $insertResult = mysqli_query($connection, $insertQuery);

            if (!$insertResult) {
                die("Error: " . mysqli_error($connection));
            }
        }
    }
}

$query = "SELECT a.idAlerta, a.descripcionAlerta, a.idProducto, i.nombreProducto, i.cantidad, i.idCategoria, c.nombreCategoria 
          FROM alertasProductos a
          JOIN inventario i ON a.idProducto = i.idProducto
          JOIN categorias c ON i.idCategoria = c.idCategoria";

$query .= " ORDER BY a.descripcionAlerta ASC";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Connection failed: " . mysqli_error($connection));
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td>
                <?php echo $row['descripcionAlerta'] ?>
            </td>
            <td>
                <?php echo $row['nombreProducto'] ?>
            </td>
            <td>
                <?php echo $row['nombreCategoria'] ?>
            </td>
            <td>
                <?php echo $row['cantidad'] ?>
            </td>
        </tr>
        <?php
    }
}
?>