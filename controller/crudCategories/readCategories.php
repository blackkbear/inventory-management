<?php

include (__DIR__ . "/../../model/connectiondb.php");

if (!isset ($_SESSION["nombreUsuario"])) {
    header("Location: ../../index.php");
    exit; /*previene mas ejecuciones de scripts*/
}


/* Si no hay usuario, nos mandara al login*/

/*Read Categories */
$query = "SELECT * from categorias";
$result = mysqli_query($connection, $query);
if (!$result) {
    die ("Connection failed" . mysqli_error($connection));
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td>
                <?php echo $row['idCategoria'] ?>
            </td>
            <td>
                <?php echo $row['nombreCategoria'] ?>
            </td>

            <td>

                <!--class btn se usa para fetchear data de category y mostrarla en editar modal-->
                <button class="btnEditCategory" data-bs-toggle="modal" data-bs-target="#modalEditCategory">Editar</button>

                <button class="btnDeleteCategory" data-bs-toggle="modal" data-bs-target="#modalDeleteCategory">Eliminar</button>
            </td>
        </tr>
        <?php
    }
}


?>